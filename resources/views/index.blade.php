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
        'category_class' => 'bg-info bg-opacity-10 text-info border border-info border-opacity-25',
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
        'category_class' => 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25',
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
        'category_class' => 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25',
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
        'category_class' => 'bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25',
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
        'category_class' => 'bg-success bg-opacity-10 text-success border border-success border-opacity-25',
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
        'category_class' => 'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25',
        'excerpt' => 'Kompendium wiedzy o strukturach czasowych języka angielskiego, zdaniach warunkowych i mowie zależnej. Idealne pod kolokwium z gramatyki praktycznej.',
        'likes' => 156,
        'views' => 2340,
        'downloads' => 789,
        'rating' => '4.9',
        'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Zofia'
    ],
];
@endphp

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
        background: var(--bs-card-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 1.5rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
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
        scrollbar-color: var(--bs-border-color) transparent;
    }

    .category-scroll-container::-webkit-scrollbar {
        height: 6px;
    }

    .category-scroll-container::-webkit-scrollbar-thumb {
        background-color: var(--bs-border-color);
        border-radius: 6px;
    }

    .category-pill {
        white-space: nowrap;
        background: var(--bs-secondary-bg);
        border: 1px solid var(--bs-border-color);
        color: var(--bs-body-color);
        padding: 0.65rem 1.35rem;
        border-radius: 50rem;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .category-pill:hover, .category-pill.active {
        background: var(--bs-primary);
        border-color: var(--bs-primary);
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(var(--bs-primary-rgb), 0.25);
    }

    /* Premium OLX/Vinted Catalog Card */
    .catalog-card {
        background: var(--bs-card-bg);
        border: 1px solid var(--bs-border-color);
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
        border-color: rgba(var(--bs-primary-rgb), 0.35);
    }

    /* Bookmark/Like Heart Icon Button */
    .btn-like {
        background: rgba(var(--bs-body-color-rgb), 0.04);
        border: none;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        color: var(--bs-secondary-color);
    }

    .btn-like:hover {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        transform: scale(1.1);
    }

    /* Popular pill in search hover */
    .hover-pill {
        transition: all 0.2s ease;
    }
    
    .hover-pill:hover {
        background: var(--bs-primary) !important;
        border-color: var(--bs-primary) !important;
        transform: translateY(-1px);
    }

    /* User Profile Info */
    .author-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: var(--bs-secondary-bg);
        border: 1px solid var(--bs-border-color);
    }

    .btn-card-action {
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .text-white-60 {
        color: rgba(255, 255, 255, 0.6) !important;
    }
</style>

<!-- SEKCJA HERO: DUŻE WYSZUKIWANIE + PŁYWAJĄCY BOKS VINTED -->
<section class="search-hero py-5">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center gy-5">
            <!-- Lewa kolumna: Wyszukiwarka -->
            <div class="col-lg-7 text-center text-lg-start">
                <h1 class="display-4 fw-extrabold mb-3 text-white lh-sm">
                    Znajdź notatki, <br>których potrzebujesz na egzamin
                </h1>
                <p class="lead mb-4 text-white-60 fw-light">
                    Przeszukuj tysiące opracowań i wykładów udostępnionych za darmo przez studentów z całej Polski.
                </p>

                <!-- Formularz wyszukiwania -->
                <form action="{{ route('notes.search') }}" method="GET" class="mb-4">
                    <div class="input-group input-group-lg shadow rounded-4 overflow-hidden bg-white p-1 border">
                        <span class="input-group-text bg-white border-0 text-muted ps-3">
                            <i class="bi bi-search fs-4"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-0 bg-white text-dark ps-2" 
                               placeholder="Czego się dzisiaj nauczysz? Wpisz przedmiot, tag..." 
                               aria-label="Wyszukaj notatki">
                        <button class="btn btn-primary px-4 rounded-3 fw-bold" type="submit">Szukaj</button>
                    </div>
                </form>

                <!-- Popularne wyszukiwania -->
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="text-white-60 small">Popularne:</span>
                    <a href="{{ route('categories.show', 'informatyka') }}" class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-10 text-decoration-none rounded-pill px-2.5 py-1.5 small hover-pill">Informatyka</a>
                    <a href="{{ route('categories.show', 'medycyna') }}" class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-10 text-decoration-none rounded-pill px-2.5 py-1.5 small hover-pill">Medycyna</a>
                    <a href="{{ route('categories.show', 'matematyka') }}" class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-10 text-decoration-none rounded-pill px-2.5 py-1.5 small hover-pill">Matematyka</a>
                    <a href="{{ route('categories.show', 'prawo') }}" class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-10 text-decoration-none rounded-pill px-2.5 py-1.5 small hover-pill">Prawo</a>
                </div>
            </div>

            <!-- Prawa kolumna: Boks Vinted "Dodaj notatkę" -->
            <div class="col-lg-5">
                <div class="card vinted-cta-card p-4 ms-lg-auto text-body">
                    <h3 class="fw-bold mb-3">Masz własne notatki?</h3>
                    <p class="text-muted mb-4 small">
                        Uporządkuj pliki na dysku i udostępnij je innym! Pomóż społeczności w nauce, zbieraj punkty reputacji i buduj swoje portfolio naukowe.
                    </p>
                    
                    <!-- Warunkowy przycisk (zalogowany / gość) -->
                    @auth
                        <a href="{{ route('notes.create') }}" class="btn btn-primary btn-lg w-100 fw-bold py-2.5 rounded-3 d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-plus-circle-fill fs-5"></i> Udostępnij notatki
                        </a>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 fw-bold py-2.5 rounded-3 d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-plus-circle-fill fs-5"></i> Udostępnij notatki
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEKCJA KATALOGU: FILTRY KATEGORII + SIATKA NOTATEK -->
<section class="py-5 bg-body-tertiary">
    <div class="container py-3">
        
        <!-- Pasek filtrów kategorii w stylu Vinted -->
        <div class="mb-4">
            <h5 class="fw-bold mb-3">Przeglądaj według kategorii:</h5>
            <div class="category-scroll-container">
                <a href="{{ route('home') }}" class="category-pill active">
                    <i class="bi bi-grid-fill"></i> Wszystkie
                </a>
                <a href="{{ route('categories.show', 'Informatyka') }}" class="category-pill">
                    <i class="bi bi-laptop-fill"></i> Informatyka
                </a>
                <a href="{{ route('categories.show', 'Medycyna') }}" class="category-pill">
                    <i class="bi bi-heart-pulse-fill"></i> Medycyna
                </a>
                <a href="{{ route('categories.show', 'Prawo') }}" class="category-pill">
                    <i class="bi bi-bank2"></i> Prawo
                </a>
                <a href="{{ route('categories.show', 'Matematyka') }}" class="category-pill">
                    <i class="bi bi-calculator-fill"></i> Matematyka
                </a>
                <a href="{{ route('categories.show', 'Ekonomia') }}" class="category-pill">
                    <i class="bi bi-graph-up-arrow"></i> Ekonomia
                </a>
                <a href="{{ route('categories.show', 'Języki Obce') }}" class="category-pill">
                    <i class="bi bi-translate"></i> Języki Obce
                </a>
            </div>
        </div>

        <!-- Tytuł Katalogu -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-extrabold mb-0">Najnowsze publiczne notatki</h4>
            <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill fw-semibold">{{ count($dummyNotes) }} pozycji</span>
        </div>

        <!-- Siatka notatek (Vinted Grid) -->
        <div class="row g-4">
            @forelse ($dummyNotes as $note)
                <div class="col-lg-4 col-md-6 d-flex">
                    <div class="card catalog-card flex-grow-1">
                        <!-- Header karty: Kategoria i Polubienie (Polubienie tylko dla zalogowanych) -->
                        <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center px-4 pt-4 pb-2">
                            <span class="badge {{ $note['category_class'] }} rounded-pill px-2.5 py-1.5 fw-semibold small">
                                {{ $note['category'] }}
                            </span>
                            
                            <!-- Logika Polub / Zapisz: Gość kierowany do logowania, zalogowany wykonuje akcję -->
                            @auth
                                <form action="{{ route('notes.like', $note['id']) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-like" title="Zapisz w bibliotece">
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
                        <div class="card-body px-4 py-2 d-flex flex-column">
                            <!-- Ocena i Uczelnia -->
                            <div class="d-flex align-items-center gap-2 mb-2 text-warning small">
                                <div class="d-flex align-items-center gap-1">
                                    <i class="bi bi-star-fill"></i>
                                    <span class="fw-bold text-dark">{{ $note['rating'] }}</span>
                                </div>
                                <span class="text-muted">•</span>
                                <span class="text-muted fw-normal text-truncate" style="max-width: 200px;">{{ $note['university'] }}</span>
                            </div>

                            <!-- Tytuł -->
                            <h5 class="card-title fw-bold text-body mb-3">
                                <a href="{{ route('notes.show', $note['id']) }}" class="text-decoration-none text-body hover-primary">
                                    {{ $note['title'] }}
                                </a>
                            </h5>

                            <!-- Zajawka Tekstu -->
                            <p class="card-text text-muted small mb-4 lh-relaxed flex-grow-1">
                                {{ strlen($note['excerpt']) > 130 ? substr($note['excerpt'], 0, 130) . '...' : $note['excerpt'] }}
                            </p>

                            <!-- Autor z awatarem -->
                            <div class="d-flex align-items-center gap-2 border-top pt-3 mt-auto">
                                <img src="{{ $note['avatar'] }}" alt="{{ $note['author'] }}" class="author-avatar">
                                <div class="small">
                                    <span class="fw-bold d-block text-dark lh-1">{{ $note['author'] }}</span>
                                    <small class="text-muted">Dodano niedawno</small>
                                </div>
                            </div>
                        </div>

                        <!-- Footer karty: CTA i Statystyki -->
                        <div class="card-footer bg-transparent border-0 px-4 pb-4 pt-2">
                            <div class="d-flex justify-content-between align-items-center mb-3 text-muted small">
                                <span><i class="bi bi-eye"></i> {{ number_format($note['views']) }} wyświetleń</span>
                                <span><i class="bi bi-download"></i> {{ number_format($note['downloads']) }} pobrań</span>
                            </div>
                            
                            <!-- Akcja pobrania/pełnej wersji: Wymaga logowania -->
                            @auth
                                <a href="{{ route('notes.download', $note['id']) }}" class="btn btn-outline-primary btn-card-action w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-cloud-arrow-down-fill"></i> Zobacz / Pobierz PDF
                                </a>
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-card-action w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-lock-fill"></i> Zaloguj się, aby pobrać
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-emoji-frown fs-1 text-muted"></i>
                    <p class="mt-3 text-muted">Obecnie nie dodano jeszcze żadnych notatek.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
