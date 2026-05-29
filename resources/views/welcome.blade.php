@extends('layouts.app')

@section('content')
<style>
    /* Hero Section with Dimmed Background and soft zoom */
    .hero-section {
        position: relative;
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.94) 0%, rgba(30, 41, 59, 0.86) 100%), url("{{ asset('img/carousel3.jpg') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        min-height: 85vh;
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    /* Modern text gradient effect */
    .text-gradient {
        background: linear-gradient(135deg, #ffffff 30%, var(--bs-primary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    /* Fade-in and slide-up animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: perspective(1000px) rotateY(-15deg) rotateX(10deg) translateY(0px);
        }
        50% {
            transform: perspective(1000px) rotateY(-15deg) rotateX(10deg) translateY(-12px);
        }
    }

    @keyframes pulseGlow {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(var(--bs-primary-rgb), 0.45);
        }
        50% {
            box-shadow: 0 0 25px 8px rgba(var(--bs-primary-rgb), 0.25);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .delay-1 { animation-delay: 0.15s; opacity: 0; }
    .delay-2 { animation-delay: 0.3s; opacity: 0; }
    .delay-3 { animation-delay: 0.45s; opacity: 0; }

    /* Float Animation for Hero Mockup Card */
    .floating-mockup {
        animation: float 6s ease-in-out infinite;
        transform-style: preserve-3d;
    }

    /* Pulsing Primary Button */
    .btn-pulse-primary {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
        color: #ffffff;
        animation: pulseGlow 3s infinite;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-pulse-primary:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.9);
        border-color: rgba(var(--bs-primary-rgb), 0.9);
        color: #ffffff;
        transform: translateY(-3px);
    }

    /* Premium responsive cards that adapt to the active theme */
    .premium-card {
        background: var(--bs-card-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 1.5rem;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.08);
    }

    .premium-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15);
        border-color: rgba(var(--bs-primary-rgb), 0.4);
    }

    /* Styled icon wrappers with theme compatibility */
    .icon-box {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--bs-primary) 0%, rgba(var(--bs-primary-rgb), 0.7) 100%);
        color: #ffffff;
        border-radius: 1.15rem;
        font-size: 1.85rem;
        margin-bottom: 1.75rem;
        transition: all 0.3s ease;
    }

    .premium-card:hover .icon-box {
        transform: scale(1.1) rotate(6deg);
        box-shadow: 0 10px 20px rgba(var(--bs-primary-rgb), 0.3);
    }

    /* Unified style for statistics section */
    .stat-counter-box {
        border-right: 1px solid var(--bs-border-color);
    }
    
    @media (max-width: 767.98px) {
        .stat-counter-box {
            border-right: none;
            border-bottom: 1px solid var(--bs-border-color);
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .stat-counter-box:last-child {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }
    }

    /* "Jak to działa" Steps */
    .step-badge {
        width: 54px;
        height: 54px;
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary);
        font-weight: 700;
        font-size: 1.35rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem auto;
        border: 2px solid rgba(var(--bs-primary-rgb), 0.15);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .step-item:hover .step-badge {
        background-color: var(--bs-primary);
        color: #ffffff;
        transform: scale(1.15);
        box-shadow: 0 8px 20px rgba(var(--bs-primary-rgb), 0.25);
    }

    .step-connector {
        position: absolute;
        top: 27px;
        right: -50%;
        width: 100%;
        height: 2px;
        background-color: var(--bs-border-color);
        z-index: -1;
    }

    @media (max-width: 991.98px) {
        .step-connector {
            display: none;
        }
    }

    /* Testimonial styling */
    .testimonial-card {
        background: var(--bs-secondary-bg);
        border: 1px solid var(--bs-border-color);
        border-left: 5px solid var(--bs-primary);
        border-radius: 0.75rem 1.5rem 1.5rem 0.75rem;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
        transition: transform 0.3s ease;
    }

    .testimonial-card:hover {
        transform: scale(1.02);
    }

    /* Text opacity helpers for dark-friendly overlay */
    .text-light-emphasis {
        color: rgba(255, 255, 255, 0.85) !important;
    }
    
    .text-white-60 {
        color: rgba(255, 255, 255, 0.6) !important;
    }
</style>

<!-- SECJA HERO -->
<section class="hero-section text-white d-flex align-items-center py-5">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center gy-5">
            <!-- Tekst i CTA -->
            <div class="col-lg-6 text-center text-lg-start animate-fade-in-up delay-1">
                <div class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-20 px-3 py-2 rounded-pill mb-4 fs-6">
                    <span class="text-warning">💡</span> Dziel się, pobieraj, rozwijaj!
                </div>
                
                <h1 class="display-3 fw-extrabold mb-4 lh-sm">
                    Podziel Się Wiedzą, <br>
                    <span class="text-gradient fw-black">Zainspiruj Innych</span>
                </h1>
                
                <p class="lead fs-4 mb-5 text-light-emphasis fw-light">
                    Dołącz do ogólnokrajowej platformy dla studentów, uczniów i pasjonatów nauki. Przeglądaj wysokiej jakości notatki, udostępniaj własne opracowania i osiągaj lepsze wyniki w nauce razem z nami.
                </p>
                
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                    <a href="{{ route('register') }}" class="btn btn-pulse-primary btn-cta btn-lg px-4 py-3 rounded-3 fw-bold d-inline-flex align-items-center justify-content-center">
                        <i class="bi bi-person-plus-fill me-2 fs-5"></i> Załóż darmowe konto
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-cta btn-lg px-4 py-3 rounded-3 fw-bold d-inline-flex align-items-center justify-content-center border-2">
                        <i class="bi bi-box-arrow-in-right me-2 fs-5"></i> Zaloguj się
                    </a>
                </div>
            </div>

            <!-- Interaktywny Mockup / Wizualizacja (Tylko desktop) -->
            <div class="col-lg-6 d-none d-lg-block animate-fade-in-up delay-2">
                <div class="floating-mockup mx-auto" style="max-width: 480px;">
                    <div class="p-4 rounded-4 shadow-lg border border-white border-opacity-20 position-relative" 
                         style="background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(20px); box-shadow: 0 40px 80px rgba(0,0,0,0.5) !important;">
                        
                        <!-- Header notatki mockup -->
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary rounded-3 p-2.5 me-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 46px; height: 46px;">
                                <i class="bi bi-file-earmark-code text-white fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-white fw-bold">Algorytmy_i_Zlozonosc.pdf</h6>
                                <small class="text-white-60">Przed chwilą dodano • Informatyka</small>
                            </div>
                            <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 ms-auto px-2.5 py-1.5">Zweryfikowane ✓</span>
                        </div>
                        
                        <!-- Treść mockup -->
                        <p class="text-white-60 small mb-4 lh-relaxed">
                            Kompletne notatki z wykładów na temat struktur danych (drzewa AVL, grafy) oraz teorii złożoności obliczeniowej (problemy P vs NP). Opracowane przez studenta Politechniki.
                        </p>
                        
                        <!-- Tag mockup -->
                        <div class="d-flex gap-2 mb-4 flex-wrap">
                            <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-10 rounded-pill px-2.5 py-1.5 small">Politechnika</span>
                            <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-10 rounded-pill px-2.5 py-1.5 small">Algorytmy</span>
                            <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-10 rounded-pill px-2.5 py-1.5 small">Sesja_2026</span>
                        </div>
                        
                        <!-- Stopka mockup -->
                        <div class="d-flex align-items-center justify-content-between text-white-60 border-top border-white border-opacity-10 pt-3 small">
                            <span class="d-inline-flex align-items-center"><i class="bi bi-eye-fill me-1.5"></i> 1,482 wyświetleń</span>
                            <span class="d-inline-flex align-items-center"><i class="bi bi-cloud-arrow-down-fill me-1.5"></i> 584 pobrań</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEKCJA STATYSTYK -->
<section class="py-5 border-bottom border-top" style="background: var(--bs-body-bg);">
    <div class="container py-3">
        <div class="row text-center gy-4">
            <div class="col-md-4 stat-counter-box">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <i class="bi bi-file-earmark-text text-primary fs-1"></i>
                    <div class="text-start">
                        <h2 class="fw-extrabold mb-0 fs-1">15,000+</h2>
                        <p class="text-muted mb-0 fw-medium">Dodanych notatek</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stat-counter-box">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <i class="bi bi-people text-primary fs-1"></i>
                    <div class="text-start">
                        <h2 class="fw-extrabold mb-0 fs-1">4,800+</h2>
                        <p class="text-muted mb-0 fw-medium">Aktywnych studentów</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stat-counter-box">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <i class="bi bi-cloud-arrow-down text-primary fs-1"></i>
                    <div class="text-start">
                        <h2 class="fw-extrabold mb-0 fs-1">120,000+</h2>
                        <p class="text-muted mb-0 fw-medium">Pobranych opracowań</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEKCJA FUNKCJI (FEATURES) -->
<section class="py-5 bg-body-tertiary">
    <div class="container py-5">
        <div class="text-center mb-5 pb-3">
            <h2 class="fw-extrabold display-5 mb-3">Dlaczego nasza platforma?</h2>
            <p class="text-muted fs-5 max-w-2xl mx-auto">Zaprojektowana z myślą o prostocie, efektywności i wzajemnej współpracy.</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Cecha 1: Szybkie udostępnianie -->
            <div class="col-lg-4 col-md-6 d-flex">
                <div class="card premium-card p-4 flex-grow-1">
                    <div class="card-body p-0 d-flex flex-column">
                        <div class="icon-box">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">Szybkie udostępnianie</h3>
                        <p class="text-muted mb-0 leading-relaxed">
                            Dodawaj własne notatki w kilka sekund. Przeciągnij i upuść plik, wybierz tagi oraz kategorię przedmiotu i błyskawicznie podziel się wiedzą ze swoją grupą lub całą społecznością.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Cecha 2: Inteligentne wyszukiwanie -->
            <div class="col-lg-4 col-md-6 d-flex">
                <div class="card premium-card p-4 flex-grow-1">
                    <div class="card-body p-0 d-flex flex-column">
                        <div class="icon-box">
                            <i class="bi bi-search-heart-fill"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">Inteligentne filtry</h3>
                        <p class="text-muted mb-0 leading-relaxed">
                            Znajdź dokładnie to, czego szukasz. Nasz system wyszukiwania i filtrowania pozwala na precyzyjne odnalezienie materiałów według przedmiotu, uczelni, wydziału, tagów, a nawet oceny użytkowników.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Cecha 3: Bezpieczeństwo i pewność -->
            <div class="col-lg-4 col-md-6 d-flex">
                <div class="card premium-card p-4 flex-grow-1">
                    <div class="card-body p-0 d-flex flex-column">
                        <div class="icon-box">
                            <i class="bi bi-shield-check-fill"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">Bezpieczeństwo i weryfikacja</h3>
                        <p class="text-muted mb-0 leading-relaxed">
                            Dbamy o jakość i bezpieczeństwo. Każdy przesłany plik przechodzi szybką automatyczną weryfikację bezpieczeństwa, a społeczność dba o poprawność merytoryczną za pomocą systemu ocen i komentarzy.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEKCJA: JAK TO DZIAŁA -->
<section class="py-5" style="background: var(--bs-body-bg);">
    <div class="container py-5">
        <div class="text-center mb-5 pb-3">
            <h2 class="fw-extrabold display-5 mb-3">Jak to działa?</h2>
            <p class="text-muted fs-5">Zacznij naukę lub dzielenie się wiedzą w 3 prostych krokach</p>
        </div>

        <div class="row g-4 position-relative">
            <!-- Krok 1 -->
            <div class="col-lg-4 text-center step-item position-relative">
                <div class="step-badge">1</div>
                <div class="step-connector"></div>
                <h4 class="fw-bold mb-3">Zarejestruj się</h4>
                <p class="text-muted px-md-4">
                    Stwórz darmowe konto w kilka sekund. Wypełnij prosty formularz i dołącz do naszej społeczności.
                </p>
            </div>
            
            <!-- Krok 2 -->
            <div class="col-lg-4 text-center step-item position-relative">
                <div class="step-badge">2</div>
                <div class="step-connector"></div>
                <h4 class="fw-bold mb-3">Wyszukaj lub dodaj</h4>
                <p class="text-muted px-md-4">
                    Przeglądaj tysiące gotowych materiałów do nauki lub udostępnij swoje własne, uporządkowane notatki.
                </p>
            </div>
            
            <!-- Krok 3 -->
            <div class="col-lg-4 text-center step-item position-relative">
                <div class="step-badge">3</div>
                <h4 class="fw-bold mb-3">Ucz się efektywniej</h4>
                <p class="text-muted px-md-4">
                    Pobieraj materiały, wymieniaj się opiniami w komentarzach i czerp satysfakcję z lepszych wyników w nauce!
                </p>
            </div>
        </div>
    </div>
</section>

<!-- SEKCJA OPINII (TESTIMONIALS) -->
<section class="py-5 bg-body-tertiary">
    <div class="container py-5">
        <div class="text-center mb-5 pb-3">
            <h2 class="fw-extrabold display-5 mb-3">Co mówią nasi użytkownicy?</h2>
            <p class="text-muted fs-5">Poznaj opinie studentów, którzy korzystają z Noted każdego dnia.</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <div class="col-lg-5">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-quote text-primary fs-1 me-3"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">Anna Kowalska</h5>
                            <small class="text-muted">Studentka Informatyki • AGH</small>
                        </div>
                    </div>
                    <p class="text-muted mb-0 italic">
                        "Dzięki Noted sesja zimowa przestała być koszmarem! Odszukałam świetnie opracowane wykłady z Analizy Matematycznej, które wyjaśniły mi trudne pojęcia lepiej niż podręczniki. Gorąco polecam wszystkim!"
                    </p>
                </div>
            </div>
            
            <div class="col-lg-5">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-quote text-primary fs-1 me-3"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">Mateusz Nowak</h5>
                            <small class="text-muted">Student Medycyny • UJ</small>
                        </div>
                    </div>
                    <p class="text-muted mb-0 italic">
                        "Dzielenie się notatkami na naszej grupie rokowej było zawsze chaotyczne. Odkąd korzystamy z tej platformy, wszystkie schematy i anatomia są w jednym, uporządkowanym miejscu. To niesamowity oszczędzacz czasu!"
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- OSTATNIA SEKCJA CTA -->
<section class="py-5 text-white text-center position-relative overflow-hidden" 
         style="background: linear-gradient(135deg, rgba(var(--bs-primary-rgb), 0.95) 0%, rgba(30, 41, 59, 0.95) 100%);">
    <div class="container py-5 position-relative" style="z-index: 2;">
        <h2 class="display-4 fw-extrabold mb-4">Gotowy na wejście do świata wiedzy?</h2>
        <p class="lead fs-4 mb-5 text-white-60 max-w-xl mx-auto">Zarejestruj się już teraz i zyskaj natychmiastowy dostęp do tysięcy notatek z całej Polski.</p>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 rounded-3 fw-bold text-primary shadow-sm border-2">
            <i class="bi bi-mortarboard-fill me-2"></i> Rozpocznij za darmo
        </a>
    </div>
</section>
@endsection
