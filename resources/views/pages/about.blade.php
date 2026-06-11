@extends('layouts.app')

@section('content')
@include('shared.navbar')

<style>
    .editorial-wrapper { max-width: 860px; margin: 0 auto; }
    .editorial-quote {
        font-family: Georgia, serif;
        font-size: 1.3rem;
        font-style: italic;
        border-left: 4px solid var(--color-primary);
        padding-left: 20px;
        color: var(--color-primary);
    }
    .about-card {
        border: 1px solid var(--color-border);
        border-radius: 16px;
        background-color: var(--color-card-bg);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .about-card:hover {
        transform: translateY(-4px);
        border-color: var(--color-primary);
        box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.1);
    }
</style>

<main class="flex-grow py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="editorial-wrapper py-3">

            <!-- Nagłówek -->
            <div class="text-center mb-12">
                <span class="text-primary font-bold uppercase tracking-widest text-xs">Filozofia Projektu</span>
                <h1 class="text-3xl md:text-4xl font-extrabold mt-2 text-text-body">Ekosystem Cyfrowej Synergii Akademickiej</h1>
                <p class="text-base text-slate-500 dark:text-slate-400 mt-4 leading-relaxed max-w-2xl mx-auto">Jak unowocześniamy obieg wiedzy bez barier, kształtując zrównoważoną przestrzeń wymiany myśli w środowisku naukowym.</p>
            </div>

            <!-- Wprowadzenie -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center mb-10">
                <div class="md:col-span-7">
                    <h2 class="text-xl font-bold mb-3 text-text-body">Nowy Wymiar Dzielenia Się Wiedzą</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-4 text-justify">
                        Tradycyjne modele edukacyjne borykają się z ogromnym marnotrawstwem zasobów poznawczych. Prace pisane w pocie czoła, skrupulatnie prowadzone notatki z wykładów, szczegółowo rozpisane projekty semestralne lądują na dnie cyfrowych folderów po zdanym egzaminie. Jest to strata potencjału intelektualnego, który mógłby wielokrotnie służyć kolejnym rocznikom.
                    </p>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed text-justify">
                        Noted stawia czoła temu wyzwaniu. Przenosimy ideę gospodarki obiegu zamkniętego (<i>circular economy</i>) bezpośrednio na grunt akademicki. Dajemy drugie życie opracowaniom dydaktycznym, pozwalając autorom czerpać korzyści finansowe ze swojego trudu, a kupującym ułatwiając natychmiastowe dotarcie do syntetycznych i sprawdzonych źródeł wiedzy.
                    </p>
                </div>
                <div class="md:col-span-5">
                    <div class="p-6 rounded-2xl bg-primary/10 border border-primary/15">
                        <h3 class="font-bold mb-3 text-primary flex items-center"><i class="bi bi-lightbulb-fill mr-2"></i>Wizja Noted</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed text-justify">
                            Wierzymy w pełną demokratyzację dostępu do materiałów naukowych. Wiedza nie powinna być zamknięta w ciasnych kręgach. Poprzez dynamiczne, zintegrowane mechanizmy oceny to studenci sami kreują standardy jakości dydaktycznej, filtrując i nagradzając najbardziej wartościowe i precyzyjne materiały.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Cytat -->
            <div class="my-10 p-6 rounded-2xl bg-slate-100/50 dark:bg-slate-800/30">
                <div class="editorial-quote text-text-body text-base">
                    "Czas spędzony na samodzielnej selekcji chaotycznych informacji z sieci to najkosztowniejsza część procesu edukacji. Optymalizacja tej ścieżki za pomocą zweryfikowanych streszczeń to fundament nowoczesnej nauki."
                </div>
            </div>

            <!-- Trzy filary -->
            <h2 class="text-lg font-bold text-center mb-6 text-text-body">Trzy Filary Naszej Architektury Ideowej</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="about-card p-6">
                    <h5 class="font-bold text-primary mb-3 flex items-center"><i class="bi bi-check-circle-fill mr-2"></i>Mikroekonomia</h5>
                    <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed">Uczciwy system gratyfikacji finansowej dla autorów starannie sporządzonych materiałów. Praca intelektualna zyskuje realny ekwiwalent rynkowy.</p>
                </div>
                <div class="about-card p-6">
                    <h5 class="font-bold text-primary mb-3 flex items-center"><i class="bi bi-star-fill mr-2"></i>Kuratela Jakości</h5>
                    <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed">Rygorystyczne, społecznościowe mechanizmy recenzowania materiałów chronią przed błędnymi, niekompletnymi informacjami.</p>
                </div>
                <div class="about-card p-6">
                    <h5 class="font-bold text-primary mb-3 flex items-center"><i class="bi bi-sliders mr-2"></i>Zgodność z Intuicją</h5>
                    <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed">Zintegrowany interfejs, w którym interakcja i zakupy przebiegają bez barier. Maksymalne skupienie na samym procesie przyswajania wiedzy.</p>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center bg-primary/10 border border-primary/15 rounded-2xl p-8">
                <h3 class="text-xl font-extrabold text-text-body mb-2">Dołącz do społeczności Noted</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-5 max-w-lg mx-auto">Zacznij dzielić się wiedzą lub znajdź materiały, których potrzebujesz na egzamin.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-hover text-white font-bold px-6 py-3 rounded-xl text-sm transition-colors">
                    <i class="bi bi-grid-fill"></i> Przeglądaj katalog notatek
                </a>
            </div>
        </div>
    </div>
</main>

@include('shared.footer')
@endsection
