@extends('layouts.dashboard')

@section('dashboard-content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-3xl font-bold text-white mb-1">Pulpit</h2>
        <p class="text-slate-400">Podsumowanie Twojej aktywności w serwisie</p>
    </div>
    <div class="hidden sm:flex space-x-3">
        <a href="{{ route('trips') }}" class="glass px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/5 transition-colors text-white border border-slate-700">
            <i class="fa-solid fa-book-open mr-2 text-primary"></i> Moje Notatki
        </a>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="glass rounded-2xl p-6 border border-slate-700/50 hover:border-primary/50 transition-colors">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-slate-400 font-medium">Aktywne oferty</h3>
            <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center">
                <i class="fa-solid fa-copy text-primary"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-white">12</div>
        <div class="mt-2 text-sm text-slate-400 flex items-center">
            2 sprzedane, 1 oczekująca na ocenę
        </div>
    </div>
    
    <div class="glass rounded-2xl p-6 border border-slate-700/50 hover:border-secondary/50 transition-colors">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-slate-400 font-medium">Przeglądane przedmioty</h3>
            <div class="w-10 h-10 rounded-full bg-secondary/20 flex items-center justify-center">
                <i class="fa-solid fa-book-open text-secondary"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-white">8</div>
        <div class="mt-2 text-sm text-slate-400">z 3 różnych wydziałów</div>
    </div>

    <div class="glass rounded-2xl p-6 border border-slate-700/50 hover:border-emerald-500/50 transition-colors">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-slate-400 font-medium">Twój Ranking</h3>
            <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center">
                <i class="fa-solid fa-medal text-emerald-500"></i>
            </div>
        </div>
        <div class="text-xl font-bold text-white">Średnia ocena: 4.8</div>
        <div class="mt-2 text-sm text-emerald-400 flex items-center space-x-1">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-regular fa-star-half-stroke"></i>
            <span class="text-slate-400 ml-1">12 pozytywnych opinii</span>
        </div>
    </div>
</div>

<!-- Quick Actions & Info -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="glass rounded-2xl p-6 border border-slate-700/50">
        <h3 class="text-xl font-bold text-white mb-4">Ostatnia Aktywność</h3>
        <div class="space-y-4">
            <div class="flex items-center p-3 rounded-xl bg-slate-800/50">
                <div class="w-10 h-10 rounded-full bg-yellow-500/20 flex items-center justify-center mr-4">
                    <i class="fa-solid fa-star text-yellow-400"></i>
                </div>
                <div>
                    <p class="text-white font-medium">Otrzymano 5★ ocenę!</p>
                    <p class="text-xs text-slate-400">od Marta Z. za "Makroekonomia - Ćwiczenia"</p>
                </div>
            </div>
            
            <div class="flex items-center p-3 rounded-xl bg-slate-800/50">
                <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center mr-4">
                    <i class="fa-solid fa-money-bill text-emerald-400"></i>
                </div>
                <div>
                    <p class="text-white font-medium">Sprzedano materiał!</p>
                    <p class="text-xs text-slate-400">"Fizyka Kwantowa" kupiona przez Paweł P.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="glass rounded-2xl p-6 border border-slate-700/50 bg-gradient-to-br from-slate-900/80 to-primary/10">
        <h3 class="text-xl font-bold text-white mb-2">Wystaw nową notatkę!</h3>
        <p class="text-slate-300 mb-6 text-sm">Wgrywaj swoje notatki, pomóż innym i zarabiaj. Przeglądaj propozycje.</p>
        <a href="{{ route('trips') }}" class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-primary to-secondary hover:from-blue-600 hover:to-purple-600 text-white rounded-xl font-medium transition-all duration-300 hover:scale-105">
            Dodaj Materiał <i class="fa-solid fa-arrow-right ml-2"></i>
        </a>
    </div>
</div>
@endsection
