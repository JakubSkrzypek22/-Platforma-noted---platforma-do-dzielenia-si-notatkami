@extends('layouts.app')

@section('content')
@include('shared.navbar')

<main class="flex-grow py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10">
            <span class="text-primary font-bold uppercase tracking-widest text-xs">Jesteśmy do dyspozycji</span>
            <h1 class="text-3xl md:text-4xl font-extrabold mt-2 text-text-body">Kontakt</h1>
            <p class="text-base text-slate-500 dark:text-slate-400 mt-4 leading-relaxed max-w-2xl mx-auto">
                Masz pytanie, propozycję współpracy albo problem techniczny? Napisz do nas — odpowiadamy zwykle w ciągu 24 godzin.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Dane kontaktowe -->
            <div class="lg:col-span-5 space-y-4">
                <div class="bg-card-bg border border-border rounded-2xl p-5 flex items-start gap-4">
                    <div class="w-11 h-11 rounded-full bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                        <i class="bi bi-envelope-fill text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-text-body text-sm">E-mail</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">kontakt@noded.pl</p>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">pomoc@noded.pl</p>
                    </div>
                </div>

                <div class="bg-card-bg border border-border rounded-2xl p-5 flex items-start gap-4">
                    <div class="w-11 h-11 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500 flex-shrink-0">
                        <i class="bi bi-telephone-fill text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-text-body text-sm">Telefon</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">+48 123 456 789</p>
                        <p class="text-slate-400 text-xs">pon.–pt. 9:00–17:00</p>
                    </div>
                </div>

                <div class="bg-card-bg border border-border rounded-2xl p-5 flex items-start gap-4">
                    <div class="w-11 h-11 rounded-full bg-amber-500/10 flex items-center justify-center text-amber-500 flex-shrink-0">
                        <i class="bi bi-geo-alt-fill text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-text-body text-sm">Adres</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">ul. Akademicka 12<br>00-001 Warszawa</p>
                    </div>
                </div>

                <div class="bg-card-bg border border-border rounded-2xl p-5">
                    <h3 class="font-bold text-text-body text-sm mb-3">Znajdź nas</h3>
                    <div class="flex gap-3 text-xl text-slate-400">
                        <a href="#" class="hover:text-primary transition-colors"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="hover:text-primary transition-colors"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="hover:text-primary transition-colors"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="hover:text-primary transition-colors"><i class="bi bi-github"></i></a>
                    </div>
                </div>
            </div>

            <!-- Formularz (demonstracyjny) -->
            <div class="lg:col-span-7">
                <div class="bg-card-bg border border-border rounded-2xl p-6 sm:p-8 shadow-sm">
                    <h2 class="text-lg font-bold text-text-body mb-1">Napisz do nas</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-5">Wypełnij formularz, a my skontaktujemy się z Tobą najszybciej, jak to możliwe.</p>

                    <form onsubmit="event.preventDefault(); document.getElementById('contactDone').classList.remove('hidden'); this.reset();" class="flex flex-col gap-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-text-body mb-1.5">Imię i nazwisko</label>
                                <input type="text" class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm" placeholder="Jan Kowalski" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-text-body mb-1.5">E-mail</label>
                                <input type="email" class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm" placeholder="jan@example.com" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-text-body mb-1.5">Temat</label>
                            <input type="text" class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm" placeholder="W czym możemy pomóc?" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-text-body mb-1.5">Wiadomość</label>
                            <textarea rows="5" class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm resize-none" placeholder="Treść wiadomości…" required></textarea>
                        </div>

                        <div id="contactDone" class="hidden bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-900/50 text-emerald-700 dark:text-emerald-400 p-3.5 rounded-xl text-sm">
                            <i class="bi bi-check-circle-fill mr-1.5"></i> Dziękujemy! Wiadomość została wysłana (demo).
                        </div>

                        <button type="submit" class="self-start px-6 py-3 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold text-sm transition-colors">
                            <i class="bi bi-send-fill mr-1.5"></i> Wyślij wiadomość
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

@include('shared.footer')
@endsection
