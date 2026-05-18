@extends('layouts.dashboard')

@section('dashboard-content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-3xl font-bold text-white mb-1">Przedmioty</h2>
        <p class="text-slate-400">Kategorie i przedmioty dostępne na platformie.</p>
    </div>
    
    <div class="relative max-w-xs w-full">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
        </div>
        <input type="text" placeholder="Szukaj przedmiotu..." class="w-full bg-slate-900/50 border border-slate-700 rounded-xl py-2 pl-10 pr-4 text-white focus:outline-none focus:ring-2 focus:ring-primary transition-all">
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse ($subjects as $subject)
    <div class="glass rounded-2xl p-5 border border-slate-700/50 hover:border-primary/50 hover:shadow-[0_0_20px_rgba(59,130,246,0.15)] transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-slate-700 to-slate-800 flex items-center justify-center text-xl shadow-inner border border-slate-600">
                <i class="fa-solid fa-graduation-cap text-slate-400 group-hover:text-primary transition-colors"></i>
            </div>
            <span class="px-3 py-1 text-xs font-medium bg-primary/20 text-primary rounded-full border border-primary/20">
                Przedmiot
            </span>
        </div>
        
        <h3 class="text-xl font-bold text-white mb-1 group-hover:text-primary transition-colors">{{ $subject->name }}</h3>
        
        <div class="pt-4 border-t border-slate-800 flex justify-between items-center text-sm mt-4">
            <span class="text-slate-400">Wydział:</span>
            <span class="text-white font-medium text-right">{{ $subject->department }}</span>
        </div>
    </div>
    @empty
    <div class="col-span-full flex flex-col items-center justify-center p-12 glass rounded-2xl border border-slate-700/50 border-dashed">
        <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center mb-4">
            <i class="fa-solid fa-folder-open text-2xl text-slate-500"></i>
        </div>
        <h3 class="text-lg font-medium text-white mb-1">Brak danych</h3>
        <p class="text-slate-400">Baza przedmiotów jest obecnie pusta.</p>
    </div>
    @endforelse
</div>
@endsection
