@extends('layouts.dashboard')

@section('dashboard-content')
    <!-- Custom Styling for Premium Aesthetics -->
    <style>
        .hero-banner {
            background: linear-gradient(135deg, var(--color-primary) 0%, #818cf8 100%);
            color: white;
            position: relative;
            overflow: hidden;
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
            border: 1px solid var(--color-border);
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            background-color: var(--color-card-bg);
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -2px rgba(0, 0, 0, 0.03);
        }
        .premium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.1);
            border-color: var(--color-primary);
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
            border-left: 4px solid var(--color-primary);
            padding-left: 20px;
            color: var(--color-primary);
        }
    </style>

    <!-- Tab Navigation buttons -->
    <div class="flex flex-wrap gap-3 mb-8" id="notetTabs">
        <button onclick="showTab('home-pane')" class="tab-btn bg-primary text-white shadow-md px-5 py-3 rounded-xl font-bold flex items-center transition-all cursor-pointer" id="home-tab">
            <i class="bi bi-house-door mr-2 text-lg"></i> Strona Główna
        </button>
        <button onclick="showTab('idea-pane')" class="tab-btn bg-card-bg text-text-body border border-border px-5 py-3 rounded-xl font-bold flex items-center transition-all cursor-pointer" id="idea-tab">
            <i class="bi bi-lightbulb mr-2 text-lg"></i> Idea Strony
        </button>
        <button onclick="showTab('basket-pane')" class="tab-btn bg-card-bg text-text-body border border-border px-5 py-3 rounded-xl font-bold flex items-center transition-all cursor-pointer" id="basket-tab">
            <i class="bi bi-cart3 mr-2 text-lg"></i> Koszyk (Notatki)
        </button>
    </div>

    <!-- Tab Content Pane Wrapper -->
    <div id="notetTabsContent">

        <!-- TAB 1: STRONA GŁÓWNA (Pulpit użytkownika) -->
        <div class="tab-pane block" id="home-pane">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-text-body mb-1">Pulpit</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Podsumowanie Twojej aktywności w serwisie</p>
                </div>
                <div class="hidden sm:flex">
                    <a href="{{ route('trips') }}" class="border border-primary text-primary hover:bg-primary hover:text-white px-5 py-2.5 rounded-xl font-bold flex items-center transition-all shadow-sm">
                        <i class="bi bi-journal-text mr-2 text-lg"></i> Moje Notatki
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="premium-card p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm text-slate-500 dark:text-slate-400 font-bold mb-0">Aktywne oferty</h3>
                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                <i class="bi bi-files text-lg"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-text-body mb-1">12</div>
                    </div>
                    <div class="text-slate-400 text-xs mt-3">
                        2 sprzedane, 1 oczekująca na ocenę
                    </div>
                </div>

                <div class="premium-card p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm text-slate-500 dark:text-slate-400 font-bold mb-0">Przeglądane przedmioty</h3>
                            <div class="w-10 h-10 rounded-full bg-cyan-500/10 flex items-center justify-center text-cyan-500">
                                <i class="bi bi-mortarboard text-lg"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-text-body mb-1">8</div>
                    </div>
                    <div class="text-slate-400 text-xs mt-3">z 3 różnych wydziałów</div>
                </div>

                <div class="premium-card p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm text-slate-500 dark:text-slate-400 font-bold mb-0">Twój Ranking</h3>
                            <div class="w-10 h-10 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                                <i class="bi bi-award text-lg"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-text-body mb-1">Średnia: 4.8</div>
                    </div>
                    <div class="flex items-center gap-1 mt-3">
                        <i class="bi bi-star-fill text-amber-500 text-xs"></i>
                        <i class="bi bi-star-fill text-amber-500 text-xs"></i>
                        <i class="bi bi-star-fill text-amber-500 text-xs"></i>
                        <i class="bi bi-star-fill text-amber-500 text-xs"></i>
                        <i class="bi bi-star-half text-amber-500 text-xs"></i>
                        <span class="text-slate-400 text-xs ml-1">12 opinii</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Info -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div>
                    <div class="premium-card p-6 h-full">
                        <h3 class="text-lg font-bold mb-4 text-text-body flex items-center"><i class="bi bi-lightning-charge-fill text-primary mr-2"></i>Ostatnia Aktywność</h3>
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center p-4 rounded-xl bg-slate-100/50 dark:bg-slate-800/30">
                                <div class="w-10 h-10 rounded-full bg-amber-500/15 flex items-center justify-center mr-3 text-amber-500 flex-shrink-0">
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <div>
                                    <p class="mb-0.5 font-bold text-sm text-text-body">Otrzymano 5★ ocenę!</p>
                                    <p class="mb-0 text-slate-500 dark:text-slate-400 text-xs">od Marta Z. za "Makroekonomia - Ćwiczenia"</p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 rounded-xl bg-slate-100/50 dark:bg-slate-800/30">
                                <div class="w-10 h-10 rounded-full bg-emerald-500/15 flex items-center justify-center mr-3 text-emerald-500 flex-shrink-0">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div>
                                    <p class="mb-0.5 font-bold text-sm text-text-body">Sprzedano materiał!</p>
                                    <p class="mb-0 text-slate-500 dark:text-slate-400 text-xs">"Fizyka Kwantowa" kupiona przez Paweł P.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="premium-card p-6 h-full hero-banner shadow-lg text-white flex flex-col justify-between">
                        <div>
                            <span class="inline-flex bg-white text-primary font-bold px-3 py-1 mb-4 rounded-full text-xs uppercase tracking-wider">Zarabiaj na Wiedzy</span>
                            <h3 class="text-2xl font-extrabold mb-3">Wystaw nową notatkę!</h3>
                            <p class="mb-6 text-white/70 text-sm leading-relaxed">Wgrywaj swoje skrupulatnie przygotowane opracowania naukowe, wspieraj społeczność akademicką i generuj pasywny dochód.</p>
                        </div>
                        <a href="{{ route('trips') }}" class="bg-white hover:bg-slate-100 text-primary font-bold px-5 py-2.5 rounded-xl text-sm flex items-center shadow-md self-start transition-all cursor-pointer">
                            Dodaj Materiał <i class="bi bi-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: IDEA STRONY (BOGATY KONTENT BEZ GEOGRAFII) -->
        <div class="tab-pane hidden" id="idea-pane">
            <div class="editorial-wrapper py-3">

                <!-- Header Jumbotron -->
                <div class="text-center mb-12">
                    <span class="text-primary font-bold text-uppercase tracking-widest text-xs">Filozofia Projektu</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold mt-2 text-text-body">Ekosystem Cyfrowej Synergii Akademickiej</h2>
                    <p class="text-base text-slate-500 dark:text-slate-400 mt-4 leading-relaxed max-w-2xl mx-auto">Jak unowocześniamy obieg wiedzy bez barier, kształtując zrównoważoną przestrzeń wymiany myśli w środowisku naukowym.</p>
                </div>

                <!-- Editorial Introduction -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center mb-10">
                    <div class="md:col-span-7">
                        <h3 class="text-xl font-bold mb-3 text-text-body">Nowy Wymiar Dzielenia Się Wiedzą</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-4 text-justify">
                            Tradycyjne modele edukacyjne borykają się z ogromnym marnotrawstwem zasobów poznawczych. Prace pisane w pocie czoła, skrupulatnie prowadzone notatki z wykładów, szczegółowo rozpisane projekty semestralne lądują na dnie cyfrowych folderów po zdanym egzaminie. Jest to strata potencjału intelektualnego, który mógłby wielokrotnie służyć kolejnym rocznikom.
                        </p>
                        <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed text-justify">
                            Noted stawia czoła temu wyzwaniu. Przenosimy ideę gospodarki obiegu zamkniętego (<i>circular economy</i>) bezpośrednio na grunt akademicki. Dajemy drugie życie opracowaniom dydaktycznym, pozwalając autorom czerpać korzyści finansowe ze swojego trudu, a kupującym ułatwiając natychmiastowe dotarcie do syntetycznych i sprawdzonych źródeł wiedzy.
                        </p>
                    </div>
                    <div class="md:col-span-5">
                        <div class="p-6 rounded-2xl bg-primary/10 border border-primary/15">
                            <h4 class="font-bold mb-3 text-primary flex items-center"><i class="bi bi-lightbulb-fill mr-2"></i>Wizja Noted</h4>
                            <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed text-justify">
                                Wierzymy w pełną demokratyzację dostępu do materiałów naukowych. Wiedza nie powinna być zamknięta w ciasnych kręgach. Poprzez dynamiczne, zintegrowane mechanizmy oceny to studenci sami kreują standardy jakości dydaktycznej, filtrując i nagradzając najbardziej wartościowe i precyzyjne materiały.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Premium blockquote -->
                <div class="my-10 p-6 rounded-2xl bg-slate-100/50 dark:bg-slate-800/30">
                    <div class="editorial-quote text-text-body text-base">
                        "Czas spędzony na samodzielnej selekcji chaotycznych informacji z sieci to najkosztowniejsza część procesu edukacji. Optymalizacja tej ścieżki za pomocą zweryfikowanych streszczeń to fundament nowoczesnej nauki."
                    </div>
                </div>

                <!-- Rich Cards Grid -->
                <h3 class="text-lg font-bold text-center mb-6 text-text-body">Trzy Filary Naszej Architektury Ideowej</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <div class="premium-card p-6 flex flex-col justify-between">
                        <div>
                            <h5 class="font-bold text-primary mb-3 flex items-center"><i class="bi bi-check-circle-fill mr-2"></i>Mikroekonomia</h5>
                            <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed">Uczciwy system gratyfikacji finansowej dla autorów starannie sporządzonych materiałów. Praca intelektualna zyskuje realny ekwiwalent rynkowy.</p>
                        </div>
                    </div>
                    <div class="premium-card p-6 flex flex-col justify-between">
                        <div>
                            <h5 class="font-bold text-primary mb-3 flex items-center"><i class="bi bi-star-fill mr-2"></i>Kuratela Jakości</h5>
                            <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed">Rygorystyczne, społecznościowe mechanizmy recenzowania materiałów chronią przed błędnymi, niekompletnymi informacjami.</p>
                        </div>
                    </div>
                    <div class="premium-card p-6 flex flex-col justify-between">
                        <div>
                            <h5 class="font-bold text-primary mb-3 flex items-center"><i class="bi bi-sliders mr-2"></i>Zgodność z Intuicją</h5>
                            <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed">Zintegrowany interfejs, w którym interakcja i zakupy przebiegają bez barier. Maksymalne skupienie na samym procesie przyswajania wiedzy.</p>
                        </div>
                    </div>
                </div>

                <!-- Premium Accordion FAQ Section -->
                <h3 class="text-lg font-bold text-center mb-6 text-text-body">Innowacja Technologiczna i Rozwój</h3>
                
                <div class="border border-border bg-card-bg rounded-2xl overflow-hidden shadow-sm mb-12 divide-y divide-border">
                    <!-- Accordion Item 1 -->
                    <div>
                        <button onclick="toggleAccordion('collapseOne')" class="w-full flex justify-between items-center p-5 text-left font-bold text-text-body bg-slate-50 dark:bg-slate-800/10 hover:bg-slate-100 dark:hover:bg-slate-800/30 transition-colors cursor-pointer focus:outline-none">
                            <span>🚀 Dynamiczne Dopasowywanie Treści</span>
                            <i class="bi bi-chevron-down transition-transform duration-200" id="collapseOne-icon" style="transform: rotate(180deg);"></i>
                        </button>
                        <div id="collapseOne" class="p-5 text-slate-500 dark:text-slate-400 text-sm leading-relaxed block">
                            Wykorzystujemy innowacyjne rozwiązania algorytmiczne do precyzyjnego kategoryzowania notatek na podstawie dziedzin naukowych, programów wykładowych oraz tagów semantycznych. Dzięki temu odnalezienie odpowiednich wzorów matematycznych lub streszczeń analitycznych zajmuje zaledwie ułamek sekundy, diametralnie skracając drogę poszukiwań.
                        </div>
                    </div>
                    <!-- Accordion Item 2 -->
                    <div>
                        <button onclick="toggleAccordion('collapseTwo')" class="w-full flex justify-between items-center p-5 text-left font-bold text-text-body hover:bg-slate-100 dark:hover:bg-slate-800/30 transition-colors cursor-pointer focus:outline-none">
                            <span>🛡️ Ochrona Praw Twórców i Weryfikacja Cyfrowa</span>
                            <i class="bi bi-chevron-down transition-transform duration-200" id="collapseTwo-icon"></i>
                        </button>
                        <div id="collapseTwo" class="p-5 text-slate-500 dark:text-slate-400 text-sm leading-relaxed hidden">
                            Bezpieczeństwo i uczciwość intelektualna to nasza absolutna dewiza. Wprowadzamy weryfikację antyplagiatową dla przesyłanych plików oraz dbamy o to, aby prawa autorskie do unikalnych materiałów dydaktycznych były skutecznie chronione. Każda transakcja podlega pełnemu zabezpieczeniu, a autor zachowuje pełną autonomię nad swoim dziełem.
                        </div>
                    </div>
                    <!-- Accordion Item 3 -->
                    <div>
                        <button onclick="toggleAccordion('collapseThree')" class="w-full flex justify-between items-center p-5 text-left font-bold text-text-body hover:bg-slate-100 dark:hover:bg-slate-800/30 transition-colors cursor-pointer focus:outline-none">
                            <span>🎨 Estetyka Poznawcza w Służbie Skupienia</span>
                            <i class="bi bi-chevron-down transition-transform duration-200" id="collapseThree-icon"></i>
                        </button>
                        <div id="collapseThree" class="p-5 text-slate-500 dark:text-slate-400 text-sm leading-relaxed hidden">
                            Zasady projektowania interfejsu Noted opierają się na zaawansowanych badaniach nad percepcją wzrokową i ergonomią. Harmonijne schematy kolorystyczne (w tym innowacyjny motyw kremowy) eliminują zmęczenie oczu podczas całonocnych powtórek materiału, ułatwiając zapamiętywanie kluczowych pojęć w sprzyjającym, estetycznym środowisku.
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- TAB 3: KOSZYK (DYNAMICZNY CRUD NOTATEK) -->
        <div class="tab-pane hidden" id="basket-pane">

            <!-- Stats Counter Row -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 text-center">
                <div class="premium-card p-4">
                    <span class="text-slate-400 text-xs uppercase font-bold tracking-wider">Wszystkie Notatki</span>
                    <h4 class="text-2xl font-extrabold mt-1 text-primary" id="stats-total">0</h4>
                </div>
                <div class="premium-card p-4">
                    <span class="text-slate-400 text-xs uppercase font-bold tracking-wider">Ulubione ❤️</span>
                    <h4 class="text-2xl font-extrabold mt-1 text-red-500" id="stats-favorites">0</h4>
                </div>
                <div class="premium-card p-4">
                    <span class="text-slate-400 text-xs uppercase font-bold tracking-wider">W Trakcie</span>
                    <h4 class="text-2xl font-extrabold mt-1 text-amber-500" id="stats-pending">0</h4>
                </div>
                <div class="premium-card p-4">
                    <span class="text-slate-400 text-xs uppercase font-bold tracking-wider">Zakupione</span>
                    <h4 class="text-2xl font-extrabold mt-1 text-emerald-500" id="stats-purchased">0</h4>
                </div>
            </div>

            <!-- Main Grid Row -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- Left Panel: Create Form Card -->
                <div class="lg:col-span-4">
                    <div class="premium-card p-6 shadow-sm sticky top-5 z-10">
                        <h4 class="text-lg font-bold mb-3 flex items-center text-text-body">
                            <i class="bi bi-plus-circle-fill text-primary mr-2"></i>
                            Wystaw Nową Notatkę
                        </h4>
                        <div class="border-t border-border my-4"></div>

                        <form id="note-form" onsubmit="handleCreateNote(event)" class="flex flex-col gap-4">
                            <div>
                                <label for="form-title" class="block text-xs font-bold text-text-body mb-1.5">Tytuł Opracowania</label>
                                <input type="text" class="w-full px-3 py-2 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm placeholder-slate-400" id="form-title" placeholder="np. Analiza Matematyczna - Całki" required>
                            </div>
                            <div>
                                <label for="form-content" class="block text-xs font-bold text-text-body mb-1.5">Treść / Opis Notatek</label>
                                <textarea class="w-full px-3 py-2 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm placeholder-slate-400 resize-none" id="form-content" rows="4" placeholder="Opisz krótko zawartość, stopień szczegółowości i liczbę stron..." required></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="form-price" class="block text-xs font-bold text-text-body mb-1.5">Cena (PLN)</label>
                                    <input type="number" class="w-full px-3 py-2 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm" id="form-price" step="0.01" min="0" placeholder="0.00" required>
                                </div>
                                <div>
                                    <label for="form-status" class="block text-xs font-bold text-text-body mb-1.5">Status</label>
                                    <select class="w-full px-3 py-2 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm" id="form-status" required>
                                        <option value="w trakcie zakupu" selected>W trakcie</option>
                                        <option value="zakupione">Zakupione</option>
                                        <option value="zwrócone">Zwrócone</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex items-center my-1">
                                <input type="checkbox" class="w-4 h-4 rounded border-border text-primary focus:ring-primary" id="form-favorite">
                                <label class="ml-2 text-sm font-bold text-text-body" for="form-favorite">Dodaj do ulubionych (❤️)</label>
                            </div>
                            <button type="submit" class="w-full py-2.5 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold shadow-md hover:shadow-lg transition-all mt-2 cursor-pointer flex items-center justify-center">
                                <i class="bi bi-plus-lg mr-2"></i> Dodaj do Menedżera
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right Panel: Note cards grid list & filters -->
                <div class="lg:col-span-8">

                    <!-- Filter Pills & Search Input Row -->
                    <div class="premium-card p-4 mb-6">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="w-full md:max-w-xs">
                                <div class="flex rounded-xl shadow-sm border border-border bg-card-bg overflow-hidden focus-within:ring-2 focus-within:ring-primary/30 focus-within:border-primary transition-all">
                                    <span class="inline-flex items-center px-3 text-slate-400 bg-transparent border-r-0"><i class="bi bi-search"></i></span>
                                    <input type="text" class="w-full px-3 py-2 bg-transparent text-text-body border-0 focus:ring-0 focus:outline-none placeholder-slate-400 text-sm" id="search-input" placeholder="Szukaj po tytule lub opisie..." oninput="renderNotes()">
                                </div>
                            </div>
                            <div class="w-full md:w-auto">
                                <div class="flex flex-wrap gap-2 justify-start md:justify-end" id="filter-pills-container">
                                    <button class="px-3.5 py-1.5 rounded-full text-xs font-semibold border border-primary bg-primary text-white transition-colors cursor-pointer" id="pill-all" onclick="setFilter('all')">Wszystkie</button>
                                    <button class="px-3.5 py-1.5 rounded-full text-xs font-semibold border border-border text-slate-600 dark:text-slate-300 hover:border-primary hover:text-primary transition-colors cursor-pointer" id="pill-pending" onclick="setFilter('w trakcie zakupu')">W trakcie</button>
                                    <button class="px-3.5 py-1.5 rounded-full text-xs font-semibold border border-border text-slate-600 dark:text-slate-300 hover:border-primary hover:text-primary transition-colors cursor-pointer" id="pill-purchased" onclick="setFilter('zakupione')">Zakupione</button>
                                    <button class="px-3.5 py-1.5 rounded-full text-xs font-semibold border border-border text-slate-600 dark:text-slate-300 hover:border-primary hover:text-primary transition-colors cursor-pointer" id="pill-returned" onclick="setFilter('zwrócone')">Zwrócone</button>
                                    <button class="px-3.5 py-1.5 rounded-full text-xs font-semibold border border-border text-red-500 hover:border-red-500 hover:bg-red-500/5 transition-colors cursor-pointer" id="pill-favorites" onclick="setFilter('favorites')">❤️ Ulubione</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Cards Grid List -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="notes-container">
                        <!-- Cards populated dynamically by script -->
                    </div>

                </div>

            </div>
        </div>

    </div>

    <!-- Interactive Javascript Logic (Tabs switcher API, dynamic Reactivity, persistent CRUD, Heart trigger) -->
    <script>
        // --- 1. TABS SYSTEM INTERACTIVE SWAP ---
        function showTab(tabId) {
            // Hide all tab panes
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('block');
                pane.classList.add('hidden');
            });
            // Show current panel
            const targetPane = document.getElementById(tabId);
            if (targetPane) {
                targetPane.classList.remove('hidden');
                targetPane.classList.add('block');
            }

            // Deactivate all tab selectors
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.className = "tab-btn bg-card-bg text-text-body border border-border px-5 py-3 rounded-xl font-bold flex items-center transition-all cursor-pointer";
            });

            // Activate current selector btn
            const btnPrefix = tabId.split('-')[0];
            const activeBtn = document.getElementById(btnPrefix + '-tab');
            if (activeBtn) {
                activeBtn.className = "tab-btn bg-primary text-white shadow-md px-5 py-3 rounded-xl font-bold flex items-center transition-all cursor-pointer";
            }
        }

        function switchTabDirect(tabButtonId) {
            const paneId = tabButtonId.replace('-tab', '-pane');
            showTab(paneId);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // --- 2. ACCORDION FAQ SWAP ---
        function toggleAccordion(collapseId) {
            const panel = document.getElementById(collapseId);
            const icon = document.getElementById(collapseId + '-icon');
            if (panel) {
                const isHidden = panel.classList.contains('hidden');
                if (isHidden) {
                    panel.classList.remove('hidden');
                    panel.classList.add('block');
                    if (icon) icon.style.transform = 'rotate(180deg)';
                } else {
                    panel.classList.remove('block');
                    panel.classList.add('hidden');
                    if (icon) icon.style.transform = '';
                }
            }
        }

        // --- 3. ADVANCED FRONTEND NOTES CRUD MOTOR ---
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
            pills.forEach(pill => {
                pill.className = "px-3.5 py-1.5 rounded-full text-xs font-semibold border border-border text-slate-600 dark:text-slate-300 hover:border-primary hover:text-primary transition-colors cursor-pointer";
            });

            const pillMapping = {
                'all': 'pill-all',
                'w trakcie zakupu': 'pill-pending',
                'zakupione': 'pill-purchased',
                'zwrócone': 'pill-returned',
                'favorites': 'pill-favorites'
            };

            const targetPill = document.getElementById(pillMapping[filterType]);
            if (targetPill) {
                if (filterType === 'favorites') {
                    targetPill.className = "px-3.5 py-1.5 rounded-full text-xs font-semibold border border-red-500 bg-red-500 text-white transition-colors cursor-pointer";
                } else {
                    targetPill.className = "px-3.5 py-1.5 rounded-full text-xs font-semibold border border-primary bg-primary text-white transition-colors cursor-pointer";
                }
            }

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
                    <div class="col-span-full text-center py-12">
                        <div class="border-2 border-dashed border-border bg-card-bg rounded-2xl p-12 max-w-md mx-auto">
                            <i class="bi bi-journal-x text-5xl text-slate-400 mb-3 block"></i>
                            <h4 class="text-lg font-bold text-text-body mb-1">Brak Pasujących Materiałów</h4>
                            <p class="text-slate-500 dark:text-slate-400 text-sm">
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
                col.className = 'w-full';
                col.setAttribute('data-card-id', note.id);

                if (isEditing) {
                    // RENDERING IN EDIT MODE
                    col.innerHTML = `
                        <div class="premium-card p-6 shadow-sm border-primary flex flex-col gap-4">
                            <div>
                                <label class="block text-xs font-bold text-text-body mb-1.5">Tytuł Opracowania</label>
                                <input type="text" class="w-full px-3 py-2 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm edit-title-field" value="${escapeHtml(note.title)}" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-text-body mb-1.5">Treść</label>
                                <textarea class="w-full px-3 py-2 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm edit-content-field" rows="3" required>${escapeHtml(note.content)}</textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-text-body mb-1.5">Cena (PLN)</label>
                                    <input type="number" class="w-full px-3 py-2 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm edit-price-field" step="0.01" min="0" value="${note.price}">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-text-body mb-1.5">Status</label>
                                    <select class="w-full px-3 py-2 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm edit-status-field">
                                        <option value="w trakcie zakupu" ${note.status === 'w trakcie zakupu' ? 'selected' : ''}>W trakcie</option>
                                        <option value="zakupione" ${note.status === 'zakupione' ? 'selected' : ''}>Zakupione</option>
                                        <option value="zwrócone" ${note.status === 'zwrócone' ? 'selected' : ''}>Zwrócone</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2 mt-2">
                                <button class="px-3.5 py-1.5 border border-border rounded-xl text-xs font-semibold text-text-body hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors cursor-pointer" onclick="cancelInlineEdit()">Anuluj</button>
                                <button class="px-3.5 py-1.5 bg-primary hover:bg-primary-hover text-white rounded-xl text-xs font-bold shadow-sm transition-colors cursor-pointer" onclick="saveInlineEdit(${note.id})">Zapisz</button>
                            </div>
                        </div>
                    `;
                } else {
                    // RENDERING IN NORMAL VIEW MODE
                    let statusBadgeClass = '';
                    let statusText = '';
                    if (note.status === 'zakupione') {
                        statusBadgeClass = 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-900/30';
                        statusText = 'Kupiono';
                    } else if (note.status === 'w trakcie zakupu') {
                        statusBadgeClass = 'bg-amber-100 text-amber-800 dark:bg-amber-950/30 dark:text-amber-400 border border-amber-200 dark:border-amber-900/30';
                        statusText = 'Oczekuje';
                    } else {
                        statusBadgeClass = 'bg-red-100 text-red-800 dark:bg-red-950/30 dark:text-red-400 border border-red-200 dark:border-red-900/30';
                        statusText = 'Zwrócono';
                    }

                    col.innerHTML = `
                        <div class="premium-card h-full flex flex-col justify-between p-6 shadow-sm">
                            <div>
                                <div class="flex justify-between items-start gap-2 mb-3">
                                    <h4 class="text-base font-bold text-text-body mb-0 leading-snug">${escapeHtml(note.title)}</h4>
                                    <button class="heart-btn ${note.favorite ? 'active' : ''}" onclick="toggleFavorite(${note.id}, event)" title="${note.favorite ? 'Usuń z ulubionych' : 'Dodaj do ulubionych'}">
                                        <i class="bi bi-heart fs-5"></i>
                                        <i class="bi bi-heart-fill fs-5"></i>
                                    </button>
                                </div>
                                <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-4 text-break">${escapeHtml(note.content)}</p>
                            </div>

                            <div>
                                <div class="border-t border-border my-4"></div>
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center text-primary font-bold text-sm">
                                        <i class="bi bi-tag-fill mr-1.5 text-xs"></i>
                                        <span>${note.price.toFixed(2)} PLN</span>
                                    </div>

                                    <select class="form-select w-auto py-1 px-3.5 border-0 font-bold rounded-full text-uppercase text-[10px] ${statusBadgeClass} focus:ring-0 focus:outline-none cursor-pointer"
                                            onchange="handleQuickStatusChange(${note.id}, this.value)" style="cursor: pointer;">
                                        <option value="w trakcie zakupu" ${note.status === 'w trakcie zakupu' ? 'selected' : ''}>Oczekuje</option>
                                        <option value="zakupione" ${note.status === 'zakupione' ? 'selected' : ''}>Kupiono</option>
                                        <option value="zwrócone" ${note.status === 'zwrócone' ? 'selected' : ''}>Zwrócono</option>
                                    </select>
                                </div>

                                <div class="flex justify-end gap-2 mt-4 pt-2">
                                    <button class="bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-text-body px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center transition-colors border border-border cursor-pointer" onclick="startInlineEdit(${note.id})">
                                        <i class="bi bi-pencil mr-1.5"></i> Edytuj
                                    </button>
                                    <button class="border border-red-200 hover:border-red-500 text-red-500 hover:bg-red-500/5 px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center transition-colors cursor-pointer" onclick="handleDeleteNote(${note.id})">
                                        <i class="bi bi-trash3 mr-1.5"></i> Usuń
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
