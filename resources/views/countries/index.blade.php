@extends('layouts.dashboard')

@section('dashboard-content')
    <!-- Custom styles for subjects page -->
    <style>
        .premium-card {
            border: 1px solid var(--color-border);
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            background-color: var(--color-card-bg);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -2px rgba(0, 0, 0, 0.03);
        }
        .premium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.1);
            border-color: var(--color-primary);
        }
        .icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: var(--color-border);
            color: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            transition: background-color 0.3s, color 0.3s;
            opacity: 0.85;
        }
        .premium-card:hover .icon-wrapper {
            background-color: var(--color-primary);
            color: white;
            opacity: 1;
        }
    </style>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-text-body mb-1">Przedmioty</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Wydziały i przedmioty dostępne na platformie Noted.</p>
        </div>

        <div class="w-full md:max-w-xs">
            <div class="flex rounded-xl shadow-sm border border-border bg-card-bg overflow-hidden focus-within:ring-2 focus-within:ring-primary/30 focus-within:border-primary transition-all">
                <span class="inline-flex items-center px-3 text-slate-400 bg-transparent border-r-0"><i class="bi bi-search"></i></span>
                <input type="text" id="subjectSearch" placeholder="Szukaj przedmiotu..." class="w-full px-3 py-2 bg-transparent text-text-body border-0 focus:ring-0 focus:outline-none placeholder-slate-400 text-sm" oninput="filterSubjects()">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6 mb-12" id="subjectsContainer">
        @forelse ($countries as $country)
        <div class="subject-card h-full" data-name="{{ strtolower($country->name) }}">
            <div class="premium-card p-6 h-full flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="icon-wrapper">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        <span class="bg-primary/10 text-primary border border-primary/10 rounded-full px-3 py-1 text-xs font-semibold">
                            Wydział
                        </span>
                    </div>

                    <h3 class="text-lg font-bold mb-1 text-text-body subject-title leading-snug">{{ $country->name }}</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-xs mb-4"><i class="bi bi-folder2-open mr-1.5 text-sm"></i> Materiały: {{ $country->area }}</p>
                </div>

                <div>
                    <div class="border-t border-border my-4"></div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-400">Język wykładowy:</span>
                        <span class="font-bold text-text-body">{{ $country->language }}</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <div class="bg-card-bg border-2 border-dashed border-border rounded-2xl p-12 max-w-md mx-auto">
                <i class="bi bi-mortarboard text-5xl text-slate-400 mb-3 block"></i>
                <h4 class="text-lg font-bold text-text-body mb-1">Brak danych</h4>
                <p class="text-slate-500 dark:text-slate-400 text-sm">
                    Baza przedmiotów jest obecnie pusta.
                </p>
            </div>
        </div>
        @endforelse
    </div>

    <script>
        function filterSubjects() {
            const query = document.getElementById('subjectSearch').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.subject-card');

            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                if (name.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
@endsection
