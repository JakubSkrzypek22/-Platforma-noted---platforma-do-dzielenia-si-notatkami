@extends('layouts.app')

@section('content')
@include('shared.navbar')

@php
    $avg   = $note->averageRating();
    $count = $note->reviewsCount();
    $sellerRating = $note->author?->sellerRating() ?? 0;
    $sellerCount  = $note->author?->sellerReviewsCount() ?? 0;
    $main = $note->mainFile();
    $fileSources = $note->files->map(fn ($f) => [
        'type' => $f->file_type,
        'url'  => route('notes.files.show', [$note, $f]),
    ])->values();
@endphp

<style>
    .preview-stage {
        position: relative;
        border-radius: 1rem;
        overflow: hidden;
        background: #1e293b;
        /* Stała wysokość — strony (obraz/PDF) o różnych proporcjach mieszczą się w tym samym kadrze,
           dzięki czemu przyciski nawigacji nie przeskakują. */
        height: 70vh;
        min-height: 420px;
        max-height: 760px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .preview-stage .preview-media { width: 100%; height: 100%; }
    .preview-stage canvas,
    .preview-stage img {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        margin: auto;
        display: block;
        object-fit: contain;
    }
    .preview-locked .preview-media {
        filter: blur(14px);
        transform: scale(1.05);
        pointer-events: none;
        user-select: none;
    }
    .preview-overlay {
        position: absolute; inset: 0;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        text-align: center;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(2px);
        color: #fff; padding: 1.5rem; z-index: 5;
    }
    .pager-btn {
        width: 44px; height: 44px; border-radius: 9999px;
        display: flex; align-items: center; justify-content: center;
        background: var(--color-card-bg); border: 1px solid var(--color-border);
        color: var(--color-text-body); transition: all 0.2s ease;
    }
    .pager-btn:hover:not(:disabled) { background: var(--color-primary); color: #fff; border-color: var(--color-primary); }
    .pager-btn:disabled { opacity: 0.4; cursor: not-allowed; }
    .star-input { cursor: pointer; transition: transform 0.15s ease; }
    .star-input:hover { transform: scale(1.2); }
</style>

<main class="flex-grow py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if (session('success'))
            <div class="bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-900/50 text-emerald-700 dark:text-emerald-400 p-4 rounded-xl text-sm flex items-center justify-between shadow-sm mb-6" id="successAlert">
                <span><i class="bi bi-check-circle-fill mr-2"></i>{{ session('success') }}</span>
                <button type="button" onclick="document.getElementById('successAlert').style.display='none'" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"><i class="bi bi-x-lg"></i></button>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/50 text-red-700 dark:text-red-400 p-4 rounded-xl text-sm flex items-center justify-between shadow-sm mb-6" id="errorAlert">
                <span><i class="bi bi-exclamation-triangle-fill mr-2"></i>{{ session('error') }}</span>
                <button type="button" onclick="document.getElementById('errorAlert').style.display='none'" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"><i class="bi bi-x-lg"></i></button>
            </div>
        @endif

        <!-- Okruszki -->
        <nav class="text-sm text-slate-500 dark:text-slate-400 mb-6 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-primary"><i class="bi bi-house-door"></i> Katalog</a>
            <i class="bi bi-chevron-right text-xs"></i>
            <span class="text-text-body font-semibold truncate max-w-xs">{{ $note->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- LEWA KOLUMNA: PODGLĄD / PRZEGLĄDARKA STRON -->
            <div class="lg:col-span-7">

                @if ($hasAccess)
                    {{-- Pełny dostęp: przeglądarka kolejnych stron / plików --}}
                    <div class="preview-stage" id="viewerStage">
                        <div class="preview-media w-full flex items-center justify-center">
                            <canvas id="viewerCanvas" style="display:none;"></canvas>
                            <img id="viewerImage" style="display:none;" alt="Strona notatki">
                            <div id="viewerLoading" class="text-slate-300 text-sm py-20">
                                <i class="bi bi-arrow-repeat animate-spin"></i> Wczytywanie…
                            </div>
                        </div>
                    </div>

                    <!-- Sterowanie stronami -->
                    <div class="mt-4 flex items-center justify-center gap-4">
                        <button class="pager-btn" id="prevPage" title="Poprzednia strona"><i class="bi bi-chevron-left"></i></button>
                        <span class="text-sm font-semibold text-text-body">Strona <span id="curPage">1</span> z <span id="totalPages">…</span></span>
                        <button class="pager-btn" id="nextPage" title="Następna strona"><i class="bi bi-chevron-right"></i></button>
                    </div>

                    <div class="mt-4 flex items-start gap-3 p-4 rounded-xl bg-emerald-50/60 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-900/40 text-sm text-emerald-700 dark:text-emerald-400">
                        <i class="bi bi-unlock-fill text-lg"></i>
                        <span>Masz pełny dostęp — przeglądaj wszystkie strony przyciskami i pobierz komplet plików obok.</span>
                    </div>
                @elseif (auth()->check())
                    {{-- Zalogowany, bez zakupu: prawdziwa pierwsza strona (okładka) --}}
                    <div class="preview-stage"
                         id="coverStage"
                         data-type="{{ $main?->file_type }}"
                         data-url="{{ route('notes.preview', $note) }}">

                        <div class="preview-media w-full flex items-center justify-center">
                            @if ($note->isPdf())
                                <canvas id="coverCanvas"></canvas>
                                <div id="coverLoading" class="text-slate-300 text-sm py-20">
                                    <i class="bi bi-arrow-repeat animate-spin"></i> Wczytywanie podglądu…
                                </div>
                            @else
                                <img src="{{ route('notes.preview', $note) }}" alt="Podgląd notatki">
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 flex items-start gap-3 p-4 rounded-xl bg-slate-100/60 dark:bg-slate-800/40 border border-border text-sm text-slate-500 dark:text-slate-400">
                        <i class="bi bi-eye-fill text-primary text-lg"></i>
                        <span>To podgląd <strong>tylko pierwszej strony</strong>. Kup notatkę, aby przeglądać i pobierać wszystkie strony.</span>
                    </div>
                @else
                    {{-- Gość: serwerowo rozmyty obraz przykładowy — prawdziwa treść NIE jest wysyłana do przeglądarki --}}
                    <div class="preview-stage" id="coverStage">
                        <div class="preview-media w-full flex items-center justify-center">
                            <img src="{{ route('notes.preview', $note) }}" alt="Zablokowany podgląd notatki">
                        </div>

                        <div class="preview-overlay">
                            <i class="bi bi-lock-fill text-4xl mb-3"></i>
                            <h3 class="text-lg font-bold mb-1">Podgląd dostępny po zalogowaniu</h3>
                            <p class="text-white/70 text-sm max-w-xs mb-5">
                                Zaloguj się, aby zobaczyć pierwszą stronę. Kolejne strony odblokujesz po zakupie.
                            </p>
                            <a href="{{ route('login') }}" class="bg-primary hover:bg-primary-hover text-white font-bold py-2.5 px-6 rounded-xl text-sm transition-colors">
                                <i class="bi bi-box-arrow-in-right mr-1.5"></i> Zaloguj się
                            </a>
                        </div>
                    </div>

                    <div class="mt-4 flex items-start gap-3 p-4 rounded-xl bg-slate-100/60 dark:bg-slate-800/40 border border-border text-sm text-slate-500 dark:text-slate-400">
                        <i class="bi bi-lock-fill text-slate-400 text-lg"></i>
                        <span>Podgląd jest rozmyty dla niezalogowanych. Zaloguj się, aby zobaczyć pierwszą stronę, a po zakupie — całość.</span>
                    </div>
                @endif
            </div>

            <!-- PRAWA KOLUMNA: SZCZEGÓŁY, CENA, ZAKUP -->
            <div class="lg:col-span-5">
                <div class="bg-card-bg border border-border rounded-2xl p-6 shadow-sm sticky top-6">

                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary">
                            {{ $note->category }}
                        </span>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-1 text-amber-500 text-sm font-bold">
                                <i class="bi bi-star-fill"></i>
                                <span class="text-text-body">{{ $count ? $avg : '—' }}</span>
                                <span class="text-slate-400 font-normal">({{ $count }})</span>
                            </div>
                            @auth
                                <form action="{{ route('notes.favorite', $note) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="text-xl transition-transform hover:scale-110 {{ $isFavorited ? 'text-red-500' : 'text-slate-400 hover:text-red-500' }}" title="{{ $isFavorited ? 'Usuń z ulubionych' : 'Dodaj do ulubionych' }}">
                                        <i class="bi {{ $isFavorited ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-xl text-slate-400 hover:text-red-500" title="Zaloguj się, aby dodać do ulubionych"><i class="bi bi-heart"></i></a>
                            @endauth
                        </div>
                    </div>
                    @if(auth()->check() && auth()->user()->isAdmin() && !$isPurchased && $note->user_id !== auth()->id())
    <div class="mb-4 p-3 bg-red-500/10 border border-red-500 text-red-500 rounded-xl text-sm font-bold flex items-center justify-center">
        <i class="bi bi-shield-lock-fill mr-2 text-lg"></i> Oglądasz jako Administrator (Blokady zdjęte)
    </div>
@endif
                    <h1 class="text-2xl font-extrabold text-text-body leading-snug mb-2">{{ $note->title }}</h1>

                    @if ($note->university)
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">
                            <i class="bi bi-mortarboard mr-1"></i> {{ $note->university }}
                        </p>
                    @endif

                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed mb-5">{{ $note->description }}</p>

                    <!-- Statystyki -->
                    <div class="grid grid-cols-3 gap-2 text-center mb-6">
                        <div class="p-2 rounded-xl bg-slate-100/60 dark:bg-slate-800/40">
                            <div class="text-lg font-bold text-text-body">{{ $note->files->count() }}</div>
                            <div class="text-[11px] text-slate-400">plików</div>
                        </div>
                        <div class="p-2 rounded-xl bg-slate-100/60 dark:bg-slate-800/40">
                            <div class="text-lg font-bold text-text-body">{{ number_format($note->views) }}</div>
                            <div class="text-[11px] text-slate-400">wyświetleń</div>
                        </div>
                        <div class="p-2 rounded-xl bg-slate-100/60 dark:bg-slate-800/40">
                            <div class="text-lg font-bold text-text-body">{{ number_format($note->downloads) }}</div>
                            <div class="text-[11px] text-slate-400">pobrań</div>
                        </div>
                    </div>

                    <!-- Cena -->
                    <div class="flex items-baseline gap-2 mb-5">
                        @if ($note->isFree())
                            <span class="text-3xl font-extrabold text-emerald-500">Za darmo</span>
                        @else
                            <span class="text-3xl font-extrabold text-text-body">{{ number_format($note->price, 2, ',', ' ') }} zł</span>
                        @endif
                    </div>

                    <!-- Akcja główna -->
                    @if ($hasAccess)
                        <a href="{{ route('notes.download', $note) }}"
                           class="w-full py-3.5 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-md transition-all mb-3">
                            <i class="bi bi-cloud-arrow-down-fill text-lg"></i> Pobierz {{ $note->files->count() > 1 ? 'pliki (ZIP)' : 'plik' }}
                        </a>
                        @if ($isOwner)
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('notes.edit', $note) }}" class="py-2.5 border border-border hover:border-primary hover:text-primary text-text-body rounded-xl font-semibold text-sm flex items-center justify-center gap-1.5 transition-all">
                                    <i class="bi bi-pencil"></i> Edytuj
                                </a>
                                <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Na pewno usunąć tę notatkę?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full py-2.5 border border-red-200 dark:border-red-900/40 text-red-500 hover:bg-red-500/10 rounded-xl font-semibold text-sm flex items-center justify-center gap-1.5 transition-all">
                                        <i class="bi bi-trash3"></i> Usuń
                                    </button>
                                </form>
                            </div>
                        @endif
                    @elseif (auth()->check())
                        <a href="{{ route('notes.checkout', $note) }}"
                           class="w-full py-3.5 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-md transition-all mb-3">
                            <i class="bi bi-cart-fill text-lg"></i> Kup i odblokuj całość
                        </a>
                        <p class="text-center text-xs text-slate-400">Bezpieczna płatność online obsługiwana przez Stripe.</p>
                    @else
                        <a href="{{ route('login') }}"
                           class="w-full py-3.5 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-md transition-all mb-3">
                            <i class="bi bi-box-arrow-in-right text-lg"></i> Zaloguj się, aby kupić
                        </a>
                        <p class="text-center text-xs text-slate-400">Nie masz konta? <a href="{{ route('register') }}" class="text-primary font-semibold">Zarejestruj się</a></p>
                    @endif

                    <!-- Sprzedawca -->
                    <div class="border-t border-border mt-6 pt-5">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Sprzedawca</h4>
                        <div class="flex items-center gap-3">
                            <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($note->author->name ?? 'Noted') }}"
                                 alt="{{ $note->author->name ?? '' }}"
                                 class="w-11 h-11 rounded-full border border-border bg-card-bg">
                            <div>
                                <div class="font-bold text-text-body text-sm">{{ $note->author->name ?? 'Nieznany' }}</div>
                                <div class="flex items-center gap-1 text-xs text-amber-500">
                                    @if($note->author?->isVip())
                    <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 bg-amber-500 text-white rounded text-[10px] font-black uppercase tracking-wide">
                        <i class="bi bi-crown-fill"></i> VIP
                    </span>
                @endif
                                    <i class="bi bi-star-fill"></i>
                                    <span class="text-text-body font-semibold">{{ $sellerCount ? $sellerRating : 'Nowy' }}</span>
                                    <span class="text-slate-400">{{ $sellerCount ? "· {$sellerCount} opinii" : 'sprzedawca' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEKCJA OCEN -->
        <div class="mt-12 max-w-4xl">
            <h2 class="text-xl font-extrabold text-text-body mb-6">
                Oceny i opinie <span class="text-slate-400 font-normal text-base">({{ $count }})</span>
            </h2>

            @if ($canReview)
                <div class="bg-card-bg border border-border rounded-2xl p-6 mb-8">
                    <h3 class="font-bold text-text-body mb-1">Oceń sprzedawcę</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Kupiłeś tę notatkę — podziel się opinią o sprzedawcy.</p>

                    @include('shared.validation-error')

                    <form action="{{ route('notes.reviews.store', $note) }}" method="POST">
                        @csrf
                        <input type="hidden" name="rating" id="ratingValue" value="{{ old('rating', 5) }}">
                        <div class="flex items-center gap-1 mb-4 text-3xl text-slate-300" id="starPicker">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star-fill star-input" data-value="{{ $i }}"></i>
                            @endfor
                        </div>
                        <textarea name="comment" rows="3" maxlength="1000"
                                  class="w-full px-3 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm placeholder-slate-400 resize-none mb-4"
                                  placeholder="Napisz kilka słów o jakości notatki i kontakcie ze sprzedawcą…">{{ old('comment') }}</textarea>
                        <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold text-sm transition-colors">
                            <i class="bi bi-send-fill mr-1.5"></i> Wyślij ocenę
                        </button>
                    </form>
                </div>
            @endif

            <div class="flex flex-col gap-4">
                @forelse ($note->reviews->sortByDesc('created_at') as $review)
                    <div class="bg-card-bg border border-border rounded-2xl p-5">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($review->reviewer->name ?? 'U') }}" class="w-9 h-9 rounded-full border border-border" alt="">
                                <div>
                                    <div class="font-bold text-text-body text-sm">{{ $review->reviewer->name ?? 'Użytkownik' }}</div>
                                    <div class="text-xs text-slate-400">{{ $review->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
    <div class="text-amber-500 text-sm">
        @for ($i = 1; $i <= 5; $i++)
            <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
        @endfor
    </div>
    
    @if(auth()->check() && auth()->user()->isAdmin())
        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Na pewno usunąć tę opinię?');" class="m-0">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500 hover:text-red-700 bg-red-500/10 hover:bg-red-500/20 px-2.5 py-1 rounded-lg text-xs font-bold transition-colors">
                <i class="bi bi-trash3"></i> Usuń
            </button>
        </form>
    @endif
</div>
                        </div>
                        @if ($review->comment)
                            <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">{{ $review->comment }}</p>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-10 text-slate-400">
                        <i class="bi bi-chat-square-dots text-3xl mb-2 block"></i>
                        <p class="text-sm">Brak opinii. Bądź pierwszą osobą, która oceni tę notatkę po zakupie!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</main>

@php $needsPdfJs = $hasAccess ? $note->files->contains(fn ($f) => $f->file_type === 'pdf') : (auth()->check() && $note->isPdf()); @endphp

@if ($needsPdfJs || $hasAccess)
<script type="module">
    import * as pdfjsLib from 'https://cdn.jsdelivr.net/npm/pdfjs-dist@4.5.136/build/pdf.min.mjs';
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdn.jsdelivr.net/npm/pdfjs-dist@4.5.136/build/pdf.worker.min.mjs';

    @if ($hasAccess)
        // ====== PRZEGLĄDARKA WSZYSTKICH STRON ======
        const sources = @json($fileSources);
        const stage   = document.getElementById('viewerStage');
        const canvas  = document.getElementById('viewerCanvas');
        const image   = document.getElementById('viewerImage');
        const loading = document.getElementById('viewerLoading');
        const curEl   = document.getElementById('curPage');
        const totalEl = document.getElementById('totalPages');
        const prevBtn = document.getElementById('prevPage');
        const nextBtn = document.getElementById('nextPage');

        let slides = [];
        let index  = 0;

        async function build() {
            for (const src of sources) {
                if (src.type === 'pdf') {
                    try {
                        const pdf = await pdfjsLib.getDocument(src.url).promise;
                        for (let p = 1; p <= pdf.numPages; p++) {
                            slides.push({ type: 'pdf', pdf, pageNum: p });
                        }
                    } catch (e) { console.error(e); }
                } else {
                    slides.push({ type: 'image', url: src.url });
                }
            }
            if (slides.length === 0) {
                loading.textContent = 'Brak stron do wyświetlenia.';
                return;
            }
            totalEl.textContent = slides.length;
            render();
        }

        async function render() {
            const slide = slides[index];
            curEl.textContent = index + 1;
            prevBtn.disabled = index === 0;
            nextBtn.disabled = index === slides.length - 1;
            loading.style.display = 'none';

            if (slide.type === 'image') {
                canvas.style.display = 'none';
                image.style.display = 'block';
                image.src = slide.url;
            } else {
                image.style.display = 'none';
                canvas.style.display = 'block';
                const page = await slide.pdf.getPage(slide.pageNum);
                const containerWidth = stage.clientWidth || 600;
                const base = page.getViewport({ scale: 1 });
                const scale = Math.min(containerWidth / base.width, 2);
                const viewport = page.getViewport({ scale });
                const ctx = canvas.getContext('2d');
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                await page.render({ canvasContext: ctx, viewport }).promise;
            }
        }

        prevBtn.addEventListener('click', () => { if (index > 0) { index--; render(); } });
        nextBtn.addEventListener('click', () => { if (index < slides.length - 1) { index++; render(); } });
        build();
    @else
        // ====== OKŁADKA: TYLKO STRONA 1 (dla PDF) ======
        const stage   = document.getElementById('coverStage');
        const canvas  = document.getElementById('coverCanvas');
        const loading = document.getElementById('coverLoading');
        (async () => {
            try {
                const pdf = await pdfjsLib.getDocument(stage.dataset.url).promise;
                const page = await pdf.getPage(1);
                const containerWidth = stage.clientWidth || 600;
                const base = page.getViewport({ scale: 1 });
                const scale = Math.min(containerWidth / base.width, 2);
                const viewport = page.getViewport({ scale });
                const ctx = canvas.getContext('2d');
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                await page.render({ canvasContext: ctx, viewport }).promise;
                if (loading) loading.style.display = 'none';
            } catch (e) {
                if (loading) loading.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Nie udało się wczytać podglądu.';
                console.error(e);
            }
        })();
    @endif
</script>
@endif

<script>
    (function () {
        const picker = document.getElementById('starPicker');
        if (!picker) return;
        const input = document.getElementById('ratingValue');
        const stars = picker.querySelectorAll('.star-input');
        function paint(value) {
            stars.forEach(s => {
                s.classList.toggle('text-amber-500', s.dataset.value <= value);
                s.classList.toggle('text-slate-300', s.dataset.value > value);
            });
        }
        stars.forEach(star => {
            star.addEventListener('mouseenter', () => paint(star.dataset.value));
            star.addEventListener('click', () => { input.value = star.dataset.value; paint(star.dataset.value); });
        });
        picker.addEventListener('mouseleave', () => paint(input.value));
        paint(input.value);
    })();
</script>

@include('shared.footer')
@endsection
