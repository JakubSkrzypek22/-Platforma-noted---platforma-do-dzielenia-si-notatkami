@extends('layouts.app')

@section('content')
@php
// Mapowanie kategorii na klasy kolorystyczne odznak (Tailwind)
$categoryClasses = [
    'Matematyka'  => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-950/30 dark:text-cyan-400 border border-cyan-200 dark:border-cyan-900/30',
    'Medycyna'    => 'bg-red-100 text-red-800 dark:bg-red-950/30 dark:text-red-400 border border-red-200 dark:border-red-900/30',
    'Informatyka' => 'bg-blue-100 text-blue-800 dark:bg-blue-950/30 dark:text-blue-400 border border-blue-200 dark:border-blue-900/30',
    'Prawo'       => 'bg-amber-100 text-amber-800 dark:bg-amber-950/30 dark:text-amber-400 border border-amber-200 dark:border-amber-900/30',
    'Ekonomia'    => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-900/30',
    'Języki Obce' => 'bg-slate-200 text-slate-800 dark:bg-slate-800 dark:text-slate-300 border border-slate-300 dark:border-slate-700/50',
    'Fizyka'      => 'bg-violet-100 text-violet-800 dark:bg-violet-950/30 dark:text-violet-400 border border-violet-200 dark:border-violet-900/30',
    'Chemia'      => 'bg-lime-100 text-lime-800 dark:bg-lime-950/30 dark:text-lime-400 border border-lime-200 dark:border-lime-900/30',
];
$defaultCategoryClass = 'bg-slate-200 text-slate-800 dark:bg-slate-800 dark:text-slate-300 border border-slate-300 dark:border-slate-700/50';
@endphp
@include('shared.navbar')

<style>
    /* Hero Search Section - Vinted/OLX Style */
    .search-hero {
        position: relative;
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.94) 0%, rgba(30, 41, 59, 0.86) 100%), url("{{ asset('img/carousel3.jpg') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        min-height: 520px;
        display: flex;
        align-items: center;
        overflow: hidden;
        color: #ffffff;
    }

    /* Vinted-style Action Card (Floating Box) */
    .vinted-cta-card {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border);
        border-radius: 1.5rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    .vinted-cta-card:hover {
        transform: translateY(-5px);
    }

    /* Horizontal Category Bar */
    .category-scroll-container {
        display: flex;
        overflow-x: auto;
        gap: 0.75rem;
        padding: 0.5rem 0.25rem 1.25rem 0.25rem;
        scrollbar-width: thin;
        scrollbar-color: var(--color-border) transparent;
    }

    .category-scroll-container::-webkit-scrollbar {
        height: 6px;
    }

    .category-scroll-container::-webkit-scrollbar-thumb {
        background-color: var(--color-border);
        border-radius: 6px;
    }

    .category-pill {
        white-space: nowrap;
        background: var(--color-card-bg);
        border: 1px solid var(--color-border);
        color: var(--color-text-body);
        padding: 0.65rem 1.35rem;
        border-radius: 50rem;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        font-size: 0.875rem;
        font-family: inherit;
    }

    .category-pill:hover, .category-pill.active {
        background: var(--color-primary);
        border-color: var(--color-primary);
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(59, 130, 246, 0.25);
    }

    /* Premium OLX/Vinted Catalog Card */
    .catalog-card {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border);
        border-radius: 1.25rem;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 10px 25px -10px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
    }

    .catalog-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.12);
        border-color: var(--color-primary);
    }

    /* Bookmark/Like Heart Icon Button */
    .btn-like {
        background: rgba(15, 23, 42, 0.04);
        border: none;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        color: var(--color-text-body);
        opacity: 0.7;
    }

    .btn-like:hover {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        opacity: 1;
        transform: scale(1.1);
    }

    /* Serce na okładce — stały, czytelny kolor niezależnie od motywu (jasne tło) */
    .fav-btn {
        background: rgba(255, 255, 255, 0.9);
        color: #475569;
        opacity: 1;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
    }
    .fav-btn:hover { background: #ffffff; color: #ef4444; }
    .fav-btn.is-fav { color: #ef4444; }

    /* User Profile Info */
    .author-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: var(--color-card-bg);
        border: 1px solid var(--color-border);
    }

    /* Note card wrapper - animated hide/show */
    .note-item {
        display: flex;
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .note-item.hidden-card {
        display: none;
    }

    /* Empty state for filtered view */
    #catalog-empty-state {
        display: none;
    }
    #catalog-empty-state.visible {
        display: flex;
    }
</style>

<!-- SEKCJA HERO: DUŻE WYSZUKIWANIE + PŁYWAJĄCY BOKS VINTED -->
<section class="search-hero py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Lewa kolumna: Wyszukiwarka -->
            <div class="lg:col-span-7 text-center lg:text-left">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 text-white leading-tight">
                    Znajdź notatki, <br>których potrzebujesz na egzamin
                </h1>
                <p class="text-lg mb-8 text-white/70 font-light">
                    Przeszukuj tysiące opracowań i wykładów udostępnionych za darmo przez studentów z całej Polski.
                </p>

                <!-- Formularz wyszukiwania -->
                <form id="heroSearchForm" class="mb-6" onsubmit="return false;">
                    <div class="flex shadow-2xl rounded-2xl overflow-hidden bg-white dark:bg-slate-800 p-1.5 border border-white/10 max-w-2xl mx-auto lg:mx-0">
                        <span class="inline-flex items-center px-4 text-slate-400 bg-transparent">
                            <i class="bi bi-search text-xl"></i>
                        </span>
                        <input type="text" id="heroSearchInput" name="search"
                               class="w-full px-3 py-3 bg-transparent text-slate-900 dark:text-white border-0 focus:ring-0 focus:outline-none placeholder-slate-400 text-base"
                               placeholder="Wpisz tytu&#322; notatki..."
                               aria-label="Wyszukaj notatki"
                               autocomplete="off">
                        <button class="bg-primary hover:bg-primary-hover text-white px-6 py-3 rounded-xl font-bold shadow-md transition-colors cursor-pointer" type="submit" id="heroSearchBtn">Szukaj</button>
                    </div>
                </form>

                <!-- Popularne wyszukiwania -->
                <div class="flex items-center gap-2 flex-wrap justify-center lg:justify-start">
                    <span class="text-white/60 text-sm">Popularne:</span>
                    <button type="button" class="quick-search-tag bg-white/10 hover:bg-primary text-white border border-white/10 text-xs font-semibold rounded-full px-3 py-1.5 transition-all hover:scale-105 cursor-pointer" data-search="Informatyka">Informatyka</button>
                    <button type="button" class="quick-search-tag bg-white/10 hover:bg-primary text-white border border-white/10 text-xs font-semibold rounded-full px-3 py-1.5 transition-all hover:scale-105 cursor-pointer" data-search="Medycyna">Medycyna</button>
                    <button type="button" class="quick-search-tag bg-white/10 hover:bg-primary text-white border border-white/10 text-xs font-semibold rounded-full px-3 py-1.5 transition-all hover:scale-105 cursor-pointer" data-search="Matematyka">Matematyka</button>
                    <button type="button" class="quick-search-tag bg-white/10 hover:bg-primary text-white border border-white/10 text-xs font-semibold rounded-full px-3 py-1.5 transition-all hover:scale-105 cursor-pointer" data-search="Prawo">Prawo</button>
                </div>
            </div>

            <!-- Prawa kolumna: Boks Vinted "Dodaj notatkę" -->
            <div class="lg:col-span-5 w-full max-w-md mx-auto lg:ml-auto">
                <div class="vinted-cta-card p-6 text-text-body">
                    <h3 class="text-xl font-bold mb-3">Masz własne notatki?</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-6 text-sm leading-relaxed">
                        Uporządkuj pliki na dysku i udostępnij je innym! Pomóż społeczności w nauce, zbieraj punkty reputacji i buduj swoje portfolio naukowe.
                    </p>
                    
                    <!-- Warunkowy przycisk (zalogowany / gość) -->
                    @auth
                        <a href="{{ route('notes.create') }}" class="bg-primary hover:bg-primary-hover text-white font-bold py-3.5 px-4 rounded-xl flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all cursor-pointer w-full text-center">
                            <i class="bi bi-plus-circle-fill text-lg"></i> Udostępnij notatki
                        </a>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="bg-primary hover:bg-primary-hover text-white font-bold py-3.5 px-4 rounded-xl flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all cursor-pointer w-full text-center">
                            <i class="bi bi-plus-circle-fill text-lg"></i> Udostępnij notatki
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEKCJA KATALOGU: FILTRY KATEGORII + SIATKA NOTATEK -->
<section class="py-12 bg-slate-100/50 dark:bg-slate-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- Pasek filtrów kategorii w stylu Vinted -->
        <div class="mb-8">
            <h5 class="text-base font-bold mb-4">Przeglądaj według kategorii:</h5>
            <div class="category-scroll-container" id="categoryBar">
                <button type="button" class="category-pill active" data-filter="all">
                    <i class="bi bi-grid-fill"></i> Wszystkie
                </button>
                <button type="button" class="category-pill" data-filter="Informatyka">
                    <i class="bi bi-laptop-fill"></i> Informatyka
                </button>
                <button type="button" class="category-pill" data-filter="Medycyna">
                    <i class="bi bi-heart-pulse-fill"></i> Medycyna
                </button>
                <button type="button" class="category-pill" data-filter="Prawo">
                    <i class="bi bi-bank2"></i> Prawo
                </button>
                <button type="button" class="category-pill" data-filter="Matematyka">
                    <i class="bi bi-calculator-fill"></i> Matematyka
                </button>
                <button type="button" class="category-pill" data-filter="Ekonomia">
                    <i class="bi bi-graph-up-arrow"></i> Ekonomia
                </button>
                <button type="button" class="category-pill" data-filter="Języki Obce">
                    <i class="bi bi-translate"></i> Języki Obce
                </button>
                <button type="button" class="category-pill" data-filter="Fizyka">
                    <i class="bi bi-lightning-charge-fill"></i> Fizyka
                </button>
                <button type="button" class="category-pill" data-filter="Chemia">
                    <i class="bi bi-droplet-fill"></i> Chemia
                </button>
            </div>
        </div>

        <!-- Tytuł Katalogu -->
        <div class="flex items-center justify-between mb-6">
            <h4 class="text-xl font-extrabold" id="catalogTitle">Najnowsze publiczne notatki</h4>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300" id="catalogCount">{{ $notes->count() }} pozycji</span>
        </div>

        <!-- Siatka notatek (Vinted Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="notesGrid">
            
            @forelse ($notes as $note)
                @php
                    $catClass = $categoryClasses[$note->category] ?? $defaultCategoryClass;
                    $avgRating = $note->reviews_avg_rating ? number_format($note->reviews_avg_rating, 1) : null;
                    $main = $note->mainFile();
                    $favorited = auth()->check() ? $note->isFavoritedBy(auth()->user()) : false;
                @endphp
                <div class="note-item" data-category="{{ $note->category }}">
                    <div class="catalog-card flex-grow flex flex-col justify-between">
                        <!-- Okładka (zdjęcie główne) -->
                        <div class="relative">
                            <a href="{{ route('notes.show', $note) }}" class="block">
                                @if ($main && $main->file_type === 'image')
                                    <img src="{{ route('notes.preview', $note) }}" alt="{{ $note->title }}" class="w-full h-44 object-cover bg-slate-100 dark:bg-slate-800">
                                @else
                                    <div class="w-full h-44 flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900 text-slate-400">
                                        <i class="bi bi-file-earmark-pdf text-5xl"></i>
                                    </div>
                                @endif
                            </a>
                            @auth
                                <form action="{{ route('notes.favorite', $note) }}" method="POST" class="fav-form absolute top-3 right-3 m-0">
                                    @csrf
                                    <button type="submit" class="btn-like fav-btn cursor-pointer {{ $favorited ? 'is-fav' : '' }}" title="{{ $favorited ? 'Usuń z ulubionych' : 'Dodaj do ulubionych' }}">
                                        <i class="bi {{ $favorited ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn-like fav-btn absolute top-3 right-3" title="Zaloguj się, aby zapisać">
                                    <i class="bi bi-heart"></i>
                                </a>
                            @endauth
                        </div>

                        <!-- Header karty: Kategoria i Cena -->
                        <div class="px-5 pt-4 pb-2 flex justify-between items-center bg-transparent border-0">
                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold {{ $catClass }}">
                                {{ $note->category }}
                            </span>

                            @if ($note->isFree())
                                <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400">
                                    Za darmo
                                </span>
                            @else
                                <span class="text-sm font-extrabold text-text-body">{{ number_format($note->price, 2, ',', ' ') }} zł</span>
                            @endif
                        </div>

                        <!-- Body karty -->
                        <div class="px-5 py-2 flex flex-col flex-grow">
                            <!-- Ocena i Uczelnia -->
                            <div class="flex items-center gap-1.5 mb-2 text-amber-500 text-xs">
                                <div class="flex items-center gap-1 font-bold">
                                    <i class="bi bi-star-fill"></i>
                                    <span class="text-text-body">{{ $avgRating ?? '—' }}</span>
                                    <span class="text-slate-400 font-normal">({{ $note->reviews_count }})</span>
                                </div>
                                @if ($note->university)
                                    <span class="text-slate-400">•</span>
                                    <span class="text-slate-400 truncate max-w-[160px]">{{ $note->university }}</span>
                                @endif
                            </div>

                            <!-- Tytuł -->
                            <h5 class="text-base font-bold text-text-body mb-2.5">
                                <a href="{{ route('notes.show', $note) }}" class="hover:text-primary transition-colors">
                                    {{ $note->title }}
                                </a>
                            </h5>

                            <!-- Zajawka Tekstu -->
                            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-4 flex-grow">
                                {{ \Illuminate\Support\Str::limit($note->description, 130) }}
                            </p>

                            <!-- Autor z awatarem -->
                            <div class="flex items-center gap-2.5 border-t border-border pt-4 mt-auto">
                                <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($note->author->name ?? 'Noted') }}" alt="{{ $note->author->name ?? '' }}" class="author-avatar">
                                <div class="text-xs">
                                    <span class="font-bold block text-text-body leading-none">{{ $note->author->name ?? 'Nieznany' }}</span>
                                    <small class="text-slate-400">{{ $note->created_at?->diffForHumans() ?? 'Dodano niedawno' }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Footer karty: CTA i Statystyki -->
                        <div class="px-5 pb-5 pt-3 bg-transparent border-0">
                            <div class="flex justify-between items-center mb-4 text-slate-400 text-xs">
                                <span><i class="bi bi-eye mr-1"></i> {{ number_format($note->views) }} wyświetleń</span>
                                <span><i class="bi bi-download mr-1"></i> {{ number_format($note->downloads) }} pobrań</span>
                            </div>

                            <!-- Akcja: podgląd / szczegóły notatki -->
                            <a href="{{ route('notes.show', $note) }}" class="w-full py-2.5 border border-primary hover:bg-primary hover:text-white text-primary rounded-xl text-xs font-semibold flex items-center justify-center gap-2 transition-all cursor-pointer">
                                <i class="bi bi-eye-fill text-sm"></i> Zobacz / Pobierz PDF
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="bi bi-emoji-frown text-4xl text-slate-400"></i>
                    <p class="mt-3 text-slate-500">Obecnie nie dodano jeszcze żadnych notatek.</p>
                </div>
            @endforelse
        </div>

        <!-- Stan pusty (gdy filtr nie zwraca wyników) -->
        <div class="col-span-full flex-col items-center justify-center py-16 text-center" id="catalog-empty-state">
            <div class="w-16 h-16 rounded-full bg-slate-200 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-search text-2xl text-slate-400"></i>
            </div>
            <h5 class="text-lg font-bold mb-2">Brak notatek w tej kategorii</h5>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-sm mx-auto">Nie znaleziono notatek w wybranej kategorii. Wróć do wszystkich lub bądź pierwszy, kto doda notatki!</p>
            <button type="button" class="mt-6 px-6 py-2.5 bg-primary hover:bg-primary-hover text-white font-semibold rounded-xl text-sm transition-all" id="resetFilterBtn">
                Pokaż wszystkie notatki
            </button>
        </div>
    </div>
</section>

<script>
(function () {
    const pills       = document.querySelectorAll('.category-pill');
    const cards       = document.querySelectorAll('.note-item');
    const countEl     = document.getElementById('catalogCount');
    const titleEl     = document.getElementById('catalogTitle');
    const emptyEl     = document.getElementById('catalog-empty-state');
    const resetBtn    = document.getElementById('resetFilterBtn');
    const searchInput = document.getElementById('heroSearchInput');
    const searchForm  = document.getElementById('heroSearchForm');
    const catalogSec  = document.querySelector('section.py-12');

    let activeFilter = 'all';

    // Core filter: combines category + title search
    function applyFilters() {
        const query = searchInput.value.trim().toLowerCase();
        let visible = 0;

        cards.forEach(function (card) {
            const cat       = card.getAttribute('data-category');
            const titleEl2  = card.querySelector('h5 a');
            const title     = titleEl2 ? titleEl2.textContent.trim().toLowerCase() : '';

            const categoryMatch = (activeFilter === 'all' || cat === activeFilter);
            const searchMatch   = (query === '' || title.includes(query) || cat.toLowerCase().includes(query));

            if (categoryMatch && searchMatch) {
                card.classList.remove('hidden-card');
                visible++;
            } else {
                card.classList.add('hidden-card');
            }
        });

        // Counter
        countEl.textContent = visible + ' ' + (visible === 1 ? 'pozycja' : 'pozycji');

        // Heading
        var q = searchInput.value.trim();
        if (q !== '' && activeFilter === 'all') {
            titleEl.textContent = 'Wyniki: \u201e' + q + '\u201d';
        } else if (q !== '' && activeFilter !== 'all') {
            titleEl.textContent = activeFilter + ' \u00b7 \u201e' + q + '\u201d';
        } else if (activeFilter !== 'all') {
            titleEl.textContent = 'Notatki: ' + activeFilter;
        } else {
            titleEl.textContent = 'Najnowsze publiczne notatki';
        }

        // Empty state
        emptyEl.classList.toggle('visible', visible === 0);
    }

    // Category pills
    pills.forEach(function (pill) {
        pill.addEventListener('click', function () {
            pills.forEach(function (p) { p.classList.remove('active'); });
            pill.classList.add('active');
            activeFilter = pill.getAttribute('data-filter');
            applyFilters();
        });
    });

    // Live search while typing
    searchInput.addEventListener('input', function () {
        applyFilters();
        if (searchInput.value.length === 1) {
            catalogSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });

    // "Szukaj" button / Enter - scroll to results
    searchForm.addEventListener('submit', function (e) {
        e.preventDefault();
        applyFilters();
        catalogSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    // Reset button (empty state)
    resetBtn.addEventListener('click', function () {
        searchInput.value = '';
        pills.forEach(function (p) { p.classList.remove('active'); });
        document.querySelector('[data-filter="all"]').classList.add('active');
        activeFilter = 'all';
        applyFilters();
    });

    // Quick-search popular tags
    document.querySelectorAll('.quick-search-tag').forEach(function (tag) {
        tag.addEventListener('click', function () {
            var term = tag.getAttribute('data-search');
            searchInput.value = term;
            searchInput.focus();
            applyFilters();
            catalogSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
})();
</script>

<script>
// Dodawanie/usuwanie z ulubionych bez przeładowania strony
(function () {
    document.querySelectorAll('form.fav-form').forEach(function (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            const btn  = form.querySelector('button');
            const icon = btn.querySelector('i');
            btn.disabled = true;
            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                    body: new FormData(form),
                });
                if (!res.ok) throw new Error('fail');
                const data = await res.json();
                if (data.favorited) {
                    btn.classList.add('is-fav');
                    icon.classList.remove('bi-heart');
                    icon.classList.add('bi-heart-fill');
                    btn.title = 'Usuń z ulubionych';
                } else {
                    btn.classList.remove('is-fav');
                    icon.classList.remove('bi-heart-fill');
                    icon.classList.add('bi-heart');
                    btn.title = 'Dodaj do ulubionych';
                }
            } catch (err) {
                form.submit(); // awaryjnie: zwykłe wysłanie formularza
            } finally {
                btn.disabled = false;
            }
        });
    });
})();
</script>

@include('shared.footer')
@endsection
