<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Purchase;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class NoteController extends Controller
{
    /**
     * Lista kategorii używana w formularzach i filtrach.
     */
    public const CATEGORIES = [
        'Informatyka', 'Medycyna', 'Prawo', 'Matematyka',
        'Ekonomia', 'Języki Obce', 'Fizyka', 'Chemia',
    ];

    /**
     * Strona główna - katalog publicznych notatek.
     */
    public function index()
    {
        $notes = Note::with('author')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->latest()
            ->get();

        return view('index', compact('notes'));
    }

    /**
     * Podstrona pojedynczej notatki (podgląd 1. strony, zakup, oceny).
     */
    public function show(Request $request, Note $note)
    {
        $note->load(['author', 'reviews.reviewer']);
        $note->increment('views');

        $user        = $request->user();
        $hasAccess   = $note->isAccessibleBy($user);
        $isPurchased = $note->isPurchasedBy($user);
        $isOwner     = $user && $note->user_id === $user->id;

        // Czy zalogowany kupujący może wystawić ocenę (kupił, nie jest autorem, jeszcze nie oceniał).
        $canReview = $isPurchased && ! $isOwner
            && ! $note->reviews()->where('user_id', $user->id)->exists();

        return view('notes.show', compact(
            'note', 'hasAccess', 'isPurchased', 'isOwner', 'canReview'
        ));
    }

    /**
     * Formularz dodawania nowej notatki.
     */
    public function create()
    {
        return view('notes.create', ['categories' => self::CATEGORIES]);
    }

    /**
     * Zapis nowej notatki wraz z plikiem (pdf / jpg / png).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category'    => 'required|string|in:' . implode(',', self::CATEGORIES),
            'university'  => 'nullable|string|max:255',
            'price'       => 'required|numeric|min:0|max:99999',
            'file'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:20480', // do 20 MB
        ], [], [
            'file' => 'plik notatki',
        ]);

        $file      = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $fileType  = $extension === 'pdf' ? 'pdf' : 'image';

        // Plik trzymamy na prywatnym dysku - dostęp tylko przez kontroler.
        $path = $file->storeAs(
            'notes',
            Str::uuid() . '.' . $extension,
            'local'
        );

        $note = Note::create([
            'user_id'       => $request->user()->id,
            'title'         => $validated['title'],
            'description'   => $validated['description'],
            'category'      => $validated['category'],
            'university'    => $validated['university'] ?? null,
            'price'         => $validated['price'],
            'file_path'     => $path,
            'file_type'     => $fileType,
            'original_name' => $file->getClientOriginalName(),
        ]);

        return redirect()
            ->route('notes.show', $note)
            ->with('success', 'Notatka została opublikowana!');
    }

    /**
     * Symulowana strona płatności (checkout) imitująca realny proces.
     */
    public function checkout(Request $request, Note $note)
    {
        $user = $request->user();

        if ($note->user_id === $user->id) {
            return redirect()->route('notes.show', $note)
                ->with('success', 'To jest Twoja notatka — masz do niej pełny dostęp.');
        }

        if ($note->isFree() || $note->isPurchasedBy($user)) {
            return redirect()->route('notes.show', $note)
                ->with('success', 'Masz już dostęp do tej notatki.');
        }

        $note->load('author');

        return view('notes.checkout', compact('note'));
    }

    /**
     * Przetworzenie symulowanej płatności i utworzenie zakupu.
     * Karta NIE jest realnie obciążana — proces tylko imituje bramkę płatniczą.
     */
    public function processPayment(Request $request, Note $note)
    {
        $user = $request->user();

        if ($note->user_id === $user->id || $note->isPurchasedBy($user)) {
            return redirect()->route('notes.show', $note);
        }

        $request->validate([
            'card_name'   => 'required|string|max:255',
            'card_number' => 'required|string',
            'card_expiry' => 'required|string',
            'card_cvc'    => 'required|string',
        ], [
            'card_name.required'   => 'Podaj imię i nazwisko właściciela karty.',
            'card_number.required' => 'Podaj numer karty.',
            'card_expiry.required' => 'Podaj datę ważności karty.',
            'card_cvc.required'    => 'Podaj kod CVC.',
        ]);

        // Walidacja formatu (symulacja — żadne dane karty nie są zapisywane).
        $digits = preg_replace('/\D/', '', $request->input('card_number'));
        if (strlen($digits) < 13 || strlen($digits) > 19) {
            return back()->withErrors(['card_number' => 'Nieprawidłowy numer karty.'])->withInput();
        }
        if (! preg_match('/^\d{3,4}$/', $request->input('card_cvc'))) {
            return back()->withErrors(['card_cvc' => 'Nieprawidłowy kod CVC.'])->withInput();
        }

        Purchase::create([
            'user_id'         => $user->id,
            'note_id'         => $note->id,
            'amount'          => $note->price,
            'payment_method'  => 'card',
            'status'          => 'completed',
            'transaction_ref' => 'SIM-' . strtoupper(Str::random(12)),
        ]);

        return redirect()->route('notes.show', $note)
            ->with('success', 'Płatność zakończona sukcesem! Masz teraz pełny dostęp do notatki.');
    }

    /**
     * Podgląd 1. strony notatki — dostępny publicznie (dla gościa rozmyty po stronie widoku).
     * Dla PDF serwujemy plik inline; PDF.js renderuje wyłącznie pierwszą stronę.
     */
    public function preview(Note $note): BinaryFileResponse
    {
        abort_unless($note->file_path && Storage::disk('local')->exists($note->file_path), 404);

        return response()->file(Storage::disk('local')->path($note->file_path));
    }

    /**
     * Pobranie pełnego pliku — tylko dla autora, kupujących lub notatek darmowych.
     */
    public function download(Request $request, Note $note): BinaryFileResponse
    {
        abort_unless($note->isAccessibleBy($request->user()), 403, 'Musisz kupić tę notatkę, aby ją pobrać.');
        abort_unless($note->file_path && Storage::disk('local')->exists($note->file_path), 404);

        $note->increment('downloads');

        $downloadName = $note->original_name
            ?: Str::slug($note->title) . '.' . pathinfo($note->file_path, PATHINFO_EXTENSION);

        return response()->download(Storage::disk('local')->path($note->file_path), $downloadName);
    }

    /**
     * Zapis oceny sprzedawcy po zakupie notatki.
     */
    public function storeReview(Request $request, Note $note)
    {
        $user = $request->user();

        abort_unless($note->isPurchasedBy($user), 403, 'Tylko kupujący mogą wystawić ocenę.');

        if ($note->user_id === $user->id) {
            return back()->with('success', 'Nie możesz oceniać własnej notatki.');
        }

        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Wybierz ocenę w skali 1–5 gwiazdek.',
        ]);

        Review::updateOrCreate(
            ['user_id' => $user->id, 'note_id' => $note->id],
            [
                'seller_id' => $note->user_id,
                'rating'    => $validated['rating'],
                'comment'   => $validated['comment'] ?? null,
            ]
        );

        return redirect()->route('notes.show', $note)
            ->with('success', 'Dziękujemy za wystawienie oceny sprzedawcy!');
    }
}
