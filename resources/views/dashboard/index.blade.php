@extends('layouts.dashboard')

@section('dashboard-content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-3xl font-bold text-white mb-1">Dashboard</h2>
        <p class="text-slate-400">Podsumowanie Twojej aktywności podróżniczej</p>
    </div>
    <div class="hidden sm:flex space-x-3">
        <a href="{{ route('trips') }}" class="glass px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/5 transition-colors text-white border border-slate-700">
            <i class="fa-solid fa-plane mr-2 text-primary"></i> Twoje wycieczki
        </a>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="glass rounded-2xl p-6 border border-slate-700/50 hover:border-primary/50 transition-colors">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-slate-400 font-medium">Zarezerwowane Wycieczki</h3>
            <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center">
                <i class="fa-solid fa-suitcase text-primary"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-white">12</div>
        <div class="mt-2 text-sm text-emerald-400 flex items-center">
            <i class="fa-solid fa-arrow-trend-up mr-1"></i> +2 w tym miesiącu
        </div>
    </div>
    
    <div class="glass rounded-2xl p-6 border border-slate-700/50 hover:border-secondary/50 transition-colors">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-slate-400 font-medium">Odwiedzone Kraje</h3>
            <div class="w-10 h-10 rounded-full bg-secondary/20 flex items-center justify-center">
                <i class="fa-solid fa-earth-europe text-secondary"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-white">8</div>
        <div class="mt-2 text-sm text-slate-400">Na 3 kontynentach</div>
    </div>

    <div class="glass rounded-2xl p-6 border border-slate-700/50 hover:border-emerald-500/50 transition-colors">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-slate-400 font-medium">Status Konta</h3>
            <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center">
                <i class="fa-solid fa-shield-check text-emerald-500"></i>
            </div>
        </div>
        <div class="text-xl font-bold text-white">Aktywne</div>
        <div class="mt-2 text-sm text-slate-400">Użytkownik standardowy</div>
    </div>
</div>

<!-- Quick Actions & Info -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="glass rounded-2xl p-6 border border-slate-700/50">
        <h3 class="text-xl font-bold text-white mb-4">Ostatnia Aktywność</h3>
        <div class="space-y-4">
            <div class="flex items-center p-3 rounded-xl bg-slate-800/50">
                <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center mr-4">
                    <i class="fa-solid fa-location-dot text-blue-400"></i>
                </div>
                <div>
                    <p class="text-white font-medium">Rejestracja konta</p>
                    <p class="text-xs text-slate-400">Dzisiaj</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="glass rounded-2xl p-6 border border-slate-700/50 bg-gradient-to-br from-slate-900/80 to-primary/10">
        <h3 class="text-xl font-bold text-white mb-2">Zaplanuj nową wycieczkę!</h3>
        <p class="text-slate-300 mb-6 text-sm">Odkrywaj świat, przeglądaj tysiące ofert i zbieraj wspomnienia.</p>
        <a href="{{ route('trips') }}" class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-primary to-secondary hover:from-blue-600 hover:to-purple-600 text-white rounded-xl font-medium transition-all duration-300 hover:scale-105">
            Przeglądaj Oferty <i class="fa-solid fa-arrow-right ml-2"></i>
        </a>
    </div>
</div>
@endsection
