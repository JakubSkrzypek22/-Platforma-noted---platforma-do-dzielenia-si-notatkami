@extends('layouts.app')

@section('content')
@php
// Dummy data representing public notes in the database for instant gorgeous layout rendering
$dummyNotes = [
    [
        'id' => 1,
        'title' => 'Analiza Matematyczna 1 - Kompletne opracowanie teorii',
        'author' => 'Anna Kowalska',
        'university' => 'Politechnika Warszawska',
        'category' => 'Matematyka',
        'category_class' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-950/30 dark:text-cyan-400 border border-cyan-200 dark:border-cyan-900/30',
        'excerpt' => 'Zbiór twierdzeń, definicji i przykładowych zadań z analizy matematycznej (granice, pochodne, całki oznaczone i nieoznaczone). Zawiera rysunki pomocnicze.',
        'likes' => 142,
        'views' => 2480,
        'downloads' => 921,
        'rating' => '4.9',
        'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Anna'
    ],
    [
        'id' => 2,
        'title' => 'Anatomia Prawidłowa - Układ nerwowy i naczyniowy',
        'author' => 'Mateusz Nowak',
        'university' => 'Uniwersytet Jagielloński',
        'category' => 'Medycyna',
        'category_class' => 'bg-red-100 text-red-800 dark:bg-red-950/30 dark:text-red-400 border border-red-200 dark:border-red-900/30',
        'excerpt' => 'Szczegółowe streszczenie struktur anatomicznych ośrodkowego i obwodowego układu nerwowego. Zawiera tabele z unerwieniem i unaczynieniem mięśni.',
        'likes' => 289,
        'views' => 4820,
        'downloads' => 1845,
        'rating' => '5.0',
        'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Mateusz'
    ],
    [
        'id' => 3,
        'title' => 'Programowanie Obiektowe w C++ i Java',
        'author' => 'Tomasz Wiśniewski',
        'university' => 'AGH w Krakowie',
        'category' => 'Informatyka',
        'category_class' => 'bg-blue-100 text-blue-800 dark:bg-blue-950/30 dark:text-blue-400 border border-blue-200 dark:border-blue-900/30',
        'excerpt' => 'Wyjaśnienie pojęć takich jak polimorfizm, dziedziczenie, hermetyzacja, interfejsy i klasy abstrakcyjne. Przykłady kodu gotowe do kompilacji.',
        'likes' => 94,
        'views' => 1950,
        'downloads' => 432,
        'rating' => '4.7',
        'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Tomasz'
    ],
    [
        'id' => 4,
        'title' => 'Prawo Rzymskie - Skrót przedegzaminacyjny',
        'author' => 'Karolina Wójcik',
        'university' => 'Uniwersytet Warszawski',
        'category' => 'Prawo',
        'category_class' => 'bg-amber-100 text-amber-800 dark:bg-amber-950/30 dark:text-amber-400 border border-amber-200 dark:border-amber-900/30',
        'excerpt' => 'Najważniejsze pojęcia, skróty i łacińskie paremie prawne niezbędne do zaliczenia egzaminu z prawa rzymskiego. Przejrzysty układ i schematy powiązań.',
        'likes' => 210,
        'views' => 3120,
        'downloads' => 1054,
        'rating' => '4.8',
        'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Karolina'
    ],
    [
        'id' => 5,
        'title' => 'Podstawy Makroekonomii - Wskaźniki, modele, polityka',
        'author' => 'Kamil Lewandowski',
        'university' => 'Szkoła Główna Handlowa',
        'category' => 'Ekonomia',
        'category_class' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-900/30',
        'excerpt' => 'Opracowanie modeli IS-LM, bezrobocia, inflacji oraz stóp procentowych. Prezentacja mechanizmów polityki monetarnej i fiskalnej banku centralnego.',
        'likes' => 88,
        'views' => 1240,
        'downloads' => 310,
        'rating' => '4.6',
        'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Kamil'
    ],
    [
        'id' => 6,
        'title' => 'Gramatyka opisowa języka angielskiego (Tenses & Syntax)',
        'author' => 'Zofia Kamińska',
        'university' => 'Uniwersytet Wrocławski',
        'category' => 'Języki Obce',
        'category_class' => 'bg-slate-200 text-slate-800 dark:bg-slate-800 dark:text-slate-300 border border-slate-300 dark:border-slate-700/50',
        'excerpt' => 'Kompendium wiedzy o strukturach czasowych języka angielskiego, zdaniach warunkowych i mowie zależnej. Idealne pod kolokwium z gramatyki praktycznej.',
        'likes' => 156,
        'views' => 2340,
        'downloads' => 789,
        'rating' => '4.9',
        'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Zofia'
    ],
    [
        'id' => 7,
        'title' => 'Mechanika Kwantowa - Podstawy i formalizm matematyczny',
        'author' => 'Piotr Zając',
        'university' => 'Politechnika Gdańska',
        'category' => 'Fizyka',
        'category_class' => 'bg-violet-100 text-violet-800 dark:bg-violet-950/30 dark:text-violet-400 border border-violet-200 dark:border-violet-900/30',
        'excerpt' => 'Omówienie równania Schrödingera, zasady nieoznaczoności Heisenberga i modelu atomu Bohra. Zawiera wyprowadzenia i przykłady zastosowań w fizyce atomowej.',
        'likes' => 121,
        'views' => 2100,
        'downloads' => 678,
        'rating' => '4.8',
        'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Piotr'
    ],
    [
        'id' => 8,
        'title' => 'Termodynamika - Zasady i procesy termodynamiczne',
        'author' => 'Alicja Szymańska',
        'university' => 'Politechnika Łódźka',
        'category' => 'Fizyka',
        'category_class' => 'bg-violet-100 text-violet-800 dark:bg-violet-950/30 dark:text-violet-400 border border-violet-200 dark:border-violet-900/30',
        'excerpt' => 'Streszczenie czterech zasad termodynamiki, cyklu Carnota, entropii i entalpi. Tabele wzorów przydatne na egzamin z fizyki technicznej.',
        'likes' => 76,
        'views' => 1540,
        'downloads' => 412,
        'rating' => '4.5',
        'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Alicja'
    ],
    [
        'id' => 9,
        'title' => 'Chemia Organiczna - Reakcje substytucji i eliminacji',
        'author' => 'Bartosz Krawczyk',
        'university' => 'Politechnika Wrocławska',
        'category' => 'Chemia',
        'category_class' => 'bg-lime-100 text-lime-800 dark:bg-lime-950/30 dark:text-lime-400 border border-lime-200 dark:border-lime-900/30',
        'excerpt' => 'Systematyczne omówienie reakcji SN1, SN2, E1 i E2 z mechanizmami krokowymi i przykładami substratów. Idealne do powtórki przed egzaminem.',
        'likes' => 109,
        'views' => 1870,
        'downloads' => 534,
        'rating' => '4.7',
        'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Bartosz'
    ],
    [
        'id' => 10,
        'title' => 'Stechiometria i obliczenia chemiczne - Skrypt ćwiczeniowy',
        'author' => 'Natalia Dąbrowska',
        'university' => 'Uniwersytet Gdański',
        'category' => 'Chemia',
        'category_class' => 'bg-lime-100 text-lime-800 dark:bg-lime-950/30 dark:text-lime-400 border border-lime-200 dark:border-lime-900/30',
        'excerpt' => 'Zestaw 60 rozwiązanych zadań z chemii ogólnej i nieorganicznej: stężenia, pH, równowagi i ilości molarne. Pełne toki rozwiązań krok po kroku.',
        'likes' => 92,
        'views' => 1380,
        'downloads' => 460,
        'rating' => '4.6',
        'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Natalia'
    ],
    [
        'id' => 11,
        'title' => 'Algorytmy i Struktury Danych - Kompleksowy przewodnik',
        'author' => 'Michał Kowalczyk',
        'university' => 'Politechnika Poznańska',
        'category' => 'Informatyka',
        'category_class' => 'bg-blue-100 text-blue-800 dark:bg-blue-950/30 dark:text-blue-400 border border-blue-200 dark:border-blue-900/30',
        'excerpt' => 'Wyczerpujące opracowanie sortowania, grafów, drzew binarnych i programowania dynamicznego. Każdy algorytm z analizą złożoności O-notation.',
        'likes' => 318,
        'views' => 5300,
        'downloads' => 2100,
        'rating' => '5.0',
        'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Michal'
    ],
    [
        'id' => 12,
        'title' => 'Algebra liniowa - Macierze, wektory i przekształcenia',
        'author' => 'Ewa Jabłońska',
        'university' => 'Uniwersytet im. Adama Mickiewicza',
        'category' => 'Matematyka',
        'category_class' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-950/30 dark:text-cyan-400 border border-cyan-200 dark:border-cyan-900/30',
        'excerpt' => 'Streszczenie działań na macierzach, wyznacznikach, przestrzeniach wektorowych i wartościach własnych. Zawiera schematy do typowych zadań egzaminacyjnych.',
        'likes' => 183,
        'views' => 3020,
        'downloads' => 1120,
        'rating' => '4.8',
        'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Ewa'
    ],
];
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
                    <a href="{{ route('categories.show', 'informatyka') }}" class="bg-white/10 hover:bg-primary text-white border border-white/10 text-xs font-semibold rounded-full px-3 py-1.5 transition-all hover:scale-105">Informatyka</a>
                    <a href="{{ route('categories.show', 'medycyna') }}" class="bg-white/10 hover:bg-primary text-white border border-white/10 text-xs font-semibold rounded-full px-3 py-1.5 transition-all hover:scale-105">Medycyna</a>
                    <a href="{{ route('categories.show', 'matematyka') }}" class="bg-white/10 hover:bg-primary text-white border border-white/10 text-xs font-semibold rounded-full px-3 py-1.5 transition-all hover:scale-105">Matematyka</a>
                    <a href="{{ route('categories.show', 'prawo') }}" class="bg-white/10 hover:bg-primary text-white border border-white/10 text-xs font-semibold rounded-full px-3 py-1.5 transition-all hover:scale-105">Prawo</a>
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
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300" id="catalogCount">{{ count($dummyNotes) }} pozycji</span>
        </div>

        <!-- Siatka notatek (Vinted Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="notesGrid">
            
            @forelse ($dummyNotes as $note)
                <div class="note-item" data-category="{{ $note['category'] }}">
                    <div class="catalog-card flex-grow flex flex-col justify-between">
                        <!-- Header karty: Kategoria i Polubienie -->
                        <div class="px-5 pt-5 pb-2 flex justify-between items-center bg-transparent border-0">
                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold {{ $note['category_class'] }}">
                                {{ $note['category'] }}
                            </span>
                            
                            <!-- Logika Polub / Zapisz -->
                            @auth
                                <form action="{{ route('notes.like', $note['id']) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn-like cursor-pointer" title="Zapisz w bibliotece">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                </form>
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" class="btn-like" title="Zaloguj się, aby zapisać">
                                    <i class="bi bi-heart"></i>
                                </a>
                            @endguest
                        </div>

                        <!-- Body karty -->
                        <div class="px-5 py-2 flex flex-col flex-grow">
                            <!-- Ocena i Uczelnia -->
                            <div class="flex items-center gap-1.5 mb-2 text-amber-500 text-xs">
                                <div class="flex items-center gap-1 font-bold">
                                    <i class="bi bi-star-fill"></i>
                                    <span class="text-text-body">{{ $note['rating'] }}</span>
                                </div>
                                <span class="text-slate-400">•</span>
                                <span class="text-slate-400 truncate max-w-[200px]">{{ $note['university'] }}</span>
                            </div>

                            <!-- Tytuł -->
                            <h5 class="text-base font-bold text-text-body mb-2.5">
                                <a href="{{ route('notes.show', $note['id']) }}" class="hover:text-primary transition-colors">
                                    {{ $note['title'] }}
                                </a>
                            </h5>

                            <!-- Zajawka Tekstu -->
                            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-4 flex-grow">
                                {{ strlen($note['excerpt']) > 130 ? substr($note['excerpt'], 0, 130) . '...' : $note['excerpt'] }}
                            </p>

                            <!-- Autor z awatarem -->
                            <div class="flex items-center gap-2.5 border-t border-border pt-4 mt-auto">
                                <img src="{{ $note['avatar'] }}" alt="{{ $note['author'] }}" class="author-avatar">
                                <div class="text-xs">
                                    <span class="font-bold block text-text-body leading-none">{{ $note['author'] }}</span>
                                    <small class="text-slate-400">Dodano niedawno</small>
                                </div>
                            </div>
                        </div>

                        <!-- Footer karty: CTA i Statystyki -->
                        <div class="px-5 pb-5 pt-3 bg-transparent border-0">
                            <div class="flex justify-between items-center mb-4 text-slate-400 text-xs">
                                <span><i class="bi bi-eye mr-1"></i> {{ number_format($note['views']) }} wyświetleń</span>
                                <span><i class="bi bi-download mr-1"></i> {{ number_format($note['downloads']) }} pobrań</span>
                            </div>
                            
                            <!-- Akcja pobrania/pełnej wersji -->
                            @auth
                                <a href="{{ route('notes.download', $note['id']) }}" class="w-full py-2.5 border border-primary hover:bg-primary hover:text-white text-primary rounded-xl text-xs font-semibold flex items-center justify-center gap-2 transition-all cursor-pointer">
                                    <i class="bi bi-cloud-arrow-down-fill text-sm"></i> Zobacz / Pobierz PDF
                                </a>
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" class="w-full py-2.5 border border-primary hover:bg-primary hover:text-white text-primary rounded-xl text-xs font-semibold flex items-center justify-center gap-2 transition-all cursor-pointer">
                                    <i class="bi bi-lock-fill text-sm"></i> Zaloguj się, aby pobrać
                                </a>
                            @endguest
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
            const searchMatch   = (query === '' || title.includes(query));

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
})();
</script>

@include('shared.footer')
@endsection
