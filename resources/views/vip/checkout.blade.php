@extends('layouts.app')

@section('content')
@include('shared.navbar')

<div class="max-w-3xl mx-auto px-4 py-12">
    <a href="{{ route('vip.index') }}" class="inline-flex items-center text-slate-500 hover:text-amber-600 font-bold mb-8 transition-colors">
        <i class="bi bi-arrow-left mr-2"></i> Wróć do oferty VIP
    </a>
    
    <h1 class="text-3xl font-black mb-2 text-slate-900 dark:text-white">Aktywacja pakietu VIP</h1>
    <p class="text-slate-500 dark:text-slate-400 mb-8">Bezpieczna płatność online obsługiwana przez platformę Stripe.</p>

    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-lg border border-slate-200 dark:border-slate-700 p-6 md:p-10 mb-8">
        
        <div class="flex items-start gap-4 p-5 bg-indigo-50 dark:bg-indigo-900/30 rounded-2xl border border-indigo-100 dark:border-indigo-800/50 mb-8">
            <div class="bg-indigo-500 text-white rounded-xl p-2.5 shadow-sm">
                <i class="bi bi-stripe text-2xl leading-none"></i>
            </div>
            <p class="text-sm text-indigo-900 dark:text-indigo-200 font-medium leading-relaxed">
                Po kliknięciu przycisku zostaniesz przekierowany na w pełni zabezpieczoną stronę operatora Stripe. Twój status VIP zostanie aktywowany natychmiast po udanej transakcji.
            </p>
        </div>

        <div class="flex justify-between py-5 border-b border-slate-100 dark:border-slate-700">
            <span class="text-slate-600 dark:text-slate-400 font-medium">Konto Noted VIP (30 dni)</span>
            <span class="font-bold text-slate-900 dark:text-white">19,99 zł</span>
        </div>
        
        <div class="flex justify-between py-6 text-xl md:text-2xl mb-4">
            <span class="font-black text-slate-900 dark:text-white">Do zapłaty</span>
            <span class="font-black text-amber-600">19,99 zł</span>
        </div>

        <form action="{{ route('vip.payment') }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-slate-900 dark:bg-white hover:bg-slate-800 dark:hover:bg-slate-100 text-white dark:text-slate-900 font-black py-4 md:py-5 rounded-2xl flex items-center justify-center gap-2 transition-all shadow-md hover:shadow-lg text-lg">
                <i class="bi bi-lock-fill"></i> Zapłać 19,99 zł i aktywuj VIP
            </button>
        </form>
        
        <div class="text-center mt-6 text-xs text-slate-400 font-medium flex items-center justify-center gap-1.5">
            <i class="bi bi-shield-check text-emerald-500 text-base"></i> 
            Płatność szyfrowana end-to-end. Dane Twojej karty nie trafiają na nasz serwer.
        </div>
    </div>
</div>

@include('shared.footer')
@endsection