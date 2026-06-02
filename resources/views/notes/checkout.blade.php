@extends('layouts.app')

@section('content')
@include('shared.navbar')

<main class="flex-grow py-10 bg-slate-100/50 dark:bg-slate-900/30">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <a href="{{ route('notes.show', $note) }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 dark:text-slate-400 hover:text-primary mb-6">
            <i class="bi bi-arrow-left"></i> Wróć do notatki
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- FORMULARZ PŁATNOŚCI (symulacja bramki) -->
            <div class="lg:col-span-7">
                <div class="bg-card-bg border border-border rounded-2xl p-6 sm:p-8 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-xl font-extrabold text-text-body">Płatność</h1>
                        <div class="flex items-center gap-2 text-slate-400">
                            <i class="bi bi-credit-card-2-front text-xl"></i>
                            <i class="bi bi-paypal text-xl"></i>
                            <i class="bi bi-shield-lock-fill text-emerald-500"></i>
                        </div>
                    </div>

                    <div class="mb-6 flex items-start gap-3 p-3.5 rounded-xl bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-900/40 text-amber-700 dark:text-amber-400 text-xs">
                        <i class="bi bi-info-circle-fill text-base mt-0.5"></i>
                        <span><strong>Tryb demonstracyjny.</strong> To symulowana płatność imitująca prawdziwą bramkę — żadna karta nie zostanie obciążona. Możesz użyć dowolnego numeru testowego (np. 4242 4242 4242 4242).</span>
                    </div>

                    @include('shared.validation-error')

                    <form action="{{ route('notes.payment', $note) }}" method="POST" id="paymentForm">
                        @csrf

                        <!-- Metoda płatności -->
                        <div class="grid grid-cols-2 gap-3 mb-6">
                            <label class="flex items-center gap-2 p-3 rounded-xl border-2 border-primary bg-primary/5 cursor-pointer">
                                <input type="radio" name="method_ui" value="card" checked class="text-primary focus:ring-primary">
                                <i class="bi bi-credit-card-fill text-primary"></i>
                                <span class="text-sm font-semibold text-text-body">Karta</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 rounded-xl border border-border cursor-pointer opacity-60">
                                <input type="radio" name="method_ui" value="blik" disabled class="text-primary focus:ring-primary">
                                <i class="bi bi-phone-fill"></i>
                                <span class="text-sm font-semibold text-text-body">BLIK (wkrótce)</span>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label for="card_name" class="block text-xs font-bold text-text-body mb-1.5">Właściciel karty</label>
                            <input type="text" name="card_name" id="card_name" value="{{ old('card_name', auth()->user()->name) }}"
                                   class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm"
                                   placeholder="Jan Kowalski" required>
                        </div>

                        <div class="mb-4">
                            <label for="card_number" class="block text-xs font-bold text-text-body mb-1.5">Numer karty</label>
                            <div class="relative">
                                <input type="text" name="card_number" id="card_number" value="{{ old('card_number') }}"
                                       inputmode="numeric" autocomplete="cc-number" maxlength="23"
                                       class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm tracking-widest"
                                       placeholder="4242 4242 4242 4242" required>
                                <i class="bi bi-credit-card absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="card_expiry" class="block text-xs font-bold text-text-body mb-1.5">Ważność (MM/RR)</label>
                                <input type="text" name="card_expiry" id="card_expiry" value="{{ old('card_expiry') }}"
                                       inputmode="numeric" maxlength="5"
                                       class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm"
                                       placeholder="12/28" required>
                            </div>
                            <div>
                                <label for="card_cvc" class="block text-xs font-bold text-text-body mb-1.5">CVC</label>
                                <input type="text" name="card_cvc" id="card_cvc" value="{{ old('card_cvc') }}"
                                       inputmode="numeric" maxlength="4"
                                       class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm"
                                       placeholder="123" required>
                            </div>
                        </div>

                        <button type="submit" id="payBtn"
                                class="w-full py-3.5 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-md transition-all">
                            <i class="bi bi-lock-fill"></i>
                            <span id="payBtnText">Zapłać {{ $note->isFree() ? '0,00 zł' : number_format($note->price, 2, ',', ' ') . ' zł' }}</span>
                        </button>

                        <p class="text-center text-[11px] text-slate-400 mt-3">
                            <i class="bi bi-shield-check"></i> Połączenie szyfrowane. Dane karty nie są nigdzie zapisywane.
                        </p>
                    </form>
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
                        <span>Natychmiastowy dostęp do pełnego pliku po opłaceniu.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Formatowanie pól karty + symulacja "przetwarzania płatności"
    (function () {
        const number = document.getElementById('card_number');
        const expiry = document.getElementById('card_expiry');
        const cvc    = document.getElementById('card_cvc');
        const form   = document.getElementById('paymentForm');
        const btn    = document.getElementById('payBtn');
        const btnTxt = document.getElementById('payBtnText');

        number.addEventListener('input', () => {
            let v = number.value.replace(/\D/g, '').slice(0, 19);
            number.value = v.replace(/(.{4})/g, '$1 ').trim();
        });
        expiry.addEventListener('input', () => {
            let v = expiry.value.replace(/\D/g, '').slice(0, 4);
            expiry.value = v.length > 2 ? v.slice(0, 2) + '/' + v.slice(2) : v;
        });
        cvc.addEventListener('input', () => {
            cvc.value = cvc.value.replace(/\D/g, '').slice(0, 4);
        });

        // Imitacja przetwarzania płatności przed wysłaniem formularza
        form.addEventListener('submit', function () {
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-wait');
            btnTxt.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i> Przetwarzanie płatności…';
        });
    })();
</script>

@include('shared.footer')
@endsection
