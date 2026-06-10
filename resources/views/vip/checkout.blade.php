@extends('layouts.app')

@section('content')
@include('shared.navbar')

<main class="flex-grow py-12 theme-page">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">

        <a href="{{ route('vip.index') }}" class="inline-flex items-center gap-1.5 text-sm text-muted-theme hover:opacity-80 mb-6 transition-opacity">
            <i class="bi bi-arrow-left"></i> Wróć do oferty VIP
        </a>

        @if (session('error'))
            <div class="mb-6 p-4 rounded-xl text-sm font-bold alert-error">
                <i class="bi bi-exclamation-triangle-fill mr-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="admin-card p-6 sm:p-8">
            <h2 class="text-xl font-black text-text-body mb-1 flex items-center gap-2">
                <i class="bi bi-crown-fill" style="color: var(--color-vip);"></i> Aktywacja pakietu VIP
            </h2>
            <p class="text-sm text-muted-theme mb-6">Bezpieczna płatność online obsługiwana przez Stripe.</p>

            <div class="flex items-start gap-4 p-4 rounded-xl border border-border mb-6"
                 style="background-color: var(--color-surface-muted);">
                <div class="w-11 h-11 rounded-full flex items-center justify-center flex-shrink-0"
                     style="background-color: rgba(99, 91, 255, 0.15); color: #635bff;">
                    <i class="bi bi-stripe text-2xl"></i>
                </div>
                <p class="text-sm text-muted-theme leading-relaxed">
                    Po kliknięciu przycisku zostaniesz przekierowany na zabezpieczoną stronę Stripe.
                    Status VIP zostanie aktywowany natychmiast po opłaceniu.
                </p>
            </div>

            <div class="border-t border-border pt-4 space-y-2 text-sm mb-6">
                <div class="flex justify-between text-muted-theme">
                    <span>Konto VIP (30 dni)</span>
                    <span>{{ number_format($price, 2, ',', ' ') }} zł</span>
                </div>
                <div class="flex justify-between font-extrabold text-text-body text-base border-t border-border pt-3 mt-2">
                    <span>Do zapłaty</span>
                    <span>{{ number_format($price, 2, ',', ' ') }} zł</span>
                </div>
            </div>

            <form action="{{ route('vip.payment') }}" method="POST" id="vipPayForm">
                @csrf
                <button type="submit" id="vipPayBtn" class="btn-vip-primary flex items-center justify-center gap-2">
                    <i class="bi bi-lock-fill"></i>
                    <span id="vipPayBtnText">Zapłać {{ number_format($price, 2, ',', ' ') }} zł i aktywuj VIP</span>
                </button>
            </form>

            <p class="text-center text-[11px] text-subtle-theme mt-3">
                <i class="bi bi-shield-check"></i> Płatność obsługuje Stripe. Dane Twojej karty nie trafiają na nasz serwer.
            </p>
        </div>
    </div>
</main>

<script>
    (function () {
        const form = document.getElementById('vipPayForm');
        const btn  = document.getElementById('vipPayBtn');
        const txt  = document.getElementById('vipPayBtnText');
        form.addEventListener('submit', function () {
            btn.disabled = true;
            btn.style.opacity = '0.7';
            btn.style.cursor = 'wait';
            txt.innerHTML = '<i class="bi bi-arrow-repeat"></i> Przekierowanie do Stripe…';
        });
    })();
</script>

@include('shared.footer')
@endsection
