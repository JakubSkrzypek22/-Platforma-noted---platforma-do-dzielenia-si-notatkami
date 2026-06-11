<?php

/**
 * Próbki notatek do seedera.
 * Każdy wpis: [tytuł, kategoria, uczelnia, cena, opis]
 *
 * Opisy celowo zawierają kierunek, przedmiot, semestr i słowa kluczowe —
 * przygotowane pod przyszłe filtrowanie po tytule, opisie, uczelni i kategorii.
 */
return [
    // ── Matematyka ──
    ['Analiza Matematyczna 1 — kompletne opracowanie teorii', 'Matematyka', 'Politechnika Warszawska', 14.99, 'Kierunek: Matematyka stosowana. Przedmiot: Analiza matematyczna I (semestr 1). Zbiór twierdzeń, definicji i przykładowych zadań: granice, ciągi, pochodne, całki oznaczone i nieoznaczone. Materiał z wykładów PW i ćwiczeń kolokwialnych.'],
    ['Algebra liniowa — macierze, wektory i przekształcenia', 'Matematyka', 'UAM Poznań', 13.50, 'Kierunek: Matematyka. Przedmiot: Algebra liniowa (semestr 2). Macierze, wyznaczniki, układy równań, przestrzenie wektorowe, bazy ortonormalne i wartości własne. Przykłady z egzaminów UAM.'],
    ['Geometria analityczna — stożkowe i przekształcenia', 'Matematyka', 'Uniwersytet Łódzki', 9.00, 'Kierunek: Matematyka nauczycielska. Przedmiot: Geometria analityczna. Elipsy, hiperbole, parabole, przekształcenia izometrii i affinity. Zadania z parametrem i dowody geometryczne.'],
    ['Rachunek prawdopodobieństwa — rozkłady i twierdzenie Bayesa', 'Matematyka', 'Politechnika Krakowska', 16.00, 'Kierunek: Informatyka stosowana. Przedmiot: Rachunek prawdopodobieństwa. Kombinatoryka, rozkłady dwumianowy, Poissona i normalny. Estymacja, testowanie hipotez i regresja liniowa.'],
    ['Równania różniczkowe — metody analityczne', 'Matematyka', 'Politechnika Wrocławska', 0, 'Kierunek: Automatyka i robotyka. Przedmiot: Równania różniczkowe zwyczajne (semestr 4). Metoda Eulera, Rungego-Kutty, układy liniowe i równania o stałych współczynnikach.'],
    ['Statystyka matematyczna — wprowadzenie', 'Matematyka', 'Uniwersytet Mikołaja Kopernika w Toruniu', 11.50, 'Kierunek: Data Science. Przedmiot: Statystyka. Średnia, wariancja, rozkłady, przedziały ufności i test chi-kwadrat. Przykłady w R i Excelu.'],
    ['Logika matematyczna — dowodzenie i teoria mnogości', 'Matematyka', 'Uniwersytet Wrocławski', 8.50, 'Kierunek: Informatyka. Przedmiot: Logika i teoria mnogości. Kwantyfikatory, indukcja, relacje, funkcje i zbiory nieskończone. Przygotowanie do egzaminu z logiki.'],

    // ── Medycyna ──
    ['Anatomia Prawidłowa — układ nerwowy i naczyniowy', 'Medycyna', 'Uniwersytet Jagielloński', 24.50, 'Kierunek: Lekarski. Przedmiot: Anatomia (semestr 2). Ośrodkowy i obwodowy układ nerwowy, tętnice, żyły i unaczynienie narządów. Tabele mięśni i schematy anatomiczne CM UJ.'],
    ['Fizjologia człowieka — układ krążenia i oddechowy', 'Medycyna', 'Collegium Medicum UMK w Bydgoszczy', 21.00, 'Kierunek: Lekarski. Przedmiot: Fizjologia. Hemodynamika, ciśnienie krwi, wymiana gazowa i regulacja oddechu. Notatki z wykładów i streszczenia pod egzamin ustny.'],
    ['Biochemia kliniczna — metabolizm węglowodanów i lipidów', 'Medycyna', 'Uniwersytet Medyczny w Lublinie', 18.00, 'Kierunek: Lekarski-dentystyczny. Przedmiot: Biochemia. Glikoliza, cykl Krebsa, beta-oksydacja i enzymy kluczowe. Schematy metaboliczne do nauki.'],
    ['Farmakologia ogólna — mechanizmy działania leków', 'Medycyna', 'Uniwersytet Medyczny w Poznaniu', 19.99, 'Kierunek: Farmacja. Przedmiot: Farmakologia. Receptory, agoniści, antagoniści, farmakokinetyka i interakcje lekowe. Tabele dawkowania i przeciwwskazań.'],
    ['Patologia — procesy zapalne i nowotworowe', 'Medycyna', 'Uniwersytet Jagielloński', 0, 'Kierunek: Lekarski. Przedmiot: Patologia ogólna. Zapalenie ostre i przewlekłe, gojenie ran, dysplazja i procesy nowotworowe. Mikroskopowe obrazy chorób.'],
    ['Pediatria — rozwój dziecka i szczepienia', 'Medycyna', 'Uniwersytet Medyczny w Warszawie', 15.50, 'Kierunek: Lekarski. Przedmiot: Pediatria (semestr 8). Kamienie milowe rozwoju, karmienie, szczepienia obowiązkowe i najczęstsze choroby wieku dziecięcego.'],
    ['Psychiatria — klasyfikacja ICD-10 i farmakoterapia', 'Medycyna', 'Uniwersytet Medyczny we Wrocławiu', 17.00, 'Kierunek: Lekarski. Przedmiot: Psychiatria. Zaburzenia afektywne, lękowe, psychotyczne i terapie SSRI, SNRI, antypsychotyki.'],

    // ── Informatyka ──
    ['Programowanie Obiektowe w C++ i Java', 'Informatyka', 'AGH w Krakowie', 0, 'Kierunek: Informatyka. Przedmiot: Programowanie obiektowe. Polimorfizm, dziedziczenie, hermetyzacja, interfejsy i klasy abstrakcyjne. Przykłady kodu C++17 i Java 17.'],
    ['Algorytmy i Struktury Danych — kompleksowy przewodnik', 'Informatyka', 'Politechnika Poznańska', 22.00, 'Kierunek: Informatyka. Przedmiot: Algorytmy i struktury danych. Sortowanie, grafy, drzewa binarne, BFS, DFS i programowanie dynamiczne z analizą złożoności O(n).'],
    ['Bazy danych SQL — projektowanie i optymalizacja zapytań', 'Informatyka', 'Politechnika Warszawska', 16.50, 'Kierunek: Informatyka stosowana. Przedmiot: Bazy danych. Normalizacja, klucze obce, JOIN, indeksy, transakcje ACID i optymalizacja zapytań PostgreSQL.'],
    ['Sieci komputerowe — model OSI i protokół TCP/IP', 'Informatyka', 'Politechnika Gdańska', 14.00, 'Kierunek: Telekomunikacja. Przedmiot: Sieci komputerowe. Warstwy OSI, routing IP, DNS, DHCP, TCP, UDP i podstawy bezpieczeństwa sieci.'],
    ['Systemy operacyjne — procesy, wątki i pamięć', 'Informatyka', 'Uniwersytet Wrocławski', 13.00, 'Kierunek: Informatyka. Przedmiot: Systemy operacyjne. Planowanie CPU, deadlocki, pamięć wirtualna, stronicowanie i system plików Linux.'],
    ['Sztuczna inteligencja — uczenie maszynowe i sieci neuronowe', 'Informatyka', 'Politechnika Łódzka', 25.00, 'Kierunek: Data Science. Przedmiot: Sztuczna inteligencja. Regresja, klasyfikacja, drzewa decyzyjne, SVM, CNN i backpropagation. Przykłady w Pythonie i scikit-learn.'],
    ['Inżynieria oprogramowania — wzorce projektowe i UML', 'Informatyka', 'Uniwersytet Warszawski', 18.50, 'Kierunek: Informatyka. Przedmiot: Inżynieria oprogramowania. Wzorce Singleton, Factory, Observer, diagramy UML, SCRUM i testy jednostkowe JUnit.'],
    ['Bezpieczeństwo systemów — kryptografia i OWASP Top 10', 'Informatyka', 'AGH w Krakowie', 20.00, 'Kierunek: Cyberbezpieczeństwo. Przedmiot: Bezpieczeństwo IT. Szyfrowanie symetryczne i asymetryczne, hash SHA, XSS, SQL injection i OWASP Top 10.'],

    // ── Prawo ──
    ['Prawo Rzymskie — skrót przedegzaminacyjny', 'Prawo', 'Uniwersytet Warszawski', 9.99, 'Kierunek: Prawo. Przedmiot: Prawo rzymskie (semestr 2). Instytucje, obligacje, własność, dziedziczenie i łacińskie paremie prawne. Schematy powiązań przed egzamin.'],
    ['Prawo cywilne — zobowiązania i odpowiedzialność kontraktowa', 'Prawo', 'Uniwersytet Jagielloński', 12.50, 'Kierunek: Prawo. Przedmiot: Prawo cywilne — część ogólna i zobowiązania. Wina, niedopełnienie, odstąpienie od umowy i odpowiedzialność deliktowa.'],
    ['Prawo karne materialne — typy przestępstw i kary', 'Prawo', 'Uniwersytet Mikołaja Kopernika w Toruniu', 11.00, 'Kierunek: Prawo. Przedmiot: Prawo karne materialne. Zbrodnie, występki, recydywa, wymiar kary i okoliczności łagodzące. Orzecznictwo SN i przykłady spraw.'],
    ['Prawo administracyjne — postępowanie i kontrola', 'Prawo', 'Uniwersytet Gdański', 10.50, 'Kierunek: Administracja publiczna. Przedmiot: Prawo administracyjne. Decyzje administracyjne, odwołania, KPA i kontrola działalności administracji.'],
    ['Prawo europejskie — instytucje UE i prawo konkurencji', 'Prawo', 'Uniwersytet Wrocławski', 0, 'Kierunek: Prawo europejskie. Przedmiot: Prawo Unii Europejskiej. Traktaty, Parlament, Rada, Trybunał Sprawiedliwości i prawo konkurencji.'],
    ['Prawo pracy — stosunek pracy i wypowiedzenie', 'Prawo', 'SWPS Uniwersytet Humanistycznospołeczny', 8.99, 'Kierunek: Prawo pracy i ubezpieczeń społecznych. Przedmiot: Prawo pracy. Umowy o pracę, okresy wypowiedzenia, mobbing i odszkodowania.'],
    ['Postępowanie cywilne — żal, apelacja, dowody', 'Prawo', 'Uniwersytet Łódzki', 13.00, 'Kierunek: Prawo. Przedmiot: Postępowanie cywilne. Pozew, żal, apelacja, kasacja, dowody z dokumentów i przesłuchanie świadków.'],

    // ── Ekonomia ──
    ['Podstawy Makroekonomii — wskaźniki, modele, polityka', 'Ekonomia', 'Szkoła Główna Handlowa', 12.00, 'Kierunek: Ekonomia. Przedmiot: Makroekonomia I. PKB, inflacja, bezrobocie, model IS-LM i polityka monetarna NBP.'],
    ['Mikroekonomia — popyt, podaż i elastyczność', 'Ekonomia', 'Uniwersytet Ekonomiczny w Krakowie', 10.00, 'Kierunek: Finanse i rachunkowość. Przedmiot: Mikroekonomia. Krzywe popytu i podaży, koszty krańcowe, maksymalizacja zysku i rynek doskonałej konkurencji.'],
    ['Rachunkowość finansowa — bilans, rachunek zysków i strat', 'Ekonomia', 'Uniwersytet Ekonomiczny w Poznaniu', 14.50, 'Kierunek: Rachunkowość i audyt. Przedmiot: Rachunkowość finansowa. Bilans, RZiS, przepływy pieniężne, amortyzacja i rezerwy. Zgodność z MSSF.'],
    ['Finanse przedsiębiorstw — WACC i wycena akcji', 'Ekonomia', 'Szkoła Główna Handlowa', 17.00, 'Kierunek: Finanse i bankowość. Przedmiot: Finanse przedsiębiorstw. WACC, NPV, IRR, wycena DCF i struktura kapitału Modiglianiego-Millera.'],
    ['Marketing strategiczny — analiza SWOT i segmentacja', 'Ekonomia', 'Uniwersytet Ekonomiczny we Wrocławiu', 0, 'Kierunek: Zarządzanie i marketing. Przedmiot: Marketing. Analiza SWOT, macierz BCG, segmentacja rynku, pozycjonowanie i mix marketingowy 4P.'],
    ['Econometrics — regresja wieloraka i testy statystyczne', 'Ekonomia', 'Uniwersytet Ekonomiczny w Katowicach', 19.00, 'Kierunek: Ekonometria. Przedmiot: Ekonometria. Regresja liniowa, R-kwadrat, test F, heteroskedastyczność i autokorelacja. Przykłady w Stata.'],
    ['Podatki i prawo podatkowe — PIT, CIT, VAT', 'Ekonomia', 'Akademia Leona Koźmińskiego', 15.00, 'Kierunek: Finanse i prawo podatkowe. Przedmiot: Prawo podatkowe. Stawki PIT, odliczenia, CIT, VAT i ulgi podatkowe dla przedsiębiorców.'],

    // ── Języki Obce ──
    ['Gramatyka opisowa języka angielskiego (Tenses & Syntax)', 'Języki Obce', 'Uniwersytet Wrocławski', 7.50, 'Kierunek: Filologia angielska. Przedmiot: Gramatyka opisowa. Czasy Present, Past, Future, Passive Voice, Reported Speech i Conditional Sentences.'],
    ['Business English — negocjacje i korespondencja firmowa', 'Języki Obce', 'Uniwersytet Łódzki', 9.00, 'Kierunek: Lingwistyka stosowana. Przedmiot: Business English. E-maile formalne, negocjacje, prezentacje i słownictwo branżowe finansów.'],
    ['Niemiecki B2 — słownictwo akademickie i artykuły', 'Języki Obce', 'Uniwersytet Warszawski', 8.00, 'Kierunek: Germanistyka. Przedmiot: Język niemiecki B2. Artykuły naukowe, słownictwo akademickie, Konjunktiv I i II oraz słownictwo prawnicze.'],
    ['Hiszpański — gramatyka i konwersacje (DELE B1)', 'Języki Obce', 'Uniwersytet Jagielloński', 7.00, 'Kierunek: Iberystyka. Przedmiot: Język hiszpański. Czasowniki nieregularne, Subjuntivo, konwersacje i przygotowanie do egzaminu DELE B1.'],
    ['Francuski — literatura i analiza tekstu', 'Języki Obce', 'Uniwersytet im. Adama Mickiewicza w Poznaniu', 0, 'Kierunek: Romanistyka — filologia francuska. Przedmiot: Literatura francuska. Baudelaire, Camus, Sartre, analiza tekstu i metody interpretacji.'],
    ['Tłumaczenia specjalistyczne — prawo i medycyna', 'Języki Obce', 'Uniwersytet SWPS', 11.00, 'Kierunek: Tłumaczenia specjalistyczne. Przedmiot: Tłumaczenia prawnicze i medyczne. Terminologia, false friends, konwencje tłumaczeniowe EN-PL.'],
    ['Phonetyka angielska — transkrypcja IPA i akcent', 'Języki Obce', 'Uniwersytet Gdański', 6.50, 'Kierunek: Filologia angielska. Przedmiot: Fonetyka i fonologia. Alfabet IPA, akcent słowny i zdaniowy, redukcja samogłosek i intonacja.'],

    // ── Fizyka ──
    ['Mechanika Kwantowa — podstawy i formalizm', 'Fizyka', 'Politechnika Gdańska', 19.99, 'Kierunek: Fizyka techniczna. Przedmiot: Mechanika kwantowa. Równanie Schrödingera, operator Hamiltona, zasada nieoznaczoności i model atomu wodoru.'],
    ['Termodynamika — zasady i procesy', 'Fizyka', 'Politechnika Łódzka', 0, 'Kierunek: Inżynieria mechaniczna. Przedmiot: Termodynamika. Cztery zasady, entropia, entalpia, cykl Carnota i diagram p-v.'],
    ['Elektromagnetyzm — prawo Gaussa i Ampère\'a', 'Fizyka', 'Uniwersytet Warszawski', 15.00, 'Kierunek: Fizyka. Przedmiot: Elektromagnetyzm. Prawo Coulomba, pole elektryczne, indukcja magnetyczna i równania Maxwella.'],
    ['Optyka — interferencja, dyfrakcja i polaryzacja', 'Fizyka', 'Politechnika Wrocławska', 12.00, 'Kierunek: Fotonika. Przedmiot: Optyka fizyczna. Interferencja Younga, siatki dyfrakcyjne, soczewki cienkie i polaryzacja światła.'],
    ['Mechanika klasyczna — dynamika i bryła sztywna', 'Fizyka', 'Politechnika Poznańska', 13.50, 'Kierunek: Mechanika i budowa maszyn. Przedmiot: Mechanika techniczna. Prawa Newtona, moment bezwładności, energia kinetyczna i ruch obrotowy.'],
    ['Astronomia — Układ Słoneczny i gwiazdy', 'Fizyka', 'Uniwersytet Mikołaja Kopernika w Toruniu', 10.00, 'Kierunek: Astronomia. Przedmiot: Astronomia ogólna. Planety, gwiazdy, galaktyki, wielkości astronomiczne i metody obserwacji.'],
    ['Fizyka jądrowa — promieniotwórczość i reaktory', 'Fizyka', 'AGH w Krakowie', 16.50, 'Kierunek: Inżynieria jądrowa. Przedmiot: Fizyka jądrowa. Rozpad alfa, beta, gamma, reakcje jądrowe i bezpieczeństwo reaktorów.'],

    // ── Chemia ──
    ['Chemia Organiczna — reakcje substytucji i eliminacji', 'Chemia', 'Politechnika Wrocławska', 11.00, 'Kierunek: Chemia. Przedmiot: Chemia organiczna II. Reakcje SN1, SN2, E1, E2, alkohole, aldehydy i kwasy karboksylowe.'],
    ['Stechiometria — skrypt ćwiczeniowy', 'Chemia', 'Uniwersytet Gdański', 8.99, 'Kierunek: Chemia środowiska. Przedmiot: Stechiometria. 60 zadań: stężenia molowe, pH, równowagi chemiczne i obliczenia stechiometryczne.'],
    ['Chemia nieorganiczna — układ okresowy i wiązania', 'Chemia', 'Uniwersytet Jagielloński', 10.50, 'Kierunek: Chemia. Przedmiot: Chemia nieorganiczna. Układ okresowy, wiązania jonowe i kowalencyjne, hybrydyzacja i geometria cząsteczek.'],
    ['Biochemia — enzymy, białka i kwasy nukleinowe', 'Chemia', 'Uniwersytet Warszawski', 14.00, 'Kierunek: Biotechnologia. Przedmiot: Biochemia. Struktura białek, enzymy, DNA, RNA i replikacja. Schematy metaboliczne.'],
    ['Analityka chemiczna — chromatografia i spektroskopia', 'Chemia', 'Politechnika Łódzka', 0, 'Kierunek: Chemia analityczna. Przedmiot: Analityka instrumentalna. HPLC, GC, UV-Vis, IR i NMR — zasady i interpretacja widm.'],
    ['Chemia fizyczna — kinetyka i termodynamika chemiczna', 'Chemia', 'Politechnika Warszawska', 13.00, 'Kierunek: Chemia. Przedmiot: Chemia fizyczna. Równanie Arrheniusa, równowaga chemiczna, entalpia reakcji i potencjał redoks.'],
    ['Ekotoksykologia — zanieczyszczenia i biodegradacja', 'Chemia', 'Uniwersytet Gdański', 9.50, 'Kierunek: Ochrona środowiska. Przedmiot: Ekotoksykologia. Metale ciężkie, pestycydy, BPA, bioakumulacja i metody remediacji gleb.'],

    // ── Uniwersytet Rzeszowski ──
    ['Programowanie w Pythonie — od podstaw do analizy danych', 'Informatyka', 'Uniwersytet Rzeszowski', 12.00, 'Kierunek: Informatyka (Wydział Matematyki i Nauk Przyrodniczych). Przedmiot: Programowanie. Składnia Pythona, listy, słowniki, funkcje, pliki CSV i wprowadzenie do pandas. Materiał z ćwiczeń na UR.'],
    ['Bazy danych — projektowanie schematów i SQL', 'Informatyka', 'Uniwersytet Rzeszowski', 0, 'Kierunek: Informatyka stosowana. Przedmiot: Bazy danych (semestr 3). Diagramy ER, normalizacja, zapytania SELECT, JOIN i procedury składowane. Przykłady z projektów zaliczeniowych UR.'],
    ['Anatomia człowieka — układ kostny i mięśniowy', 'Medycyna', 'Uniwersytet Rzeszowski', 18.50, 'Kierunek: Lekarski (Collegium Medicum im. F. P. Radziwiłła w Białymstoku — filia UR). Przedmiot: Anatomia. Kości, stawy, mięśnie kończyn i tułowia. Tabele do egzaminu praktycznego z anatomii.'],
    ['Prawo cywilne — własność i spadki', 'Prawo', 'Uniwersytet Rzeszowski', 10.00, 'Kierunek: Prawo (Wydział Prawa). Przedmiot: Prawo cywilne — rzeczowe. Własność, współwłasność, służebności, spadki i dziedziczenie ustawowe. Notatki z wykładów prof. UR.'],
    ['Makroekonomia — PKB, inflacja i polityka fiskalna', 'Ekonomia', 'Uniwersytet Rzeszowski', 9.50, 'Kierunek: Ekonomia (Wydział Ekonomiczny). Przedmiot: Makroekonomia I. Agregaty makroekonomiczne, krzywa Phillipsa, polityka fiskalna i rola NBP. Przykłady z polskiej gospodarki.'],
    ['Algebra liniowa — układy równań i macierze', 'Matematyka', 'Uniwersytet Rzeszowski', 8.00, 'Kierunek: Matematyka stosowana. Przedmiot: Algebra liniowa (semestr 1). Metoda Gaussa, macierze odwrotne, wyznaczniki i zastosowania w informatyce. Zadania z kolokwiów UR.'],
    ['Język angielski akademicki — pisanie esejów i prezentacji', 'Języki Obce', 'Uniwersytet Rzeszowski', 6.50, 'Kierunek: Filologia angielska. Przedmiot: English for Academic Purposes. Struktura eseju, cytowania APA, prezentacje konferencyjne i słownictwo naukowe. Przygotowanie do egzaminu B2 na UR.'],
    ['Fizyka ogólna — mechanika i drgania', 'Fizyka', 'Uniwersytet Rzeszowski', 11.00, 'Kierunek: Inżynieria mechaniczna. Przedmiot: Fizyka I. Kinematyka, dynamika, praca i energia, drgania harmoniczne i fale. Wzory i zadania egzaminacyjne z UR.'],
];
