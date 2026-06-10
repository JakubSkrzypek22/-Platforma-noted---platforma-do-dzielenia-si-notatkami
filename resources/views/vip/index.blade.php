@extends('layouts.app')

@section('content')
@include('shared.navbar')

<div class="max-w-4xl mx-auto px-4 py-16 text-center">
    <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-amber-100 to-orange-100 text-amber-500 rounded-full mb-8 shadow-inner border border-amber-200">
        <i class="bi bi-crown-fill text-5xl"></i>
    </div>
    
    <h1 class="text-4xl md:text-5xl font-black mb-4 text-slate-900 dark:text-white tracking-tight">Zgarnij status Noted VIP</h1>
    <p class="text-lg text-slate-500 dark:text-slate-400 mb-12 max-w-2xl mx-auto">
        Dołącz do elitarnego grona studentów i zyskaj potężne przywileje do nauki oraz sprzedaży swoich materiałów.
    </p>

    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200 dark:border-slate-700 max-w-md mx-auto overflow-hidden transition-transform hover:scale-105 duration-300">
        <div class="p-8 border-b border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
            <h2 class="text-xl font-bold text-slate-500 dark:text-slate-400 mb-2">Konto VIP (30 dni)</h2>
            <div class="text-5xl font-black text-slate-900 dark:text-white">
                19,99 zł <span class="text-base font-medium text-slate-400">/ miesiąc</span>
            </div>
        </div>
        
        <div class="p-8 text-left space-y-6">
            <div class="flex items-start gap-4">
                <i class="bi bi-check-circle-fill text-emerald-500 text-xl mt-0.5"></i> 
                <p class="text-slate-700 dark:text-slate-300"><strong class="text-slate-900 dark:text-white">0% prowizji</strong> — zatrzymujesz cały zysk ze sprzedaży swoich notatek.</p>
            </div>
            <div class="flex items-start gap-4">
                <i class="bi bi-check-circle-fill text-emerald-500 text-xl mt-0.5"></i> 
                <p class="text-slate-700 dark:text-slate-300"><strong class="text-slate-900 dark:text-white">Pozycjonowanie Boost</strong> — Twoje notatki wyświetlają się zawsze na samej górze wyszukiwania.</p>
            </div>
            <div class="flex items-start gap-4">
                <i class="bi bi-check-circle-fill text-emerald-500 text-xl mt-0.5"></i> 
                <p class="text-slate-700 dark:text-slate-300"><strong class="text-slate-900 dark:text-white">Złota odznaka korony</strong> — budujesz większe zaufanie u kupujących i zwiększasz sprzedaż.</p>
            </div>
        </div>
        
        <div class="p-8 pt-0">
            <a href="{{ route('vip.checkout') }}" class="block w-full text-center bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-black py-4 rounded-xl transition-all shadow-md hover:shadow-lg uppercase tracking-wider text-sm">
                Aktywuj konto VIP
            </a>
        </div>
    </div>
</div>

@include('shared.footer')
@endsection