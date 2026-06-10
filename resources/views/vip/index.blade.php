@extends('layouts.app')

@section('content')
@include('shared.navbar')

<main class="flex-grow py-12 theme-page flex items-center justify-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full text-4xl mb-6 shadow-lg"
             style="background-color: var(--color-vip); color: #ffffff;">
            <i class="bi bi-crown-fill"></i>
        </div>

        <h1 class="text-4xl font-black text-text-body tracking-tight mb-4">
            Zgarnij status <span style="color: var(--color-vip);">Noted VIP</span>
        </h1>
        <p class="text-muted-theme text-lg max-w-xl mx-auto mb-12">
            Dołącz do elitarnego grona studentów i zyskaj potężne przywileje do nauki oraz sprzedaży swoich materiałów.
        </p>

        <div class="vip-offer-card max-w-md mx-auto">
            <div class="absolute top-0 right-0 text-white text-[10px] font-black uppercase px-4 py-1 rounded-bl-xl tracking-wider"
                 style="background-color: var(--color-vip);">Premium</div>

            <h3 class="text-xl font-bold text-text-body mb-2">Konto VIP (30 dni)</h3>
            <div class="flex items-baseline justify-center gap-1 mb-6 border-b border-border pb-6">
                <span class="text-4xl font-black text-text-body">19,99 zł</span>
                <span class="text-subtle-theme text-sm">/ miesiąc</span>
            </div>

            <ul class="vip-feature-list space-y-4 mb-8">
                <li class="flex items-center gap-3">
                    <i class="bi bi-check-circle-fill text-lg" style="color: var(--color-vip);"></i>
                    <span><strong>0% prowizji</strong> — zatrzymujesz cały zysk ze sprzedaży</span>
                </li>
                <li class="flex items-center gap-3">
                    <i class="bi bi-check-circle-fill text-lg" style="color: var(--color-vip);"></i>
                    <span><strong>Pozycjonowanie Boost</strong> — Twoje notatki zawsze na samej górze</span>
                </li>
                <li class="flex items-center gap-3">
                    <i class="bi bi-check-circle-fill text-lg" style="color: var(--color-vip);"></i>
                    <span><strong>Złota odznaka korony</strong> — większe zaufanie i wyższa sprzedaż</span>
                </li>
            </ul>

            @if(auth()->user()->isVip())
                <button class="w-full py-3.5 rounded-xl font-bold cursor-not-allowed text-sm text-muted-theme"
                        style="background-color: var(--color-surface-muted);" disabled>
                    <i class="bi bi-check-circle-fill mr-1"></i> Status VIP jest już aktywny
                </button>
            @else
                <a href="{{ route('vip.checkout') }}" class="btn-vip-primary">
                    Aktywuj konto VIP
                </a>
            @endif
        </div>
    </div>
</main>

@include('shared.footer')
@endsection
