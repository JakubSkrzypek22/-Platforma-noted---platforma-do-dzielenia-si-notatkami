<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Note;
use App\Models\NoteFile;
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
        $notes = Note::with(['author', 'files'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->latest()
            ->get();

        return view('index', compact('notes'));
    }

    /**
     * Podstrona pojedynczej notatki (podgląd, zakup, oceny, przeglądanie stron).
     */
    public function show(Request $request, Note $note)
    {
        $note->load(['author', 'files', 'reviews.reviewer']);
        $note->increment('views');

        $user        = $request->user();
        $hasAccess   = $note->isAccessibleBy($user);
        $isPurchased = $note->isPurchasedBy($user);
        $isOwner     = $user && $note->user_id === $user->id;
        $isFavorited = $note->isFavoritedBy($user);

        $canReview = $isPurchased && ! $isOwner
            && ! $note->reviews()->where('user_id', $user->id)->exists();

        return view('notes.show', compact(
            'note', 'hasAccess', 'isPurchased', 'isOwner', 'canReview', 'isFavorited'
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
     * Zapis nowej notatki wraz z plikami (pdf / jpg / png). Można dodać kilka plików.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category'    => 'required|string|in:' . implode(',', self::CATEGORIES),
            'university'  => 'nullable|string|max:255',
            'price'       => 'required|numeric|min:0|max:99999',
            'files'       => 'required|array|min:1',
            'files.*'     => 'file|mimes:pdf,jpg,jpeg,png|max:20480', // do 20 MB / plik
            'main_index'  => 'nullable|integer|min:0',
        ], [], [
            'files'   => 'pliki notatki',
            'files.*' => 'plik notatki',
        ]);

        $note = Note::create([
            'user_id'     => $request->user()->id,
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'category'    => $validated['category'],
            'university'  => $validated['university'] ?? null,
            'price'       => $validated['price'],
        ]);

        $mainIndex = (int) ($validated['main_index'] ?? 0);

        foreach ($request->file('files') as $i => $file) {
            $this->storeNoteFile($note, $file, $i, $i === $mainIndex);
        }

        $this->ensureSingleMain($note);

        return redirect()
            ->route('notes.show', $note)
            ->with('success', 'Notatka została opublikowana!');
    }

    /**
     * Formularz edycji własnej notatki.
     */
    public function edit(Request $request, Note $note)
    {
        $this->authorizeOwner($request, $note);
        $note->load('files');

        return view('notes.edit', [
            'note'       => $note,
            'categories' => self::CATEGORIES,
        ]);
    }

    /**
     * Aktualizacja własnej notatki (dane + dodatkowe pliki + wybór głównego pliku).
     */
    public function update(Request $request, Note $note)
    {
        $this->authorizeOwner($request, $note);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'category'     => 'required|string|in:' . implode(',', self::CATEGORIES),
            'university'   => 'nullable|string|max:255',
            'price'        => 'required|numeric|min:0|max:99999',
            'new_files'    => 'nullable|array',
            'new_files.*'  => 'file|mimes:pdf,jpg,jpeg,png|max:20480',
            'main_file_id' => 'nullable|integer',
        ]);

        $note->update([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'category'    => $validated['category'],
            'university'  => $validated['university'] ?? null,
            'price'       => $validated['price'],
        ]);

        if ($request->hasFile('new_files')) {
            $position = (int) ($note->files()->max('position') ?? -1);
            foreach ($request->file('new_files') as $file) {
                $this->storeNoteFile($note, $file, ++$position, false);
            }
        }

        // Ustawienie pliku głównego, jeśli wskazano istniejący plik
        if (! empty($validated['main_file_id'])) {
            $target = $note->files()->find($validated['main_file_id']);
            if ($target) {
                $note->files()->update(['is_main' => false]);
                $target->update(['is_main' => true]);
            }
        }

        $note->load('files');
        $this->ensureSingleMain($note);

        return redirect()->route('notes.show', $note)->with('success', 'Notatka zaktualizowana.');
    }

    /**
     * Usunięcie własnej notatki wraz z plikami.
     */
    public function destroy(Request $request, Note $note)
    {
        $this->authorizeOwner($request, $note);

        foreach ($note->files as $file) {
            Storage::disk('local')->delete($file->path);
        }
        $note->delete(); // kaskadowo usuwa pliki, zakupy, oceny

        return redirect()->route('dashboard')->with('success', 'Notatka została usunięta.');
    }

    /**
     * Usunięcie pojedynczego pliku z notatki (z poziomu edycji).
     */
    public function destroyFile(Request $request, Note $note, NoteFile $file)
    {
        $this->authorizeOwner($request, $note);
        abort_unless($file->note_id === $note->id, 404);

        if ($note->files()->count() <= 1) {
            return back()->with('success', 'Notatka musi mieć co najmniej jeden plik.');
        }

        $wasMain = $file->is_main;
        Storage::disk('local')->delete($file->path);
        $file->delete();

        if ($wasMain) {
            $note->load('files');
            $this->ensureSingleMain($note);
        }

        return back()->with('success', 'Plik został usunięty.');
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
     * Podgląd okładki (pliku głównego) — publiczny; dla gościa rozmyty po stronie widoku.
     */
    public function preview(Note $note): BinaryFileResponse
    {
        $main = $note->mainFile();
        abort_unless($main && Storage::disk('local')->exists($main->path), 404);

        return response()->file(Storage::disk('local')->path($main->path));
    }

    /**
     * Streamowanie konkretnego pliku notatki — tylko dla autora, kupujących lub notatek darmowych.
     * Używane przez przeglądarkę kolejnych stron.
     */
    public function file(Request $request, Note $note, NoteFile $file): BinaryFileResponse
    {
        abort_unless($file->note_id === $note->id, 404);
        abort_unless($note->isAccessibleBy($request->user()), 403, 'Musisz kupić tę notatkę, aby zobaczyć kolejne strony.');
        abort_unless(Storage::disk('local')->exists($file->path), 404);

        return response()->file(Storage::disk('local')->path($file->path));
    }

    /**
     * Pobranie pełnej zawartości — tylko dla autora, kupujących lub notatek darmowych.
     * Wiele plików → archiwum ZIP.
     */
    public function download(Request $request, Note $note)
    {
        abort_unless($note->isAccessibleBy($request->user()), 403, 'Musisz kupić tę notatkę, aby ją pobrać.');

        $files = $note->files;
        abort_if($files->isEmpty(), 404);

        $note->increment('downloads');

        // Pojedynczy plik — pobranie bezpośrednie
        if ($files->count() === 1) {
            $file = $files->first();
            abort_unless(Storage::disk('local')->exists($file->path), 404);

            $name = $file->original_name ?: Str::slug($note->title) . '.' . pathinfo($file->path, PATHINFO_EXTENSION);

            return response()->download(Storage::disk('local')->path($file->path), $name);
        }

        // Wiele plików — pakujemy do archiwum ZIP
        $zipName = Str::slug($note->title) . '.zip';
        $zipPath = storage_path('app/tmp-' . Str::random(10) . '.zip');

        $zip = new \ZipArchive();
        $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($files as $idx => $file) {
            $abs = Storage::disk('local')->path($file->path);
            if (is_file($abs)) {
                $entry = ($idx + 1) . '-' . ($file->original_name ?: ('plik.' . pathinfo($file->path, PATHINFO_EXTENSION)));
                $zip->addFile($abs, $entry);
            }
        }
        $zip->close();

        return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
    }

    /**
     * Dodanie / usunięcie notatki z ulubionych.
     */
    public function toggleFavorite(Request $request, Note $note)
    {
        $user = $request->user();

        $favorite = Favorite::where('user_id', $user->id)->where('note_id', $note->id)->first();

        if ($favorite) {
            $favorite->delete();
            $favorited = false;
            $message = 'Usunięto z ulubionych.';
        } else {
            Favorite::create(['user_id' => $user->id, 'note_id' => $note->id]);
            $favorited = true;
            $message = 'Dodano do ulubionych.';
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['favorited' => $favorited, 'message' => $message]);
        }

        return back()->with('success', $message);
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

    // ============================================================
    // POMOCNICZE
    // ============================================================

    private function authorizeOwner(Request $request, Note $note): void
    {
        abort_unless($request->user() && $note->user_id === $request->user()->id, 403);
    }

    private function storeNoteFile(Note $note, $file, int $position, bool $isMain): NoteFile
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $fileType  = $extension === 'pdf' ? 'pdf' : 'image';

        $path = $file->storeAs('notes', Str::uuid() . '.' . $extension, 'local');

        return $note->files()->create([
            'path'          => $path,
            'file_type'     => $fileType,
            'original_name' => $file->getClientOriginalName(),
            'is_main'       => $isMain,
            'position'      => $position,
        ]);
    }

    /**
     * Gwarantuje, że dokładnie jeden plik jest oznaczony jako główny.
     */
    private function ensureSingleMain(Note $note): void
    {
        $files = $note->files()->get();
        if ($files->isEmpty()) {
            return;
        }

        $mains = $files->where('is_main', true);

        if ($mains->count() === 1) {
            return;
        }

        $note->files()->update(['is_main' => false]);
        $first = $mains->first() ?? $files->first();
        $first->update(['is_main' => true]);
    }
}
