<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Note;
use App\Models\NoteFile;
use App\Models\Purchase;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
     * Strona główna - katalog publicznych notatek z pozycjonowaniem VIP (Boost).
     */
    public function index()
    {
        $notes = Note::with(['author', 'files'])
            ->select('notes.*')
            ->join('users', 'notes.user_id', '=', 'users.id') // Łączymy z tabelą użytkowników, żeby sprawdzić rangę autora
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('users.is_vip') // NAJPIERW: Autorzy z kontem VIP (Wyróżnione)
            ->latest('notes.created_at')  // POTEM: Od najnowszych
            ->get();

        return view('index', compact('notes'));
    }

    /**
     * Podstrona pojedynczej notatki (podgląd, zakup, oceny, przeglądanie stron).
     */
    public function show(Request $request, Note $note)
    {
        $note->load(['author', 'files', 'reviews.reviewer']);

        $user        = $request->user();
        // ADMIN DOSTAJE DOSTĘP Z AUTOMATU
        $hasAccess   = $note->isAccessibleBy($user) || ($user && $user->isAdmin());
        $isPurchased = $note->isPurchasedBy($user);
        // ADMIN JEST TRAKTOWANY JAK WŁAŚCICIEL
        $isOwner     = $user && ($note->user_id === $user->id || $user->isAdmin());
        $isFavorited = $note->isFavoritedBy($user);

        // Wyświetlenie: raz na sesję, bez liczenia własnych podglądów autora
        $seen = $request->session()->get('viewed_notes', []);
        if (! $isOwner && ! in_array($note->id, $seen, true)) {
            $note->increment('views');
            $seen[] = $note->id;
            $request->session()->put('viewed_notes', $seen);
        }

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
     * Strona podsumowania zamówienia przed przekierowaniem do Stripe.
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
     * Rozpoczęcie płatności przez Stripe Checkout.
     * Tworzy sesję płatności i przekierowuje użytkownika na bezpieczną stronę Stripe.
     */
    public function processPayment(Request $request, Note $note)
    {
        $user = $request->user();

        if ($note->user_id === $user->id || $note->isPurchasedBy($user)) {
            return redirect()->route('notes.show', $note);
        }

        // Notatka darmowa — natychmiastowy dostęp, bez płatności
        if ($note->isFree()) {
            Purchase::firstOrCreate(
                ['user_id' => $user->id, 'note_id' => $note->id],
                ['amount' => 0, 'payment_method' => 'free', 'status' => 'completed', 'transaction_ref' => 'FREE-' . Str::upper(Str::random(10))]
            );

            return redirect()->route('notes.show', $note)->with('success', 'Notatka odblokowana!');
        }

        if (! config('services.stripe.secret')) {
            return back()->with('error', 'Płatności nie są jeszcze skonfigurowane. Uzupełnij klucze Stripe w pliku .env.');
        }

        try {
            $response = $this->stripeClient()->post('https://api.stripe.com/v1/checkout/sessions', [
                'mode'           => 'payment',
                'success_url'    => route('notes.payment.success', $note) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'     => route('notes.checkout', $note),
                'customer_email' => $user->email,
                'line_items'     => [[
                    'quantity'   => 1,
                    'price_data' => [
                        'currency'     => 'pln',
                        'unit_amount'  => (int) round($note->price * 100),
                        'product_data' => ['name' => $note->title],
                    ],
                ]],
                'metadata' => [
                    'note_id' => $note->id,
                    'user_id' => $user->id,
                ],
            ]);
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Nie udało się połączyć z systemem płatności. Spróbuj ponownie za chwilę.');
        }

        if (! $response->successful() || ! $response->json('url')) {
            report(new \RuntimeException('Stripe checkout error: ' . $response->body()));

            return back()->with('error', 'Nie udało się rozpocząć płatności. Spróbuj ponownie później.');
        }

        return redirect()->away($response->json('url'));
    }

    /**
     * Powrót ze Stripe po płatności — weryfikacja sesji i utworzenie zakupu.
     */
    public function paymentSuccess(Request $request, Note $note)
    {
        $user      = $request->user();
        $sessionId = $request->query('session_id');

        if (! $sessionId) {
            return redirect()->route('notes.show', $note);
        }

        if ($note->isPurchasedBy($user)) {
            return redirect()->route('notes.show', $note)->with('success', 'Masz już dostęp do tej notatki.');
        }

        if (! config('services.stripe.secret')) {
            return redirect()->route('notes.show', $note)->with('error', 'Płatności nie są skonfigurowane.');
        }

        try {
            $session = $this->stripeClient()->get("https://api.stripe.com/v1/checkout/sessions/{$sessionId}");
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('notes.show', $note)
                ->with('error', 'Nie udało się zweryfikować płatności. Jeśli pobraliśmy środki, skontaktuj się z nami.');
        }

        $paid       = $session->successful() && $session->json('payment_status') === 'paid';
        $matchesYou = (int) $session->json('metadata.note_id') === $note->id
            && (int) $session->json('metadata.user_id') === $user->id;

        if ($paid && $matchesYou) {
            Purchase::firstOrCreate(
                ['user_id' => $user->id, 'note_id' => $note->id],
                [
                    'amount'          => $note->price,
                    'payment_method'  => 'card',
                    'status'          => 'completed',
                    'transaction_ref' => $session->json('payment_intent') ?? $sessionId,
                ]
            );

            return redirect()->route('notes.show', $note)
                ->with('success', 'Płatność zakończona sukcesem! Masz teraz pełny dostęp do notatki.');
        }

        return redirect()->route('notes.show', $note)
            ->with('error', 'Płatność nie została potwierdzona. Jeśli pobraliśmy środki, skontaktuj się z nami.');
    }

    /**
     * Podgląd okładki (pliku głównego).
     * - Gość: otrzymuje wyłącznie serwerowo rozmyty obraz przykładowy (prawdziwy plik NIE jest wysyłany,
     * więc nie da się go odsłonić edytując CSS).
     * - Zalogowany użytkownik: widzi prawdziwą pierwszą stronę (okładkę).
     */
    public function preview(Request $request, Note $note)
    {
        // Gość — zwracamy rozmyty placeholder (bez prawdziwej treści)
        if (! $request->user()) {
            return response($this->buildBlurredPlaceholderSvg($note), 200, [
                'Content-Type'  => 'image/svg+xml',
                'Cache-Control' => 'no-store',
            ]);
        }

        $main = $note->mainFile();
        abort_unless($main && Storage::disk('local')->exists($main->path), 404);

        return response()->file(Storage::disk('local')->path($main->path));
    }

    /**
     * Wygenerowana okładka (SVG) w stylu notatek przykładowych — używana w katalogu/profilu,
     * gdy notatka nie ma obrazu jako pliku głównego (np. sam plik PDF). Zastępuje zwykłą ikonę.
     */
    public function cover(Note $note)
    {
        return response($this->buildCoverSvg($note), 200, [
            'Content-Type'  => 'image/svg+xml',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    /**
     * Streamowanie konkretnego pliku notatki — tylko dla autora, kupujących lub notatek darmowych.
     * Używane przez przeglądarkę kolejnych stron.
     */
    public function file(Request $request, Note $note, NoteFile $file): BinaryFileResponse
    {
        abort_unless($file->note_id === $note->id, 404);
        abort_unless($note->isAccessibleBy($request->user()) || ($request->user() && $request->user()->isAdmin()), 403, 'Musisz kupić tę notatkę, aby zobaczyć kolejne strony.');
        abort_unless(Storage::disk('local')->exists($file->path), 404);

        return response()->file(Storage::disk('local')->path($file->path));
    }

    /**
     * Pobranie pełnej zawartości — tylko dla autora, kupujących lub notatek darmowych.
     * Wiele plików → archiwum ZIP.
     */
    public function download(Request $request, Note $note)
    {
        abort_unless($note->isAccessibleBy($request->user()) || ($request->user() && $request->user()->isAdmin()), 403, 'Musisz kupić tę notatkę, aby ją pobrać.');
        
        $files = $note->files;
        abort_if($files->isEmpty(), 404);

        // Pojedynczy plik — pobranie bezpośrednie
        if ($files->count() === 1) {
            $file = $files->first();
            $abs  = Storage::disk('local')->path($file->path);
            abort_unless(is_file($abs), 404);

            $name = $file->original_name ?: Str::slug($note->title) . '.' . pathinfo($file->path, PATHINFO_EXTENSION);

            return $this->streamDownloadAndCount($note, $abs, $name);
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

        return $this->streamDownloadAndCount($note, $zipPath, $zipName, true);
    }

    /**
     * Strumieniuje plik do pobrania i zwiększa licznik pobrań DOPIERO po pełnym przesłaniu.
     * Jeśli użytkownik przerwie transfer (anuluje pobieranie), połączenie zostaje zerwane,
     * skrypt nie dochodzi do inkrementacji i pobranie NIE jest zaliczane.
     */
    private function streamDownloadAndCount(Note $note, string $absPath, string $downloadName, bool $deleteAfter = false): StreamedResponse
    {
        return response()->streamDownload(function () use ($absPath, $note, $deleteAfter) {
            $handle = fopen($absPath, 'rb');
            if ($handle !== false) {
                while (! feof($handle) && ! connection_aborted()) {
                    echo fread($handle, 8192);
                    flush();
                }
                fclose($handle);
            }

            // Zaliczamy pobranie tylko, gdy klient odebrał całość bez przerwania transferu
            if (! connection_aborted()) {
                $note->increment('downloads');
            }

            if ($deleteAfter && is_file($absPath)) {
                @unlink($absPath);
            }
        }, $downloadName);
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

    /**
     * Klient HTTP do Stripe z poprawnie skonfigurowanym pakietem certyfikatów CA.
     * Na Windowsie PHP często nie ma ustawionego curl.cainfo — dlatego dołączamy
     * własny pakiet (storage/certs/cacert.pem). Gdy go brak, lokalnie pomijamy
     * weryfikację SSL (klucze testowe), aby aplikacja działała mimo to.
     */
    private function stripeClient(): \Illuminate\Http\Client\PendingRequest
    {
        $client = Http::asForm()
            ->timeout(25)
            ->withToken(config('services.stripe.secret'));

        $caBundle = storage_path('certs/cacert.pem');

        if (is_file($caBundle)) {
            return $client->withOptions(['verify' => $caBundle]);
        }

        if (app()->environment('local')) {
            return $client->withoutVerifying();
        }

        return $client;
    }

    private function authorizeOwner(Request $request, Note $note): void
    {
        // Puszczamy, jeśli to właściciel LUB jeśli zalogowany jest admin
        abort_unless($request->user() && ($note->user_id === $request->user()->id || $request->user()->isAdmin()), 403);
    }

    /**
     * Kolor wiodący dla danej kategorii (spójny z notatkami przykładowymi).
     */
    private function categoryColor(?string $category): string
    {
        return [
            'Matematyka' => '#06b6d4', 'Medycyna' => '#ef4444', 'Informatyka' => '#3b82f6',
            'Prawo' => '#f59e0b', 'Ekonomia' => '#10b981', 'Języki Obce' => '#64748b',
            'Fizyka' => '#8b5cf6', 'Chemia' => '#84cc16',
        ][$category] ?? '#6366f1';
    }

    /**
     * Buduje ładną okładkę-podgląd (SVG) w stylu notatek przykładowych:
     * pasek kategorii, tytuł i imitacja tekstu. Używana, gdy nie ma realnego obrazu okładki.
     */
    private function buildCoverSvg(Note $note): string
    {
        $color   = $this->categoryColor($note->category);
        $safeCat = htmlspecialchars($note->category ?? '', ENT_QUOTES | ENT_XML1, 'UTF-8');
        $safeTitle = htmlspecialchars($note->title ?? '', ENT_QUOTES | ENT_XML1, 'UTF-8');

        // Zawijanie tytułu do maks. 3 linii
        $words = explode(' ', $safeTitle);
        $hLines = [];
        $cur = '';
        foreach ($words as $word) {
            if (mb_strlen($cur . ' ' . $word) > 26) {
                $hLines[] = trim($cur);
                $cur = $word;
            } else {
                $cur .= ' ' . $word;
            }
        }
        $hLines[] = trim($cur);
        $hLines = array_slice($hLines, 0, 3);

        $titleTspans = '';
        foreach ($hLines as $k => $line) {
            $y = 150 + ($k * 34);
            $titleTspans .= "<text x='60' y='{$y}' font-family='Segoe UI, Arial, sans-serif' font-size='26' font-weight='700' fill='#0f172a'>{$line}</text>";
        }

        $bodyLines = '';
        for ($l = 0; $l < 14; $l++) {
            $y = 280 + ($l * 26);
            $w = [420, 460, 380, 440, 300][($l + $note->id) % 5];
            $bodyLines .= "<rect x='60' y='{$y}' width='{$w}' height='9' rx='4.5' fill='#e2e8f0'/>";
        }

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="595" height="842" viewBox="0 0 595 842">
  <rect width="595" height="842" fill="#ffffff"/>
  <rect x="0" y="0" width="595" height="14" fill="{$color}"/>
  <rect x="60" y="60" width="120" height="26" rx="13" fill="{$color}" opacity="0.15"/>
  <text x="120" y="78" text-anchor="middle" font-family="Segoe UI, Arial, sans-serif" font-size="13" font-weight="700" fill="{$color}">{$safeCat}</text>
  {$titleTspans}
  <rect x="60" y="230" width="475" height="2" fill="#cbd5e1"/>
  {$bodyLines}
  <text x="297" y="800" text-anchor="middle" font-family="Segoe UI, Arial, sans-serif" font-size="12" fill="#94a3b8">Noted — podgląd</text>
</svg>
SVG;
    }

    private function buildBlurredPlaceholderSvg(Note $note): string
    {
        $color = $this->categoryColor($note->category);

        // Sztuczne, rozmyte "linie tekstu"
        $lines = '';
        for ($i = 0; $i < 16; $i++) {
            $y = 250 + ($i * 30);
            $w = [430, 470, 360, 450, 300, 410][($i + $note->id) % 6];
            $lines .= "<rect x='70' y='{$y}' width='{$w}' height='12' rx='6' fill='#cbd5e1'/>";
        }

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="595" height="842" viewBox="0 0 595 842">
  <defs>
    <filter id="blur" x="-20%" y="-20%" width="140%" height="140%">
      <feGaussianBlur stdDeviation="9"/>
    </filter>
  </defs>
  <rect width="595" height="842" fill="#ffffff"/>
  <g filter="url(#blur)">
    <rect x="0" y="0" width="595" height="16" fill="{$color}"/>
    <rect x="70" y="70" width="180" height="34" rx="17" fill="{$color}" opacity="0.18"/>
    <rect x="70" y="130" width="380" height="26" rx="8" fill="#94a3b8"/>
    <rect x="70" y="170" width="300" height="26" rx="8" fill="#94a3b8"/>
    <rect x="60" y="225" width="475" height="3" fill="#cbd5e1"/>
    {$lines}
  </g>
</svg>
SVG;
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