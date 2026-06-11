@extends('layouts.app')

@section('content')
@include('shared.navbar')

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
        background: linear-gradient(135deg, #ffffff 30%, var(--color-primary) 100%);
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
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.45);
        }
        50% {
            box-shadow: 0 0 25px 8px rgba(59, 130, 246, 0.25);
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
        background-color: var(--color-primary);
        color: #ffffff;
        animation: pulseGlow 3s infinite;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-pulse-primary:hover {
        background-color: var(--color-primary-hover);
        color: #ffffff;
        transform: translateY(-3px);
    }

    /* Premium responsive cards that adapt to the active theme */
    .premium-card {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border);
        border-radius: 1.5rem;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.08);
    }

    .premium-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15);
        border-color: var(--color-primary);
    }

    /* Styled icon wrappers with theme compatibility */
    .icon-box {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--color-primary) 0%, rgba(59, 130, 246, 0.7) 100%);
        color: #ffffff;
        border-radius: 1.15rem;
        font-size: 1.85rem;
        margin-bottom: 1.75rem;
        transition: all 0.3s ease;
    }

    .premium-card:hover .icon-box {
        transform: scale(1.1) rotate(6deg);
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
    }

    /* Unified style for statistics section */
    .stat-counter-box {
        border-right: 1px solid var(--color-border);
    }
    
    @media (max-width: 767.98px) {
        .stat-counter-box {
            border-right: none;
            border-bottom: 1px solid var(--color-border);
        }
    }

    /* "Jak to działa" Steps */
    .step-badge {
        width: 54px;
        height: 54px;
        background-color: rgba(59, 130, 246, 0.1);
        color: var(--color-primary);
        font-weight: 700;
        font-size: 1.35rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem auto;
        border: 2px solid rgba(59, 130, 246, 0.15);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .step-item:hover .step-badge {
        background-color: var(--color-primary);
        color: #ffffff;
        transform: scale(1.15);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.25);
    }

    .step-connector {
        position: absolute;
        top: 27px;
        right: -50%;
        width: 100%;
        height: 2px;
        background-color: var(--color-border);
        z-index: -1;
    }

    @media (max-width: 1023.98px) {
        .step-connector {
            display: none;
        }
    }

    /* Testimonial styling */
    .testimonial-card {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border);
        border-left: 5px solid var(--color-primary);
        border-radius: 0.75rem 1.5rem 1.5rem 0.75rem;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
        transition: transform 0.3s ease;
    }

    .testimonial-card:hover {
        transform: scale(1.02);
    }
</style>

<!-- SECJA HERO -->
<section class="hero-section text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Tekst i CTA -->
            <div class="lg:col-span-6 text-center lg:text-left animate-fade-in-up delay-1">
                <div class="inline-flex bg-white/10 text-white border border-white/20 px-3 py-1.5 rounded-full mb-6 text-sm">
                    <span class="text-warning mr-1.5">💡</span> Dziel się, pobieraj, rozwijaj!
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight">
                    Podziel Się Wiedzą, <br>
                    <span class="text-gradient font-black">Zainspiruj Innych</span>
                </h1>
                
                <p class="text-lg md:text-xl mb-10 text-white/80 font-light leading-relaxed">
                    Dołącz do ogólnokrajowej platformy dla studentów, uczniów i pasjonatów nauki. Przeglądaj wysokiej jakości notatki, udostępniaj własne opracowania i osiągaj lepsze wyniki w nauce razem z nami.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('register') }}" class="btn-pulse-primary px-6 py-4 rounded-xl font-bold flex items-center justify-center shadow-lg transition-all cursor-pointer">
                        <i class="bi bi-person-plus-fill mr-2 text-lg"></i> Załóż darmowe konto
                    </a>
                    <a href="{{ route('login') }}" class="border border-white/30 bg-white/5 hover:bg-white/15 text-white px-6 py-4 rounded-xl font-bold flex items-center justify-center transition-all cursor-pointer">
                        <i class="bi bi-box-arrow-in-right mr-2 text-lg"></i> Zaloguj się
                    </a>
                </div>
            </div>

            <!-- Interaktywny Mockup / Wizualizacja (Tylko desktop) -->
            <div class="lg:col-span-6 hidden lg:block animate-fade-in-up delay-2">
                <div class="floating-mockup mx-auto max-w-[480px]">
                    <div class="p-6 rounded-3xl border border-white/15 position-relative" 
                         style="background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(20px); box-shadow: 0 40px 80px rgba(0,0,0,0.5) !important;">
                        
                        <!-- Header notatki mockup -->
                        <div class="flex items-center mb-5">
                            <div class="bg-primary rounded-xl p-2.5 mr-4 flex items-center justify-center shadow-sm w-12 h-12">
                                <i class="bi bi-file-earmark-code text-white text-xl"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-white font-bold text-sm">Algorytmy_i_Zlozonosc.pdf</h6>
                                <small class="text-white/60 text-xs">Przed chwilą dodano • Informatyka</small>
                            </div>
                            <span class="badge bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 ml-auto px-2.5 py-1 text-xs font-semibold rounded-full">Zweryfikowane ✓</span>
                        </div>
                        
                        <!-- Treść mockup -->
                        <p class="text-white/60 text-sm mb-6 leading-relaxed">
                            Kompletne notatki z wykładów na temat struktur danych (drzewa AVL, grafy) oraz teorii złożoności obliczeniowej (problemy P vs NP). Opracowane przez studenta Politechniki.
                        </p>
                        
                        <!-- Tag mockup -->
                        <div class="flex gap-2 mb-6 flex-wrap">
                            <span class="bg-white/10 text-white border border-white/10 rounded-full px-3 py-1 text-xs">Politechnika</span>
                            <span class="bg-white/10 text-white border border-white/10 rounded-full px-3 py-1 text-xs">Algorytmy</span>
                            <span class="bg-white/10 text-white border border-white/10 rounded-full px-3 py-1 text-xs">Sesja_2026</span>
                        </div>
                        
                        <!-- Stopka mockup -->
                        <div class="flex items-center justify-between text-white/60 border-t border-white/10 pt-4 text-xs">
                            <span class="flex items-center"><i class="bi bi-eye-fill mr-1.5 text-sm"></i> 1,482 wyświetleń</span>
                            <span class="flex items-center"><i class="bi bi-cloud-arrow-down-fill mr-1.5 text-sm"></i> 584 pobrań</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEKCJA STATYSTYK -->
<section class="py-8 border-b border-t border-border bg-card-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid grid-cols-1 md:grid-cols-3 text-center gap-6">
            <div class="stat-counter-box py-4 md:py-0 flex items-center justify-center">
                <div class="flex items-center justify-center gap-4">
                    <i class="bi bi-file-earmark-text text-primary text-4xl"></i>
                    <div class="text-left">
                        <h2 class="font-extrabold text-3xl text-text-body">15,000+</h2>
                        <p class="text-slate-500 dark:text-slate-400 text-xs font-semibold tracking-wider text-uppercase">Dodanych notatek</p>
                    </div>
                </div>
            </div>
            <div class="stat-counter-box py-4 md:py-0 flex items-center justify-center">
                <div class="flex items-center justify-center gap-4">
                    <i class="bi bi-people text-primary text-4xl"></i>
                    <div class="text-left">
                        <h2 class="font-extrabold text-3xl text-text-body">4,800+</h2>
                        <p class="text-slate-500 dark:text-slate-400 text-xs font-semibold tracking-wider text-uppercase">Aktywnych studentów</p>
                    </div>
                </div>
            </div>
            <div class="py-4 md:py-0 flex items-center justify-center">
                <div class="flex items-center justify-center gap-4">
                    <i class="bi bi-cloud-arrow-down text-primary text-4xl"></i>
                    <div class="text-left">
                        <h2 class="font-extrabold text-3xl text-text-body">120,000+</h2>
                        <p class="text-slate-500 dark:text-slate-400 text-xs font-semibold tracking-wider text-uppercase">Pobranych opracowań</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEKCJA FUNKCJI (FEATURES) -->
<section class="py-16 bg-slate-50/50 dark:bg-slate-900/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center mb-12">
            <h2 class="font-extrabold text-3xl md:text-4xl text-text-body mb-3">Dlaczego nasza platforma?</h2>
            <p class="text-slate-500 dark:text-slate-400 text-base max-w-xl mx-auto">Zaprojektowana z myślą o prostocie, efektywności i wzajemnej współpracy.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-center">
            <!-- Cecha 1: Szybkie udostępnianie -->
            <div class="flex">
                <div class="premium-card p-6 flex-grow flex flex-col justify-between">
                    <div class="flex flex-col flex-grow">
                        <div class="icon-box">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <h3 class="text-lg font-bold text-text-body mb-3">Szybkie udostępnianie</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                            Dodawaj własne notatki w kilka sekund. Przeciągnij i upuść plik, wybierz tagi oraz kategorię przedmiotu i błyskawicznie podziel się wiedzą ze swoją grupą lub całą społecznością.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Cecha 2: Inteligentne wyszukiwanie -->
            <div class="flex">
                <div class="premium-card p-6 flex-grow flex flex-col justify-between">
                    <div class="flex flex-col flex-grow">
                        <div class="icon-box">
                            <i class="bi bi-search-heart-fill"></i>
                        </div>
                        <h3 class="text-lg font-bold text-text-body mb-3">Inteligentne filtry</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                            Znajdź dokładnie to, czego szukasz. Nasz system wyszukiwania i filtrowania pozwala na precyzyjne odnalezienie materiałów według przedmiotu, uczelni, wydziału, tagów, a nawet oceny użytkowników.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Cecha 3: Bezpieczeństwo i weryfikacja -->
            <div class="flex">
                <div class="premium-card p-6 flex-grow flex flex-col justify-between">
                    <div class="flex flex-col flex-grow">
                        <div class="icon-box">
                            <i class="bi bi-shield-check-fill"></i>
                        </div>
                        <h3 class="text-lg font-bold text-text-body mb-3">Bezpieczeństwo i weryfikacja</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                            Dbamy o jakość i bezpieczeństwo. Każdy przesłany plik przechodzi szybką automatyczną weryfikację bezpieczeństwa, a społeczność dba o poprawność merytoryczną za pomocą systemu ocen i komentarzy.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEKCJA: JAK TO DZIAŁA -->
<section class="py-16 bg-card-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center mb-12">
            <h2 class="font-extrabold text-3xl md:text-4xl text-text-body mb-3">Jak to działa?</h2>
            <p class="text-slate-500 dark:text-slate-400 text-base">Zacznij naukę lub dzielenie się wiedzą w 3 prostych krokach</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 relative z-10">
            <!-- Krok 1 -->
            <div class="text-center step-item relative">
                <div class="step-badge">1</div>
                <div class="step-connector"></div>
                <h4 class="text-lg font-bold text-text-body mb-3">Zarejestruj się</h4>
                <p class="text-slate-500 dark:text-slate-400 text-sm px-6">
                    Stwórz darmowe konto w kilka sekund. Wypełnij prosty formularz i dołącz do naszej społeczności.
                </p>
            </div>
            
            <!-- Krok 2 -->
            <div class="text-center step-item relative">
                <div class="step-badge">2</div>
                <div class="step-connector"></div>
                <h4 class="text-lg font-bold text-text-body mb-3">Wyszukaj lub dodaj</h4>
                <p class="text-slate-500 dark:text-slate-400 text-sm px-6">
                    Przeglądaj tysiące gotowych materiałów do nauki lub udostępnij swoje własne, uporządkowane notatki.
                </p>
            </div>
            
            <!-- Krok 3 -->
            <div class="text-center step-item relative">
                <div class="step-badge">3</div>
                <h4 class="text-lg font-bold text-text-body mb-3">Ucz się efektywniej</h4>
                <p class="text-slate-500 dark:text-slate-400 text-sm px-6">
                    Pobieraj materiały, wymieniaj się opiniami w komentarzach i czerp satysfakcję z lepszych wyników w nauce!
                </p>
            </div>
        </div>
    </div>
</section>

<!-- SEKCJA OPINII (TESTIMONIALS) -->
<section class="py-16 bg-slate-50/50 dark:bg-slate-900/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center mb-12">
            <h2 class="font-extrabold text-3xl md:text-4xl text-text-body mb-3">Co mówią nasi użytkownicy?</h2>
            <p class="text-slate-500 dark:text-slate-400 text-base">Poznaj opinie studentów, którzy korzystają z Noted każdego dnia.</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-4xl mx-auto justify-center">
            <div>
                <div class="testimonial-card">
                    <div class="flex items-center mb-4">
                        <i class="bi bi-quote text-primary text-4xl mr-3 opacity-30"></i>
                        <div>
                            <h5 class="font-bold text-text-body text-base">Anna Kowalska</h5>
                            <small class="text-slate-500 dark:text-slate-400 text-xs">Studentka Informatyki • AGH</small>
                        </div>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 text-sm italic leading-relaxed">
                        "Dzięki Noted sesja zimowa przestała być koszmarem! Odszukałam świetnie opracowane wykłady z Analizy Matematycznej, które wyjaśniły mi trudne pojęcia lepiej niż podręczniki. Gorąco polecam wszystkim!"
                    </p>
                </div>
            </div>
            
            <div>
                <div class="testimonial-card">
                    <div class="flex items-center mb-4">
                        <i class="bi bi-quote text-primary text-4xl mr-3 opacity-30"></i>
                        <div>
                            <h5 class="font-bold text-text-body text-base">Mateusz Nowak</h5>
                            <small class="text-slate-500 dark:text-slate-400 text-xs">Student Medycyny • UJ</small>
                        </div>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 text-sm italic leading-relaxed">
                        "Dzielenie się notatkami na naszej grupie rokowej było zawsze chaotyczne. Odkąd korzystamy z tej platformy, wszystkie schematy i anatomia są w jednym, uporządkowanym miejscu. To niesamowity oszczędzacz czasu!"
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- OSTATNIA SEKCJA CTA -->
<section class="py-16 text-white text-center relative overflow-hidden" 
         style="background: linear-gradient(135deg, var(--color-primary) 0%, #1e293b 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10 relative">
        <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Gotowy na wejście do świata wiedzy?</h2>
        <p class="text-base md:text-lg mb-8 text-white/70 max-w-xl mx-auto">Zarejestruj się już teraz i zyskaj natychmiastowy dostęp do tysięcy notatek z całej Polski.</p>
        <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-8 py-3 bg-white text-slate-900 hover:bg-slate-100 rounded-xl font-bold shadow-md hover:shadow-lg transition-all cursor-pointer">
            <i class="bi bi-mortarboard-fill mr-2"></i> Rozpocznij za darmo
        </a>
    </div>
</section>

@include('shared.footer')
@endsection
