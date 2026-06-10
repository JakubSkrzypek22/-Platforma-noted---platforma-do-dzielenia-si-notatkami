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
                        <p class="text-slate-500 dark:text-slate-400 text-sm">jakubskrzypek005@gmail.com</p>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">js137139@stud.ur.edu.pl</p>
                    </div>
                </div>

                <div class="bg-card-bg border border-border rounded-2xl p-5 flex items-start gap-4">
                    <div class="w-11 h-11 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500 flex-shrink-0">
                        <i class="bi bi-telephone-fill text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-text-body text-sm">Telefon</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">+48 531 179 284</p>
                        <p class="text-slate-400 text-xs">pon.–pt. 9:00–17:00</p>
                    </div>
                </div>

                <div class="bg-card-bg border border-border rounded-2xl p-5 flex items-start gap-4">
                    <div class="w-11 h-11 rounded-full bg-amber-500/10 flex items-center justify-center text-amber-500 flex-shrink-0">
                        <i class="bi bi-geo-alt-fill text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-text-body text-sm">Adres</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">ul. Tadeusza Rejtana 16C<br>35-310 Rzeszów</p>
                    </div>
                </div>

                <div class="bg-card-bg border border-border rounded-2xl p-5">
                    <h3 class="font-bold text-text-body text-sm mb-3">Znajdź nas</h3>
                    <div class="flex gap-3 text-xl text-slate-400">
                        <a href="https://www.facebook.com/profile.php?id=61583774580375" class="hover:text-primary transition-colors"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/skn.trojan.ur/" class="hover:text-primary transition-colors"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.linkedin.com/in/jakub-skrzypek-2628242b5/" class="hover:text-primary transition-colors"><i class="bi bi-linkedin"></i></a>
                        <a href="https://github.com/JakubSkrzypek22/-Platforma-noted---platforma-do-dzielenia-si-notatkami" class="hover:text-primary transition-colors"><i class="bi bi-github"></i></a>
                    </div>
                </div>
            </div>

            <!-- Formularz (demonstracyjny) -->
            <div class="lg:col-span-7">
                <div class="bg-card-bg border border-border rounded-2xl p-6 sm:p-8 shadow-sm">
                    <h2 class="text-lg font-bold text-text-body mb-1">Napisz do nas</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-5">Wypełnij formularz, a my skontaktujemy się z Tobą najszybciej, jak to możliwe.</p>

                    <form id="contactForm" class="flex flex-col gap-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="user_name" class="block text-xs font-bold text-text-body mb-1.5">Imię i nazwisko</label>
                                <input id="user_name" name="user_name" type="text" class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm" placeholder="Jan Kowalski" required>
                            </div>
                            <div>
                                <label for="user_email" class="block text-xs font-bold text-text-body mb-1.5">E-mail</label>
                                <input id="user_email" name="user_email" type="email" class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm" placeholder="jan@example.com" required>
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="block text-xs font-bold text-text-body mb-1.5">Temat</label>
                            <input id="subject" name="subject" type="text" class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm" placeholder="W czym możemy pomóc?" required>
                        </div>
                        <div>
                            <label for="message" class="block text-xs font-bold text-text-body mb-1.5">Wiadomość</label>
                            <textarea id="message" name="message" rows="5" class="w-full px-3.5 py-2.5 border border-border rounded-xl bg-card-bg text-text-body focus:ring-2 focus:ring-primary/30 focus:border-primary focus:outline-none text-sm resize-none" placeholder="Treść wiadomości…" required></textarea>
                        </div>

                        <div id="contactDone" class="hidden p-3.5 rounded-xl text-sm"></div>

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

<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
<script>
    (function () {
        const form = document.getElementById('contactForm');
        const statusBox = document.getElementById('contactDone');

        if (!form || !statusBox) return;

        emailjs.init('q4D-O_OWAvixuXAD3'); // PUBLIC_KEY z EmailJS

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            statusBox.className = 'hidden';
            statusBox.textContent = '';

            statusBox.className = 'block bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-900/50 text-amber-700 dark:text-amber-400 p-3.5 rounded-xl text-sm';
            statusBox.innerHTML = '<i class="bi bi-send-fill mr-1.5"></i> Wysyłanie wiadomości...';

            emailjs.sendForm('service_9gproeo', 'template_tj0dp59', this) // SERVICE_ID i TEMPLATE_ID z EmailJS
                .then(function () {
                    statusBox.className = 'block bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-900/50 text-emerald-700 dark:text-emerald-400 p-3.5 rounded-xl text-sm';
                    statusBox.innerHTML = '<i class="bi bi-check-circle-fill mr-1.5"></i> Dziękujemy! Wiadomość została wysłana.';
                    form.reset();
                })
                .catch(function (error) {
                    console.error('EmailJS error:', error);
                    statusBox.className = 'block bg-rose-50 dark:bg-rose-950/20 border border-rose-200 dark:border-rose-900/50 text-rose-700 dark:text-rose-400 p-3.5 rounded-xl text-sm';
                    statusBox.innerHTML = '<i class="bi bi-exclamation-triangle-fill mr-1.5"></i> Wysyłanie nie powiodło się. Sprawdź ustawienia EmailJS i spróbuj ponownie.';
                });
        });
    })();
</script>

@endsection
