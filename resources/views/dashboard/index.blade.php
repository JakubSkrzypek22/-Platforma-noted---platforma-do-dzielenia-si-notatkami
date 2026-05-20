@extends('layouts.dashboard')

@section('dashboard-content')
    <!-- Custom Styling for Premium Aesthetics -->
    <style>
        .hero-banner {
            background: linear-gradient(135deg, var(--bs-primary) 0%, #818cf8 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }
        [data-bs-theme="beige"] .hero-banner {
            background: linear-gradient(135deg, #c2593f 0%, #dd8068 100%);
        }
        .hero-banner::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 800px;
            height: 800px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            pointer-events: none;
        }
        .premium-card {
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            background-color: var(--bs-card-bg);
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -2px rgba(0, 0, 0, 0.03);
        }
        .premium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.1);
            border-color: var(--bs-primary);
        }
        .heart-btn {
            font-size: 1.3rem;
            color: #ef4444;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .heart-btn:hover {
            transform: scale(1.2);
        }
        .heart-btn .bi-heart-fill {
            display: none;
        }
        .heart-btn.active .bi-heart-fill {
            display: inline-block;
        }
        .heart-btn.active .bi-heart {
            display: none;
        }
        .editorial-wrapper {
            max-width: 860px;
            margin: 0 auto;
        }
        .editorial-quote {
            font-family: Georgia, serif;
            font-size: 1.3rem;
            font-style: italic;
            border-left: 4px solid var(--bs-primary);
            padding-left: 20px;
            color: var(--bs-primary);
        }
        .accordion-button:not(.collapsed) {
            background-color: var(--bs-primary-bg-subtle);
            color: var(--bs-primary);
        }
        .empty-state {
            border: 2px dashed var(--bs-border-color);
            border-radius: 16px;
            padding: 4rem 2rem;
            text-align: center;
            background-color: var(--bs-card-bg);
        }
    </style>

    <!-- Native Bootstrap 5 Navigation Tabs -->
    <ul class="nav nav-tabs mb-5 border-bottom-0 gap-2" id="notetTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active px-4 py-2.5 rounded-3 fw-bold d-flex align-items-center shadow-sm" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-pane" type="button" role="tab" aria-controls="home-pane" aria-selected="true">
                <i class="bi bi-house-door me-2 fs-5"></i> Strona Główna
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link px-4 py-2.5 rounded-3 fw-bold d-flex align-items-center shadow-sm" id="idea-tab" data-bs-toggle="tab" data-bs-target="#idea-pane" type="button" role="tab" aria-controls="idea-pane" aria-selected="false">
                <i class="bi bi-lightbulb me-2 fs-5"></i> Idea Strony
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link px-4 py-2.5 rounded-3 fw-bold d-flex align-items-center shadow-sm" id="basket-tab" data-bs-toggle="tab" data-bs-target="#basket-pane" type="button" role="tab" aria-controls="basket-pane" aria-selected="false">
                <i class="bi bi-cart3 me-2 fs-5"></i> Koszyk (Notatki)
            </button>
        </li>
    </ul>

    <!-- Tab Content Pane Wrapper -->
    <div class="tab-content" id="notetTabsContent">
        
        <!-- TAB 1: STRONA GŁÓWNA (Pulpit użytkownika) -->
        <div class="tab-pane fade show active" id="home-pane" role="tabpanel" aria-labelledby="home-tab">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-bold mb-1 text-body">Pulpit</h2>
                    <p class="text-secondary mb-0">Podsumowanie Twojej aktywności w serwisie</p>
                </div>
                <div class="d-none d-sm-flex">
                    <a href="{{ route('trips') }}" class="btn btn-outline-primary px-4 py-2.5 rounded-3 fw-bold d-flex align-items-center shadow-sm">
                        <i class="bi bi-journal-text me-2 fs-5"></i> Moje Notatki
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="row g-4 mb-5">
                <div class="col-md-6 col-lg-4">
                    <div class="card premium-card p-4 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="h6 text-secondary fw-bold mb-0">Aktywne oferty</h3>
                            <div class="w-10 h-10 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center text-primary" style="width: 40px; height: 40px;">
                                <i class="bi bi-files fs-5"></i>
                            </div>
                        </div>
                        <div class="fs-2 fw-bold mb-1 text-body">12</div>
                        <div class="text-secondary small">
                            2 sprzedane, 1 oczekująca na ocenę
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="card premium-card p-4 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="h6 text-secondary fw-bold mb-0">Przeglądane przedmioty</h3>
                            <div class="w-10 h-10 rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center text-info" style="width: 40px; height: 40px;">
                                <i class="bi bi-mortarboard fs-5"></i>
                            </div>
                        </div>
                        <div class="fs-2 fw-bold mb-1 text-body">8</div>
                        <div class="text-secondary small">z 3 różnych wydziałów</div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card premium-card p-4 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="h6 text-secondary fw-bold mb-0">Twój Ranking</h3>
                            <div class="w-10 h-10 rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center text-success" style="width: 40px; height: 40px;">
                                <i class="bi bi-award fs-5"></i>
                            </div>
                        </div>
                        <div class="fs-2 fw-bold mb-1 text-body">Średnia: 4.8</div>
                        <div class="text-success small d-flex align-items-center gap-1 mt-1">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-half text-warning"></i>
                            <span class="text-secondary ms-1 small">12 opinii</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Info -->
            <div class="row g-4 mb-4">
                <div class="col-lg-6">
                    <div class="card premium-card p-4 h-100">
                        <h3 class="h5 fw-bold mb-4 text-body"><i class="bi bi-lightning-charge-fill text-primary me-2"></i>Ostatnia Aktywność</h3>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center p-3 rounded-3 bg-body-secondary bg-opacity-50">
                                <div class="w-10 h-10 rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center me-3 text-warning" style="width: 40px; height: 40px; flex-shrink: 0;">
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bold text-body">Otrzymano 5★ ocenę!</p>
                                    <p class="mb-0 text-secondary small">od Marta Z. za "Makroekonomia - Ćwiczenia"</p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center p-3 rounded-3 bg-body-secondary bg-opacity-50">
                                <div class="w-10 h-10 rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-3 text-success" style="width: 40px; height: 40px; flex-shrink: 0;">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bold text-body">Sprzedano materiał!</p>
                                    <p class="mb-0 text-secondary small">"Fizyka Kwantowa" kupiona przez Paweł P.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card premium-card p-5 h-100 hero-banner shadow-lg text-white d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge bg-white text-primary fw-bold px-3 py-2 mb-3 rounded-pill text-uppercase" style="letter-spacing: 1px;">Zarabiaj na Wiedzy</span>
                            <h3 class="display-6 fw-bold mb-3">Wystaw nową notatkę!</h3>
                            <p class="mb-4 text-white-50">Wgrywaj swoje skrupulatnie przygotowane opracowania naukowe, wspieraj społeczność akademicką i generuj pasywny dochód.</p>
                        </div>
                        <a href="{{ route('trips') }}" class="btn btn-light btn-lg px-4 py-2.5 rounded-3 fw-bold text-primary align-self-start shadow-sm mt-3">
                            Dodaj Materiał <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: IDEA STRONY (BOGATY KONTENT BEZ GEOGRAFII) -->
        <div class="tab-pane fade" id="idea-pane" role="tabpanel" aria-labelledby="idea-tab">
            <div class="editorial-wrapper py-3">
                
                <!-- Header Jumbotron -->
                <div class="text-center mb-5">
                    <span class="text-primary fw-bold text-uppercase tracking-widest fs-7">Filozofia Projektu</span>
                    <h2 class="display-5 fw-bold mt-2 text-body">Ekosystem Cyfrowej Synergii Akademickiej</h2>
                    <p class="lead text-secondary mt-3">Jak unowocześniamy obieg wiedzy bez barier, kształtując zrównoważoną przestrzeń wymiany myśli w środowisku naukowym.</p>
                </div>

                <!-- Editorial Introduction -->
                <div class="row g-5 align-items-center mb-5">
                    <div class="col-md-7">
                        <h3 class="fw-bold mb-3 text-body">Nowy Wymiar Dzielenia Się Wiedzą</h3>
                        <p class="text-secondary" style="text-align: justify; line-height: 1.7;">
                            Tradycyjne modele edukacyjne borykają się z ogromnym marnotrawstwem zasobów poznawczych. Prace pisane w pocie czoła, skrupulatnie prowadzone notatki z wykładów, szczegółowo rozpisane projekty semestralne lądują na dnie cyfrowych folderów po zdanym egzaminie. Jest to strata potencjału intelektualnego, który mógłby wielokrotnie służyć kolejnym rocznikom.
                        </p>
                        <p class="text-secondary mb-0" style="text-align: justify; line-height: 1.7;">
                            Notet stawia czoła temu wyzwaniu. Przenosimy ideę gospodarki obiegu zamkniętego (<i>circular economy</i>) bezpośrednio na grunt akademicki. Dajemy drugie życie opracowaniom dydaktycznym, pozwalając autorom czerpać korzyści finansowe ze swojego trudu, a kupującym ułatwiając natychmiastowe dotarcie do syntetycznych i sprawdzonych źródeł wiedzy.
                        </p>
                    </div>
                    <div class="col-md-5">
                        <div class="p-4 rounded-4 bg-primary bg-opacity-10 border border-primary border-opacity-10 shadow-inner">
                            <h4 class="fw-bold mb-3 text-primary"><i class="bi bi-lightbulb-fill me-2"></i>Wizja Notet</h4>
                            <p class="text-secondary small mb-0" style="line-height: 1.6;">
                                Wierzymy w pełną demokratyzację dostępu do materiałów naukowych. Wiedza nie powinna być zamknięta w ciasnych kręgach. Poprzez dynamiczne, zintegrowane mechanizmy oceny to studenci sami kreują standardy jakości dydaktycznej, filtrując i nagradzając najbardziej wartościowe i precyzyjne materiały.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Premium blockquote -->
                <div class="my-5 p-4 rounded-3 bg-body-secondary bg-opacity-50">
                    <div class="editorial-quote text-body">
                        "Czas spędzony na samodzielnej selekcji chaotycznych informacji z sieci to najkosztowniejsza część procesu edukacji. Optymalizacja tej ścieżki za pomocą zweryfikowanych streszczeń to fundament nowoczesnej nauki."
                    </div>
                </div>

                <!-- Rich Cards Grid -->
                <h3 class="fw-bold text-center mb-4 text-body">Trzy Filary Naszej Architektury Ideowej</h3>
                <div class="row g-4 mb-5">
                    <div class="col-md-4">
                        <div class="card premium-card h-100 p-4">
                            <h5 class="fw-bold text-primary mb-3"><i class="bi bi-check-circle-fill me-2"></i>Mikroekonomia</h5>
                            <p class="text-secondary small mb-0">Uczciwy system gratyfikacji finansowej dla autorów starannie sporządzonych materiałów. Praca intelektualna zyskuje realny ekwiwalent rynkowy.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card premium-card h-100 p-4">
                            <h5 class="fw-bold text-primary mb-3"><i class="bi bi-star-fill me-2"></i>Kuratela Jakości</h5>
                            <p class="text-secondary small mb-0">Rygorystyczne, społecznościowe mechanizmy recenzowania materiałów chronią przed błędnymi, niekompletnymi informacjami.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card premium-card h-100 p-4">
                            <h5 class="fw-bold text-primary mb-3"><i class="bi bi-sliders me-2"></i>Zgodność z Intuicją</h5>
                            <p class="text-secondary small mb-0">Zintegrowany interfejs, w którym interakcja i zakupy przebiegają bez barier. Maksymalne skupienie na samym procesie przyswajania wiedzy.</p>
                        </div>
                    </div>
                </div>

                <!-- Premium Accordion FAQ Section -->
                <h3 class="fw-bold text-center mb-4 text-body">Innowacja Technologiczna i Rozwój</h3>
                <div class="accordion accordion-flush premium-card shadow-sm mb-5" id="accordionIdea">
                    <div class="accordion-item bg-transparent">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                🚀 Dynamiczne Dopasowywanie Treści
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionIdea">
                            <div class="accordion-body text-secondary" style="line-height: 1.6;">
                                Wykorzystujemy innowacyjne rozwiązania algorytmiczne do precyzyjnego kategoryzowania notatek na podstawie dziedzin naukowych, programów wykładowych oraz tagów semantycznych. Dzięki temu odnalezienie odpowiednich wzorów matematycznych lub streszczeń analitycznych zajmuje zaledwie ułamek sekundy, diametralnie skracając drogę poszukiwań.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item bg-transparent">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                🛡️ Ochrona Praw Twórców i Weryfikacja Cyfrowa
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionIdea">
                            <div class="accordion-body text-secondary" style="line-height: 1.6;">
                                Bezpieczeństwo i uczciwość intelektualna to nasza absolutna dewiza. Wprowadzamy weryfikację antyplagiatową dla przesyłanych plików oraz dbamy o to, aby prawa autorskie do unikalnych materiałów dydaktycznych były skutecznie chronione. Każda transakcja podlega pełnemu zabezpieczeniu, a autor zachowuje pełną autonomię nad swoim dziełem.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item bg-transparent">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                🎨 Estetyka Poznawcza w Służbie Skupienia
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionIdea">
                            <div class="accordion-body text-secondary" style="line-height: 1.6;">
                                Zasady projektowania interfejsu Notet opierają się na zaawansowanych badaniach nad percepcją wzrokową i ergonomią. Harmonijne schematy kolorystyczne (w tym innowacyjny motyw kremowy) eliminują zmęczenie oczu podczas całonocnych powtórek materiału, ułatwiając zapamiętywanie kluczowych pojęć w sprzyjającym, estetycznym środowisku.
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- TAB 3: KOSZYK (DYNAMICZNY CRUD NOTATEK W BOOTSTRAPIE) -->
        <div class="tab-pane fade" id="basket-pane" role="tabpanel" aria-labelledby="basket-tab">
            
            <!-- Stats Counter Row -->
            <div class="row g-4 mb-4 text-center">
                <div class="col-6 col-md-3">
                    <div class="card premium-card p-3 shadow-sm">
                        <span class="text-secondary small text-uppercase fw-bold">Wszystkie Notatki</span>
                        <h4 class="fw-bold mt-1 mb-0 text-primary" id="stats-total">0</h4>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card premium-card p-3 shadow-sm">
                        <span class="text-secondary small text-uppercase fw-bold">Ulubione ❤️</span>
                        <h4 class="fw-bold mt-1 mb-0 text-danger" id="stats-favorites">0</h4>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card premium-card p-3 shadow-sm">
                        <span class="text-secondary small text-uppercase fw-bold">W Trakcie Zakupu</span>
                        <h4 class="fw-bold mt-1 mb-0 text-warning" id="stats-pending">0</h4>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card premium-card p-3 shadow-sm">
                        <span class="text-secondary small text-uppercase fw-bold">Zakupione</span>
                        <h4 class="fw-bold mt-1 mb-0 text-success" id="stats-purchased">0</h4>
                    </div>
                </div>
            </div>

            <!-- Main Grid Row -->
            <div class="row g-4">
                
                <!-- Left Panel: Create Form Card -->
                <div class="col-lg-4">
                    <div class="card premium-card p-4 shadow-sm position-sticky" style="top: 20px; z-index: 10;">
                        <h4 class="fw-bold mb-3 d-flex align-items-center text-body">
                            <i class="bi bi-plus-circle-fill text-primary me-2"></i>
                            Wystaw Nową Notatkę
                        </h4>
                        <hr class="my-3 text-secondary border-opacity-10">
                        
                        <form id="note-form" onsubmit="handleCreateNote(event)">
                            <div class="mb-3">
                                <label for="form-title" class="form-label small fw-bold text-body">Tytuł Opracowania</label>
                                <input type="text" class="form-control" id="form-title" placeholder="np. Analiza Matematyczna - Całki" required>
                            </div>
                            <div class="mb-3">
                                <label for="form-content" class="form-label small fw-bold text-body">Treść / Opis Notatek</label>
                                <textarea class="form-control" id="form-content" rows="4" placeholder="Opisz krótko zawartość, stopień szczegółowości i liczbę stron..." required></textarea>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label for="form-price" class="form-label small fw-bold text-body">Cena (PLN)</label>
                                    <input type="number" class="form-control" id="form-price" step="0.01" min="0" placeholder="0.00" required>
                                </div>
                                <div class="col-6">
                                    <label for="form-status" class="form-label small fw-bold text-body">Status</label>
                                    <select class="form-select" id="form-status" required>
                                        <option value="w trakcie zakupu" selected>W trakcie</option>
                                        <option value="zakupione">Zakupione</option>
                                        <option value="zwrócone">Zwrócone</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="form-favorite">
                                <label class="form-check-label small fw-bold text-body" for="form-favorite">Dodaj do ulubionych (❤️)</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold shadow d-flex align-items-center justify-content-center">
                                <i class="bi bi-plus-lg me-2"></i> Dodaj do Menedżera
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right Panel: Note cards grid list & filters -->
                <div class="col-lg-8">
                    
                    <!-- Filter Pills & Search Input Row -->
                    <div class="card premium-card p-3 mb-4 shadow-sm">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0 text-secondary"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control border-start-0 ps-0" id="search-input" placeholder="Szukaj po tytule lub opisie..." oninput="renderNotes()">
                                </div>
                            </div>
                            <div class="col-md-7 text-md-end">
                                <div class="d-flex flex-wrap gap-2 justify-content-md-end" id="filter-pills-container">
                                    <button class="btn btn-sm btn-outline-primary active px-3 py-1.5 rounded-pill" id="pill-all" onclick="setFilter('all')">Wszystkie</button>
                                    <button class="btn btn-sm btn-outline-primary px-3 py-1.5 rounded-pill" id="pill-pending" onclick="setFilter('w trakcie zakupu')">W trakcie</button>
                                    <button class="btn btn-sm btn-outline-primary px-3 py-1.5 rounded-pill" id="pill-purchased" onclick="setFilter('zakupione')">Zakupione</button>
                                    <button class="btn btn-sm btn-outline-primary px-3 py-1.5 rounded-pill" id="pill-returned" onclick="setFilter('zwrócone')">Zwrócone</button>
                                    <button class="btn btn-sm btn-outline-danger px-3 py-1.5 rounded-pill" id="pill-favorites" onclick="setFilter('favorites')">❤️ Ulubione</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Cards Grid List -->
                    <div class="row row-cols-1 row-cols-md-2 g-4" id="notes-container">
                        <!-- Cards populated dynamically by script -->
                    </div>

                </div>

            </div>
        </div>

    </div>

    <!-- Interactive Javascript Logic (Tabs switcher API, dynamic Reactivity, persistent CRUD, Heart trigger) -->
    <script>
        // --- 1. GENERAL TABS UTILITY DIRECT ROUTER ---
        function switchTabDirect(tabButtonId) {
            const btnEl = document.getElementById(tabButtonId);
            if (btnEl) {
                const tabInstance = new bootstrap.Tab(btnEl);
                tabInstance.show();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        // --- 2. ADVANCED FRONTEND NOTES CRUD MOTOR ---
        const defaultNotes = [
            {
                id: 1,
                title: "Analiza Matematyczna – Całki Oznaczone 📐",
                content: "Kompletne opracowanie twierdzeń i wzorów dotyczących całek oznaczonych wraz z przykładowymi zadaniami krok po kroku. Idealne przed nadchodzącym kolokwium!",
                price: 19.99,
                status: "zakupione",
                favorite: true
            },
            {
                id: 2,
                title: "Architektura Systemów Operacyjnych 💻",
                content: "Szczegółowe diagramy i przejrzyste omówienie zarządzania pamięcią RAM, algorytmów szeregowania procesora oraz mechanizmów synchronizacji procesów.",
                price: 24.50,
                status: "w trakcie zakupu",
                favorite: false
            },
            {
                id: 3,
                title: "Bazy Danych – Zaawansowany SQL 💾",
                content: "Kompendium wiedzy z optymalizacji zapytań SQL, działania indeksów B-Tree, transakcji ACID oraz zaawansowanych funkcji okna (Window Functions).",
                price: 14.99,
                status: "zakupione",
                favorite: true
            },
            {
                id: 4,
                title: "Wstęp do Sztucznej Inteligencji 🤖",
                content: "Przejrzyste i estetyczne notatki z podstaw sztucznych sieci neuronowych, funkcji aktywacji, wstecznej propagacji błędu oraz działania algorytmów genetycznych.",
                price: 29.99,
                status: "zwrócone",
                favorite: false
            }
        ];

        let notes = [];
        let activeFilter = 'all';
        let noteEditingId = null;

        // Load or initialize notes list from localStorage
        if (localStorage.getItem('notet-notes-basket')) {
            try {
                notes = JSON.parse(localStorage.getItem('notet-notes-basket'));
            } catch (e) {
                notes = defaultNotes;
            }
        } else {
            notes = defaultNotes;
            saveNotesToStorage();
        }

        function saveNotesToStorage() {
            localStorage.setItem('notet-notes-basket', JSON.stringify(notes));
        }

        // Counter stats renderer
        function updateStats() {
            document.getElementById('stats-total').innerText = notes.length;
            document.getElementById('stats-favorites').innerText = notes.filter(n => n.favorite).length;
            document.getElementById('stats-pending').innerText = notes.filter(n => n.status === 'w trakcie zakupu').length;
            document.getElementById('stats-purchased').innerText = notes.filter(n => n.status === 'zakupione').length;
        }

        // Filter trigger
        function setFilter(filterType) {
            activeFilter = filterType;
            
            // Handle active class updates
            const pills = document.querySelectorAll('#filter-pills-container button');
            pills.forEach(pill => pill.classList.remove('active'));

            const pillMapping = {
                'all': 'pill-all',
                'w trakcie zakupu': 'pill-pending',
                'zakupione': 'pill-purchased',
                'zwrócone': 'pill-returned',
                'favorites': 'pill-favorites'
            };

            const targetPill = document.getElementById(pillMapping[filterType]);
            if (targetPill) targetPill.classList.add('active');

            renderNotes();
        }

        // CREATE operation handler
        function handleCreateNote(e) {
            e.preventDefault();
            
            const title = document.getElementById('form-title').value.trim();
            const content = document.getElementById('form-content').value.trim();
            const price = parseFloat(document.getElementById('form-price').value) || 0;
            const status = document.getElementById('form-status').value;
            const favorite = document.getElementById('form-favorite').checked;

            const newNote = {
                id: Date.now(),
                title,
                content,
                price,
                status,
                favorite
            };

            notes.unshift(newNote); // Prepend new note
            saveNotesToStorage();
            updateStats();
            renderNotes();

            // Reset create form
            document.getElementById('note-form').reset();
        }

        // DELETE operation handler
        function handleDeleteNote(id) {
            if (confirm("Czy jesteś pewien, że chcesz bezpowrotnie skasować te notatki z Menedżera?")) {
                notes = notes.filter(n => n.id !== id);
                if (noteEditingId === id) noteEditingId = null;
                saveNotesToStorage();
                updateStats();
                renderNotes();
            }
        }

        // UPDATE favorite status toggler
        function toggleFavorite(id, event) {
            event.stopPropagation();
            notes = notes.map(n => {
                if (n.id === id) {
                    return { ...n, favorite: !n.favorite };
                }
                return n;
            });
            saveNotesToStorage();
            updateStats();
            renderNotes();
        }

        // UPDATE: inline editor modes toggler
        function startInlineEdit(id) {
            noteEditingId = id;
            renderNotes();
        }

        function cancelInlineEdit() {
            noteEditingId = null;
            renderNotes();
        }

        // Save inline edit
        function saveInlineEdit(id) {
            const cardEl = document.querySelector(`[data-card-id="${id}"]`);
            if (!cardEl) return;

            const editTitle = cardEl.querySelector('.edit-title-field').value.trim();
            const editContent = cardEl.querySelector('.edit-content-field').value.trim();
            const editPrice = parseFloat(cardEl.querySelector('.edit-price-field').value) || 0;
            const editStatus = cardEl.querySelector('.edit-status-field').value;

            if (!editTitle || !editContent) {
                alert("Tytuł oraz treść notatki nie mogą być puste!");
                return;
            }

            notes = notes.map(n => {
                if (n.id === id) {
                    return {
                        ...n,
                        title: editTitle,
                        content: editContent,
                        price: editPrice,
                        status: editStatus
                    };
                }
                return n;
            });

            noteEditingId = null;
            saveNotesToStorage();
            updateStats();
            renderNotes();
        }

        // UPDATE: direct status alteration from card select dropdown
        function handleQuickStatusChange(id, newStatus) {
            notes = notes.map(n => {
                if (n.id === id) {
                    return { ...n, status: newStatus };
                }
                return n;
            });
            saveNotesToStorage();
            updateStats();
            renderNotes();
        }

        // READ: dynamic note list generator
        function renderNotes() {
            const container = document.getElementById('notes-container');
            container.innerHTML = '';

            const searchQuery = document.getElementById('search-input').value.toLowerCase().trim();

            // Filter logic
            const filtered = notes.filter(n => {
                const matchesSearch = n.title.toLowerCase().includes(searchQuery) || 
                                      n.content.toLowerCase().includes(searchQuery);
                if (!matchesSearch) return false;

                if (activeFilter === 'all') return true;
                if (activeFilter === 'favorites') return n.favorite;
                return n.status === activeFilter;
            });

            // Empty State handling
            if (filtered.length === 0) {
                container.innerHTML = `
                    <div class="col-12">
                        <div class="empty-state shadow-sm">
                            <i class="bi bi-journal-x display-3 text-secondary opacity-50 mb-3 d-block"></i>
                            <h4 class="fw-bold text-body">Brak Pasujących Materiałów</h4>
                            <p class="text-secondary small mx-auto mb-0" style="max-width: 480px;">
                                Nie odnaleźliśmy żadnych notatek spełniających wybrane kryteria wyszukiwania. Wpisz inny tytuł lub utwórz nową notatkę w lewym panelu!
                            </p>
                        </div>
                    </div>
                `;
                return;
            }

            // Append cards to grid layout
            filtered.forEach(note => {
                const isEditing = note.id === noteEditingId;
                const col = document.createElement('div');
                col.className = 'col';
                col.setAttribute('data-card-id', note.id);

                if (isEditing) {
                    // RENDERING IN EDIT MODE
                    col.innerHTML = `
                        <div class="card premium-card p-4 shadow-sm border-primary">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-body">Tytuł Opracowania</label>
                                <input type="text" class="form-control form-control-sm edit-title-field" value="${escapeHtml(note.title)}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-body">Treść</label>
                                <textarea class="form-control form-control-sm edit-content-field" rows="3" required>${escapeHtml(note.content)}</textarea>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label small fw-bold text-body">Cena (PLN)</label>
                                    <input type="number" class="form-control form-control-sm edit-price-field" step="0.01" min="0" value="${note.price}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-bold text-body">Status</label>
                                    <select class="form-select form-select-sm edit-status-field">
                                        <option value="w trakcie zakupu" ${note.status === 'w trakcie zakupu' ? 'selected' : ''}>W trakcie</option>
                                        <option value="zakupione" ${note.status === 'zakupione' ? 'selected' : ''}>Zakupione</option>
                                        <option value="zwrócone" ${note.status === 'zwrócone' ? 'selected' : ''}>Zwrócone</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-outline-secondary" onclick="cancelInlineEdit()">Anuluj</button>
                                <button class="btn btn-sm btn-primary" onclick="saveInlineEdit(${note.id})">Zapisz</button>
                            </div>
                        </div>
                    `;
                } else {
                    // RENDERING IN NORMAL VIEW MODE
                    let statusBadgeClass = '';
                    let statusText = '';
                    if (note.status === 'zakupione') {
                        statusBadgeClass = 'bg-success-subtle text-success-emphasis border border-success-subtle';
                        statusText = 'Kupiono';
                    } else if (note.status === 'w trakcie zakupu') {
                        statusBadgeClass = 'bg-warning-subtle text-warning-emphasis border border-warning-subtle';
                        statusText = 'Oczekuje';
                    } else {
                        statusBadgeClass = 'bg-danger-subtle text-danger-emphasis border border-danger-subtle';
                        statusText = 'Zwrócono';
                    }

                    col.innerHTML = `
                        <div class="card premium-card h-100 d-flex flex-column justify-content-between p-4 shadow-sm">
                            <div>
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                                    <h4 class="h5 fw-bold mb-0 text-break text-body" style="line-height: 1.4;">${escapeHtml(note.title)}</h4>
                                    <button class="heart-btn ${note.favorite ? 'active' : ''}" onclick="toggleFavorite(${note.id}, event)" title="${note.favorite ? 'Usuń z ulubionych' : 'Dodaj do ulubionych'}">
                                        <i class="bi bi-heart fs-5"></i>
                                        <i class="bi bi-heart-fill fs-5"></i>
                                    </button>
                                </div>
                                <p class="text-secondary small text-break mb-4" style="line-height: 1.5;">${escapeHtml(note.content)}</p>
                            </div>
                            
                            <div>
                                <hr class="my-3 text-secondary border-opacity-10">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center text-primary fw-bold">
                                        <i class="bi bi-tag-fill me-1.5 small"></i>
                                        <span>${note.price.toFixed(2)} PLN</span>
                                    </div>
                                    
                                    <select class="form-select form-select-sm w-auto py-1 border-0 fw-bold rounded-pill text-uppercase fs-8 ${statusBadgeClass}" 
                                            onchange="handleQuickStatusChange(${note.id}, this.value)" style="font-size: 0.72rem; cursor: pointer; padding-right: 1.8rem;">
                                        <option value="w trakcie zakupu" ${note.status === 'w trakcie zakupu' ? 'selected' : ''}>Oczekuje</option>
                                        <option value="zakupione" ${note.status === 'zakupione' ? 'selected' : ''}>Kupiono</option>
                                        <option value="zwrócone" ${note.status === 'zwrócone' ? 'selected' : ''}>Zwrócono</option>
                                    </select>
                                </div>
                                
                                <div class="d-flex justify-content-end gap-2 mt-3 pt-2">
                                    <button class="btn btn-sm btn-light border d-flex align-items-center text-body" onclick="startInlineEdit(${note.id})">
                                        <i class="bi bi-pencil me-1.5"></i> Edytuj
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger d-flex align-items-center" onclick="handleDeleteNote(${note.id})">
                                        <i class="bi bi-trash3 me-1.5"></i> Usuń
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                }

                container.appendChild(col);
            });
        }

        // HTML escaping utility to prevent XSS
        function escapeHtml(str) {
            return str
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Initialize state rendering
        updateStats();
        renderNotes();
    </script>
@endsection
