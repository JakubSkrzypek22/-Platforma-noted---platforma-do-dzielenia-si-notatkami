@extends('layouts.dashboard')

@section('dashboard-content')
<style>
    .profile-card {
        border: 1px solid var(--color-border);
        border-radius: 16px;
        background-color: var(--color-card-bg);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .profile-card:hover { transform: translateY(-4px); border-color: var(--color-primary); box-shadow: 0 12px 20px -8px rgba(0,0,0,0.1); }
    .hero-banner { background: linear-gradient(135deg, var(--color-primary) 0%, #818cf8 100%); color: #fff; }
    .stat-tab { transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1); }
    .stat-tab.is-active { border-color: var(--color-primary); background: var(--color-primary); color: #fff; box-shadow: 0 10px 18px -8px var(--color-primary); }
    .stat-tab.is-active .opacity-70 { opacity: 0.9; }
</style>

@if (session('success'))
    <div class="bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-900/50 text-emerald-700 dark:text-emerald-400 p-4 rounded-xl text-sm mb-6">
        <i class="bi bi-check-circle-fill mr-2"></i>{{ session('success') }}
    </div>
@endif

<!-- Nagłówek profilu -->
<div class="profile-card hero-banner p-6 sm:p-8 mb-8 shadow-lg">
    <div class="flex flex-col sm:flex-row sm:items-center gap-5">
        <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($user->name) }}" alt="" class="w-20 h-20 rounded-full border-4 border-white/30 bg-white/10">
        <div class="flex-grow">
            <h1 class="text-2xl font-extrabold flex items-center gap-2 flex-wrap">
                {{ $user->name }}
                @if ($user->isVip())
                    <span class="inline-flex items-center gap-1 bg-amber-400 text-amber-950 text-xs font-black uppercase tracking-wider px-2.5 py-1 rounded-full shadow">
                        <i class="bi bi-crown-fill"></i> VIP
                    </span>
                @endif
            </h1>
            <p class="text-white/70 text-sm">{{ $user->email }}</p>
            <div class="flex items-center gap-2 mt-2 text-sm">
                <i class="bi bi-star-fill text-amber-300"></i>
                <span class="font-bold">{{ $stats['rating'] ?? 'Brak ocen' }}</span>
                @if ($stats['rating'])<span class="text-white/60">jako sprzedawca</span>@endif
            </div>
            @if (! $user->isVip())
                <a href="{{ route('vip.index') }}" class="inline-flex items-center gap-1.5 mt-3 bg-white/15 hover:bg-white/25 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-colors">
                    <i class="bi bi-crown-fill text-amber-300"></i> Zdobądź status VIP
                </a>
            @endif
        </div>
        <a href="{{ route('notes.create') }}" class="bg-white text-primary font-bold px-5 py-2.5 rounded-xl text-sm flex items-center gap-2 shadow-md self-start hover:bg-slate-100 transition-all">
            <i class="bi bi-plus-circle-fill"></i> Wystaw notatkę
        </a>
    </div>
</div>

<!-- Statystyki = zakładki (kliknij kafelek, aby przełączyć widok) -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8 text-center" id="profileTabs">
    <button type="button" onclick="showTab('mynotes')" data-tab="mynotes" class="stat-tab profile-card p-4 text-left cursor-pointer">
        <span class="text-xs uppercase font-bold tracking-wider opacity-70"><i class="bi bi-journal-text mr-1"></i> Moje notatki</span>
        <h4 class="text-2xl font-extrabold mt-1">{{ $stats['notes'] }}</h4>
    </button>
    <button type="button" onclick="showTab('purchased')" data-tab="purchased" class="stat-tab profile-card p-4 text-left cursor-pointer">
        <span class="text-xs uppercase font-bold tracking-wider opacity-70"><i class="bi bi-bag-check mr-1"></i> Zakupione</span>
        <h4 class="text-2xl font-extrabold mt-1">{{ $stats['purchased'] }}</h4>
    </button>
    <button type="button" onclick="showTab('favorites')" data-tab="favorites" class="stat-tab profile-card p-4 text-left cursor-pointer">
        <span class="text-xs uppercase font-bold tracking-wider opacity-70"><i class="bi bi-heart mr-1"></i> Ulubione</span>
        <h4 class="text-2xl font-extrabold mt-1" id="statFav">{{ $stats['favorites'] }}</h4>
    </button>
    <div class="profile-card p-4">
        <span class="text-slate-400 text-xs uppercase font-bold tracking-wider"><i class="bi bi-cash-coin mr-1"></i> Zarobki</span>
        <h4 class="text-2xl font-extrabold mt-1 text-emerald-500">{{ number_format($stats['earnings'], 2, ',', ' ') }} zł</h4>
    </div>
    <div class="profile-card p-4">
        <span class="text-slate-400 text-xs uppercase font-bold tracking-wider"><i class="bi bi-wallet2 mr-1"></i> Wydatki</span>
        <h4 class="text-2xl font-extrabold mt-1 text-rose-500">{{ number_format($stats['spent'], 2, ',', ' ') }} zł</h4>
    </div>
</div>

<!-- TAB: MOJE NOTATKI -->
<div class="tab-pane block" id="pane-mynotes">
    @if ($myNotes->isEmpty())
        @include('dashboard.partials.empty', ['icon' => 'bi-journal-plus', 'title' => 'Nie masz jeszcze notatek', 'text' => 'Wystaw swoją pierwszą notatkę i zacznij zarabiać na wiedzy.'])
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($myNotes as $note)
                @php $main = $note->mainFile(); @endphp
                <div class="profile-card flex flex-col">
                    @include('dashboard.partials.cover', ['note' => $note, 'main' => $main])
                    <div class="p-5 flex flex-col flex-grow">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary self-start mb-2">{{ $note->category }}</span>
                        <h3 class="font-bold text-text-body mb-1 leading-snug">{{ $note->title }}</h3>
                        <div class="text-sm text-slate-400 mb-3">
                            {{ $note->isFree() ? 'Za darmo' : number_format($note->price, 2, ',', ' ') . ' zł' }}
                            · <i class="bi bi-eye"></i> {{ $note->views }}
                            · <i class="bi bi-download"></i> {{ $note->downloads }}
                        </div>
                        <div class="grid grid-cols-3 gap-2 mt-auto">
                            <a href="{{ route('notes.show', $note) }}" class="py-2 border border-border hover:border-primary hover:text-primary rounded-lg text-xs font-semibold text-center transition-all"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('notes.edit', $note) }}" class="py-2 border border-border hover:border-primary hover:text-primary rounded-lg text-xs font-semibold text-center transition-all"><i class="bi bi-pencil"></i> Edytuj</a>
                            <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Na pewno usunąć tę notatkę?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full py-2 border border-red-200 dark:border-red-900/40 text-red-500 hover:bg-red-500/10 rounded-lg text-xs font-semibold transition-all"><i class="bi bi-trash3"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- TAB: ZAKUPIONE -->
<div class="tab-pane hidden" id="pane-purchased">
    @if ($purchasedNotes->isEmpty())
        @include('dashboard.partials.empty', ['icon' => 'bi-bag', 'title' => 'Brak zakupionych notatek', 'text' => 'Przeglądaj katalog i odblokuj materiały, których potrzebujesz.'])
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($purchasedNotes as $note)
                @php $main = $note->mainFile(); @endphp
                <div class="profile-card flex flex-col">
                    @include('dashboard.partials.cover', ['note' => $note, 'main' => $main])
                    <div class="p-5 flex flex-col flex-grow">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary self-start mb-2">{{ $note->category }}</span>
                        <h3 class="font-bold text-text-body mb-1 leading-snug">{{ $note->title }}</h3>
                        <p class="text-xs text-slate-400 mb-3"><i class="bi bi-person"></i> {{ $note->author->name ?? 'Nieznany' }}</p>
                        <div class="grid grid-cols-2 gap-2 mt-auto">
                            <a href="{{ route('notes.show', $note) }}" class="py-2 border border-border hover:border-primary hover:text-primary rounded-lg text-xs font-semibold text-center transition-all"><i class="bi bi-eye"></i> Otwórz</a>
                            <a href="{{ route('notes.download', $note) }}" class="py-2 bg-primary hover:bg-primary-hover text-white rounded-lg text-xs font-semibold text-center transition-all"><i class="bi bi-download"></i> Pobierz</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- TAB: ULUBIONE -->
<div class="tab-pane hidden" id="pane-favorites">
    @include('dashboard.partials.empty', ['icon' => 'bi-heart', 'title' => 'Brak ulubionych', 'text' => 'Klikaj serduszko przy notatkach, aby zapisać je tutaj.', 'extraClass' => $favoriteNotes->isEmpty() ? '' : 'hidden', 'id' => 'favEmpty'])
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 {{ $favoriteNotes->isEmpty() ? 'hidden' : '' }}" id="favGrid">
        @foreach ($favoriteNotes as $note)
            @php $main = $note->mainFile(); @endphp
            <div class="profile-card flex flex-col" data-fav-card>
                @include('dashboard.partials.cover', ['note' => $note, 'main' => $main])
                <div class="p-5 flex flex-col flex-grow">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary self-start mb-2">{{ $note->category }}</span>
                    <h3 class="font-bold text-text-body mb-1 leading-snug">{{ $note->title }}</h3>
                    <div class="text-sm text-slate-400 mb-3">{{ $note->isFree() ? 'Za darmo' : number_format($note->price, 2, ',', ' ') . ' zł' }}</div>
                    <div class="grid grid-cols-2 gap-2 mt-auto">
                        <a href="{{ route('notes.show', $note) }}" class="py-2 border border-border hover:border-primary hover:text-primary rounded-lg text-xs font-semibold text-center transition-all"><i class="bi bi-eye"></i> Zobacz</a>
                        <form action="{{ route('notes.favorite', $note) }}" method="POST" class="js-fav-remove">
                            @csrf
                            <button type="submit" class="w-full py-2 border border-red-200 dark:border-red-900/40 text-red-500 hover:bg-red-500/10 rounded-lg text-xs font-semibold transition-all"><i class="bi bi-heart-fill"></i> Usuń</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function showTab(tab) {
        document.querySelectorAll('.tab-pane').forEach(p => { p.classList.add('hidden'); p.classList.remove('block'); });
        const pane = document.getElementById('pane-' + tab);
        if (pane) { pane.classList.remove('hidden'); pane.classList.add('block'); }
        document.querySelectorAll('#profileTabs .stat-tab').forEach(b => b.classList.remove('is-active'));
        const active = document.querySelector('#profileTabs .stat-tab[data-tab="' + tab + '"]');
        if (active) active.classList.add('is-active');
    }
    showTab('mynotes');

    // Usuwanie z ulubionych bez przeładowania strony
    document.querySelectorAll('form.js-fav-remove').forEach(function (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            const card = form.closest('[data-fav-card]');
            const btn  = form.querySelector('button');
            btn.disabled = true;
            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                    body: new FormData(form),
                });
                if (!res.ok) throw new Error('fail');
                await res.json();

                if (card) card.remove();

                // Aktualizacja licznika w kafelku "Ulubione"
                const counter = document.getElementById('statFav');
                if (counter) {
                    const left = Math.max(0, (parseInt(counter.textContent, 10) || 1) - 1);
                    counter.textContent = left;
                    if (left === 0) {
                        const grid  = document.getElementById('favGrid');
                        const empty = document.getElementById('favEmpty');
                        if (grid)  grid.classList.add('hidden');
                        if (empty) empty.classList.remove('hidden');
                    }
                }
            } catch (err) {
                form.submit();
            } finally {
                btn.disabled = false;
            }
        });
    });
</script>
@endsection
