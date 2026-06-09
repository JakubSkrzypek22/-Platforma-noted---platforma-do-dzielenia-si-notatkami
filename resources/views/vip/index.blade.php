@extends('layouts.app')

@section('content')
@include('shared.navbar')

<main class="flex-grow py-12 bg-slate-50 dark:bg-slate-900 flex items-center justify-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-amber-500 text-white text-4xl mb-6 shadow-lg shadow-amber-500/20">
            <i class="bi bi-crown-fill"></i>
        </div>
        
        <h1 class="text-4xl font-black text-text-body tracking-tight mb-4">Zgarnij status <span class="text-amber-500">Noted VIP</span></h1>
        <p class="text-slate-500 dark:text-slate-400 text-lg max-w-xl mx-auto mb-12">Dołącz do elitarnego grona studentów i zyskaj potężne przywileje do nauki oraz sprzedaży swoich materiałów.</p>

        <div class="bg-card-bg border-2 border-amber-500 rounded-3xl p-8 max-w-md mx-auto shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 bg-amber-500 text-white text-[10px] font-black uppercase px-4 py-1 rounded-bl-xl tracking-wider">Premium</div>
            
            <h3 class="text-xl font-bold text-text-body mb-2">Konto VIP (30 dni)</h3>
            <div class="flex items-baseline justify-center gap-1 mb-6 border-b border-border pb-6">
                <span class="text-4xl font-black text-text-body">19,99 zł</span>
                <span class="text-slate-400 text-sm">/ miesiąc</span>
            </div>

            <ul class="text-left space-y-4 mb-8 text-sm text-slate-600 dark:text-slate-300">
                <li class="flex items-center gap-3"><i class="bi bi-check-circle-fill text-amber-500 text-lg"></i> <span><strong>0% prowizji</strong> — zatrzymujesz cały zysk ze sprzedaży</span></li>
                <li class="flex items-center gap-3"><i class="bi bi-check-circle-fill text-amber-500 text-lg"></i> <span><strong>Pozycjonowanie Boost</strong> — Twoje notatki zawsze na samej górze</span></li>
                <li class="flex items-center gap-3"><i class="bi bi-check-circle-fill text-amber-500 text-lg"></i> <span><strong>Złota odznaka korony</strong> — większe zaufanie i wyższa sprzedaż</span></li>
            </ul>

            @if(auth()->user()->isVip())
                <button class="w-full py-3.5 bg-slate-200 text-slate-500 rounded-xl font-bold cursor-not-allowed text-sm" disabled>Status VIP jest już aktywny</button>
            @else
                <a href="{{ route('vip.checkout') }}" class="w-full block py-3.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-bold shadow-md hover:shadow-lg transition-all text-sm">Aktywuj konto VIP</a>
            @endif
        </div>
    </div>
</main>

@include('shared.footer')
@endsection