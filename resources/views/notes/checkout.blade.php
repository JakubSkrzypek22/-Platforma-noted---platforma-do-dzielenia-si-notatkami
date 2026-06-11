@extends('layouts.app')

@section('content')
@include('shared.navbar')

<main class="flex-grow py-10 bg-slate-100/50 dark:bg-slate-900/30">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <a href="{{ route('notes.show', $note) }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 dark:text-slate-400 hover:text-primary mb-6">
            <i class="bi bi-arrow-left"></i> Wróć do notatki
        </a>

        @if (session('error'))
            <div class="bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/50 text-red-700 dark:text-red-400 p-4 rounded-xl text-sm mb-6">
                <i class="bi bi-exclamation-triangle-fill mr-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- PŁATNOŚĆ STRIPE -->
            <div class="lg:col-span-7">
                <div class="bg-card-bg border border-border rounded-2xl p-6 sm:p-8 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-xl font-extrabold text-text-body">Płatność</h1>
                        <div class="flex items-center gap-2 text-slate-400">
                            <i class="bi bi-credit-card-2-front text-xl"></i>
                            <i class="bi bi-shield-lock-fill text-emerald-500"></i>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-xl border border-border bg-slate-50 dark:bg-slate-800/40 mb-6">
                        <div class="w-11 h-11 rounded-full bg-[#635bff]/10 flex items-center justify-center text-[#635bff] flex-shrink-0">
                            <i class="bi bi-stripe text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-text-body text-sm mb-1">Bezpieczna płatność online</h2>
                            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                                Po kliknięciu przycisku zostaniesz przekierowany na zabezpieczoną stronę Stripe,
                                gdzie dokończysz płatność kartą. Dostęp do notatki otrzymasz natychmiast po opłaceniu.
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('notes.payment', $note) }}" method="POST" id="paymentForm">
                        @csrf
                        <button type="submit" id="payBtn"
                                class="w-full py-3.5 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-md transition-all">
                            <i class="bi bi-lock-fill"></i>
                            <span id="payBtnText">Zapłać {{ number_format($note->price, 2, ',', ' ') }} zł</span>
                        </button>
                    </form>

                    <p class="text-center text-[11px] text-slate-400 mt-3">
                        <i class="bi bi-shield-check"></i> Płatność obsługuje Stripe. Dane Twojej karty nie trafiają na nasz serwer.
                    </p>
                </div>
            </div>

            <!-- PODSUMOWANIE ZAMÓWIENIA -->
            <div class="lg:col-span-5">
                <div class="bg-card-bg border border-border rounded-2xl p-6 shadow-sm sticky top-6">
                    <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Podsumowanie</h2>

                    <div class="flex gap-3 mb-5">
                        <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                            <i class="bi {{ $note->isPdf() ? 'bi-file-earmark-pdf-fill' : 'bi-file-earmark-image-fill' }} text-xl"></i>
                        </div>
                        <div>
                            <div class="font-bold text-text-body text-sm leading-snug">{{ $note->title }}</div>
                            <div class="text-xs text-slate-400 mt-0.5">{{ $note->category }} · {{ $note->author->name ?? '' }}</div>
                        </div>
                    </div>

                    <div class="border-t border-border pt-4 space-y-2 text-sm">
                        <div class="flex justify-between text-slate-500 dark:text-slate-400">
                            <span>Cena notatki</span>
                            <span>{{ number_format($note->price, 2, ',', ' ') }} zł</span>
                        </div>
                        <div class="flex justify-between text-slate-500 dark:text-slate-400">
                            <span>Opłata serwisowa</span>
                            <span>0,00 zł</span>
                        </div>
                        <div class="flex justify-between font-extrabold text-text-body text-base border-t border-border pt-3 mt-2">
                            <span>Do zapłaty</span>
                            <span>{{ number_format($note->price, 2, ',', ' ') }} zł</span>
                        </div>
                    </div>

                    <div class="mt-5 flex items-center gap-2 text-xs text-emerald-600 dark:text-emerald-400">
                        <i class="bi bi-arrow-repeat"></i>
                        <span>Natychmiastowy dostęp do pełnej notatki po opłaceniu.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    (function () {
        const form   = document.getElementById('paymentForm');
        const btn    = document.getElementById('payBtn');
        const btnTxt = document.getElementById('payBtnText');
        form.addEventListener('submit', function () {
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-wait');
            btnTxt.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i> Przekierowanie do Stripe…';
        });
    })();
</script>

@include('shared.footer')
@endsection
