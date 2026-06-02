@extends('layouts.app')

@section('content')
@include('shared.navbar')

@php
    $avg   = $note->averageRating();
    $count = $note->reviewsCount();
    $sellerRating = $note->author?->sellerRating() ?? 0;
    $sellerCount  = $note->author?->sellerReviewsCount() ?? 0;
@endphp

<style>
    .preview-stage {
        position: relative;
        border-radius: 1rem;
        overflow: hidden;
        background: #1e293b;
        min-height: 420px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .preview-stage canvas,
    .preview-stage img {
        max-width: 100%;
        height: auto;
        display: block;
    }
    /* Rozmycie podglądu dla gościa */
    .preview-locked .preview-media {
        filter: blur(14px);
        transform: scale(1.05);
        pointer-events: none;
        user-select: none;
    }
    .preview-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(2px);
        color: #fff;
        padding: 1.5rem;
        z-index: 5;
    }
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

        <!-- Okruszki -->
        <nav class="text-sm text-slate-500 dark:text-slate-400 mb-6 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-primary"><i class="bi bi-house-door"></i> Katalog</a>
            <i class="bi bi-chevron-right text-xs"></i>
            <span class="text-text-body font-semibold truncate max-w-xs">{{ $note->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- LEWA KOLUMNA: PODGLĄD PIERWSZEJ STRONY -->
            <div class="lg:col-span-7">
                <div class="preview-stage @guest preview-locked @endguest"
                     id="previewStage"
                     data-type="{{ $note->file_type }}"
                     data-url="{{ route('notes.preview', $note) }}">

                    <div class="preview-media w-full flex items-center justify-center">
                        @if ($note->isPdf())
                            <canvas id="pdfPreview"></canvas>
                            <div id="pdfLoading" class="text-slate-300 text-sm py-20">
                                <i class="bi bi-arrow-repeat animate-spin"></i> Wczytywanie podglądu…
                            </div>
                        @else
                            <img src="{{ route('notes.preview', $note) }}" alt="Podgląd notatki">
                        @endif
                    </div>

                    {{-- Nakładka dla gościa: całkowite rozmycie, brak podglądu kolejnych stron --}}
                    @guest
                        <div class="preview-overlay">
                            <i class="bi bi-lock-fill text-4xl mb-3"></i>
                            <h3 class="text-lg font-bold mb-1">Podgląd dostępny po zalogowaniu</h3>
                            <p class="text-white/70 text-sm max-w-xs mb-5">
                                Zaloguj się, aby zobaczyć pierwszą stronę tej notatki. Kolejne strony odblokujesz po zakupie.
                            </p>
                            <a href="{{ route('login') }}" class="bg-primary hover:bg-primary-hover text-white font-bold py-2.5 px-6 rounded-xl text-sm transition-colors">
                                <i class="bi bi-box-arrow-in-right mr-1.5"></i> Zaloguj się
                            </a>
                        </div>
                    @endguest
                </div>

                <!-- Informacja o zakresie podglądu -->
                <div class="mt-4 flex items-start gap-3 p-4 rounded-xl bg-slate-100/60 dark:bg-slate-800/40 border border-border text-sm text-slate-500 dark:text-slate-400">
                    @if ($hasAccess)
                        <i class="bi bi-unlock-fill text-emerald-500 text-lg"></i>
                        <span>Masz pełny dostęp do tej notatki. Pobierz kompletny plik za pomocą przycisku obok.</span>
                    @elseif (auth()->check())
                        <i class="bi bi-eye-fill text-primary text-lg"></i>
                        <span>To podgląd <strong>tylko pierwszej strony</strong>. Kup notatkę, aby zobaczyć i pobrać wszystkie strony.</span>
                    @else
                        <i class="bi bi-lock-fill text-slate-400 text-lg"></i>
                        <span>Podgląd pierwszej strony jest rozmyty dla niezalogowanych. Zaloguj się, aby go odblokować.</span>
                    @endif
                </div>
            </div>

            <!-- PRAWA KOLUMNA: SZCZEGÓŁY, CENA, ZAKUP -->
            <div class="lg:col-span-5">
                <div class="bg-card-bg border border-border rounded-2xl p-6 shadow-sm sticky top-6">

                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary">
                            {{ $note->category }}
                        </span>
                        <div class="flex items-center gap-1 text-amber-500 text-sm font-bold">
                            <i class="bi bi-star-fill"></i>
                            <span class="text-text-body">{{ $count ? $avg : '—' }}</span>
                            <span class="text-slate-400 font-normal">({{ $count }})</span>
                        </div>
                    </div>

                    <h1 class="text-2xl font-extrabold text-text-body leading-snug mb-2">{{ $note->title }}</h1>

                    @if ($note->university)
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">
                            <i class="bi bi-mortarboard mr-1"></i> {{ $note->university }}
                        </p>
                    @endif

                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed mb-5">
                        {{ $note->description }}
                    </p>

                    <!-- Statystyki -->
                    <div class="grid grid-cols-3 gap-2 text-center mb-6">
                        <div class="p-2 rounded-xl bg-slate-100/60 dark:bg-slate-800/40">
                            <div class="text-lg font-bold text-text-body" id="statPages">{{ $note->isPdf() ? '—' : 1 }}</div>
                            <div class="text-[11px] text-slate-400">stron</div>
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

                    <!-- Akcja główna (zakup / pobranie / zaloguj) -->
                    @if ($hasAccess)
                        <a href="{{ route('notes.download', $note) }}"
                           class="w-full py-3.5 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-md transition-all mb-3">
                            <i class="bi bi-cloud-arrow-down-fill text-lg"></i> Pobierz PDF / plik
                        </a>
                        @if ($isOwner)
                            <p class="text-center text-xs text-slate-400"><i class="bi bi-person-badge"></i> To Twoja notatka.</p>
                        @endif
                    @elseif (auth()->check())
                        <a href="{{ route('notes.checkout', $note) }}"
                           class="w-full py-3.5 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-md transition-all mb-3">
                            <i class="bi bi-cart-fill text-lg"></i> Kup i odblokuj całość
                        </a>
                        <p class="text-center text-xs text-slate-400">Bezpieczna, symulowana płatność — bez prawdziwego obciążenia.</p>
                    @else
                        <a href="{{ route('login') }}"
                           class="w-full py-3.5 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-md transition-all mb-3">
                            <i class="bi bi-box-arrow-in-right text-lg"></i> Zaloguj się, aby kupić
                        </a>
                        <p class="text-center text-xs text-slate-400">Nie masz konta? <a href="{{ route('register') }}" class="text-primary font-semibold">Zarejestruj się</a></p>
                    @endif

                    <!-- Autor / sprzedawca -->
                    <div class="border-t border-border mt-6 pt-5">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Sprzedawca</h4>
                        <div class="flex items-center gap-3">
                            <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($note->author->name ?? 'Notet') }}"
                                 alt="{{ $note->author->name ?? '' }}"
                                 class="w-11 h-11 rounded-full border border-border bg-card-bg">
                            <div>
                                <div class="font-bold text-text-body text-sm">{{ $note->author->name ?? 'Nieznany' }}</div>
                                <div class="flex items-center gap-1 text-xs text-amber-500">
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
                Oceny i opinie
                <span class="text-slate-400 font-normal text-base">({{ $count }})</span>
            </h2>

            <!-- Formularz oceny (tylko dla kupujących, którzy jeszcze nie ocenili) -->
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

            <!-- Lista ocen -->
            <div class="flex flex-col gap-4">
                @forelse ($note->reviews->sortByDesc('created_at') as $review)
                    <div class="bg-card-bg border border-border rounded-2xl p-5">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($review->reviewer->name ?? 'U') }}"
                                     class="w-9 h-9 rounded-full border border-border" alt="">
                                <div>
                                    <div class="font-bold text-text-body text-sm">{{ $review->reviewer->name ?? 'Użytkownik' }}</div>
                                    <div class="text-xs text-slate-400">{{ $review->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <div class="text-amber-500 text-sm">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
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

@if ($note->isPdf())
<script type="module">
    import * as pdfjsLib from 'https://cdn.jsdelivr.net/npm/pdfjs-dist@4.5.136/build/pdf.min.mjs';
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdn.jsdelivr.net/npm/pdfjs-dist@4.5.136/build/pdf.worker.min.mjs';

    const stage   = document.getElementById('previewStage');
    const canvas  = document.getElementById('pdfPreview');
    const loading = document.getElementById('pdfLoading');
    const statPages = document.getElementById('statPages');

    (async () => {
        try {
            const pdf = await pdfjsLib.getDocument(stage.dataset.url).promise;
            if (statPages) statPages.textContent = pdf.numPages;

            // Renderujemy WYŁĄCZNIE pierwszą stronę (kolejne pozostają niedostępne w podglądzie).
            const page = await pdf.getPage(1);
            const containerWidth = stage.clientWidth || 600;
            const baseViewport = page.getViewport({ scale: 1 });
            const scale = Math.min(containerWidth / baseViewport.width, 2);
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
</script>
@endif

<script>
    // Interaktywny wybór gwiazdek w formularzu oceny
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
            star.addEventListener('click', () => {
                input.value = star.dataset.value;
                paint(star.dataset.value);
            });
        });
        picker.addEventListener('mouseleave', () => paint(input.value));
        paint(input.value);
    })();
</script>

@include('shared.footer')
@endsection
