<nav class="bg-card-bg border-b border-border transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo and main menu -->
            <div class="flex items-center">
                <a class="flex items-center text-xl font-extrabold text-text-body" href="{{ url('/') }}">
                    <span class="text-2xl mr-2">📚</span>
                    <span class="bg-gradient-to-r from-primary to-amber-500 bg-clip-text text-transparent">Noted</span>
                </a>
                <div class="hidden md:flex ml-10 items-baseline space-x-2">
                    <a id="nav-home-link" class="navbar-nav-link navbar-nav-link-home px-3 py-2 rounded-xl text-sm font-medium transition-colors @if (request()->is('/')) text-primary bg-primary/10 @else text-slate-600 dark:text-slate-300 hover:text-primary hover:bg-primary/5 @endif" href="{{ url('/') }}">
                        <i class="bi bi-house-door mr-1.5"></i> Strona Główna
                    </a>
                    <a id="nav-about-link" class="navbar-nav-link navbar-nav-link-about px-3 py-2 rounded-xl text-sm font-medium transition-colors @if (request()->is('o-nas')) text-primary bg-primary/10 @else text-slate-600 dark:text-slate-300 hover:text-primary hover:bg-primary/5 @endif" href="{{ route('about') }}">
                        <i class="bi bi-people mr-1.5"></i> O nas
                    </a>
                    <a id="nav-contact-link" class="navbar-nav-link navbar-nav-link-contact px-3 py-2 rounded-xl text-sm font-medium transition-colors @if (request()->is('kontakt')) text-primary bg-primary/10 @else text-slate-600 dark:text-slate-300 hover:text-primary hover:bg-primary/5 @endif" href="{{ route('contact') }}">
                        <i class="bi bi-envelope mr-1.5"></i> Kontakt
                    </a>
                </div>
            </div>

            <!-- Right menu (User auth & Theme switcher) -->
            <div class="hidden md:flex items-center space-x-4">
                <!-- Theme Switcher Dropdown -->
                <div class="relative inline-block text-left" id="theme-dropdown-container">
                    <button class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold border border-border bg-card-bg text-text-body hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors cursor-pointer" id="themeDropdownBtn" type="button">
                        <i id="theme-icon-active" class="bi bi-circle-half mr-2"></i>
                        <span id="theme-text-active">Motyw</span>
                        <i class="bi bi-chevron-down ml-1.5 text-xs opacity-70"></i>
                    </button>
                    <div class="hidden absolute right-0 mt-2 w-48 rounded-xl shadow-lg bg-card-bg border border-border ring-1 ring-black/5 divide-y divide-border z-50 focus:outline-none" id="themeDropdownMenu">
                        <div class="py-1">
                            <button class="flex items-center w-full px-4 py-2 text-sm text-text-body hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors cursor-pointer" data-theme-value="light" onclick="setTheme('light')">
                                <i class="bi bi-sun-fill mr-2.5 text-amber-500"></i> Jasny
                            </button>
                            <button class="flex items-center w-full px-4 py-2 text-sm text-text-body hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors cursor-pointer" data-theme-value="dark" onclick="setTheme('dark')">
                                <i class="bi bi-moon-stars-fill mr-2.5 text-indigo-400"></i> Ciemny
                            </button>
                            <button class="flex items-center w-full px-4 py-2 text-sm text-text-body hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors cursor-pointer" data-theme-value="beige" onclick="setTheme('beige')">
                                <i class="bi bi-palette-fill mr-2.5 text-[#c2593f]"></i> Kremowy
                            </button>
                            <button class="flex items-center w-full px-4 py-2 text-sm text-text-body hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors cursor-pointer" data-theme-value="system" onclick="setTheme('system')">
                                <i class="bi bi-circle-half mr-2.5 opacity-70"></i> Systemowy
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Authentication Links -->
                @if (Auth::check())
                    <div class="relative inline-block text-left" id="user-dropdown-container">
                        <button class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold border border-border bg-card-bg text-text-body hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors cursor-pointer" id="userDropdownBtn" type="button">
                            <i class="bi bi-person-circle text-lg mr-2 text-primary"></i>
                            <span>{{ Auth::user()->name }}</span>
                            <i class="bi bi-chevron-down ml-1.5 text-xs opacity-70"></i>
                        </button>
                        <div class="hidden absolute right-0 mt-2 w-48 rounded-xl shadow-lg bg-card-bg border border-border ring-1 ring-black/5 z-50 focus:outline-none" id="userDropdownMenu">
                            <div class="py-1.5 px-1.5">
                                <a class="flex items-center w-full px-3 py-2 rounded-lg text-sm text-text-body hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors" href="{{ route('dashboard') }}">
                                    <i class="bi bi-person-vcard mr-2.5 opacity-70"></i> Mój profil
                                </a>
                                <a class="flex items-center w-full px-3 py-2 rounded-lg text-sm text-text-body hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors" href="{{ route('notes.create') }}">
                                    <i class="bi bi-plus-circle mr-2.5 opacity-70"></i> Dodaj notatkę
                                </a>
                                <div class="border-t border-border my-1.5"></div>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-3 py-2 rounded-lg text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/20 font-bold transition-colors cursor-pointer">
                                        <i class="bi bi-box-arrow-right mr-2.5"></i> Wyloguj się
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a class="px-4 py-2 border border-border rounded-xl text-sm font-semibold text-text-body hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors" href="{{ route('login') }}">
                        Zaloguj się
                    </a>
                    <a class="px-4 py-2 bg-primary hover:bg-primary-hover text-white rounded-xl text-sm font-bold shadow-sm transition-colors" href="{{ route('register') }}">
                        Zarejestruj się
                    </a>
                @endif
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex md:hidden">
                <button type="button" id="mobile-menu-btn" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 focus:outline-none transition-colors" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <i class="bi bi-list text-2xl" id="menu-icon-closed"></i>
                    <i class="bi bi-x text-2xl hidden" id="menu-icon-opened"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="hidden md:hidden border-t border-border px-4 pt-2 pb-4 space-y-1 bg-card-bg" id="mobile-menu">
        <a id="nav-home-link-mobile" class="navbar-nav-link navbar-nav-link-home block px-3 py-2 rounded-xl text-base font-medium @if (request()->is('/')) text-primary bg-primary/10 @else text-slate-600 dark:text-slate-300 hover:text-primary hover:bg-primary/5 @endif" href="{{ url('/') }}">
            <i class="bi bi-house-door mr-2"></i> Strona Główna
        </a>
        <a id="nav-about-link-mobile" class="navbar-nav-link navbar-nav-link-about block px-3 py-2 rounded-xl text-base font-medium @if (request()->is('o-nas')) text-primary bg-primary/10 @else text-slate-600 dark:text-slate-300 hover:text-primary hover:bg-primary/5 @endif" href="{{ route('about') }}">
            <i class="bi bi-people mr-2"></i> O nas
        </a>
        <a id="nav-contact-link-mobile" class="navbar-nav-link navbar-nav-link-contact block px-3 py-2 rounded-xl text-base font-medium @if (request()->is('kontakt')) text-primary bg-primary/10 @else text-slate-600 dark:text-slate-300 hover:text-primary hover:bg-primary/5 @endif" href="{{ route('contact') }}">
            <i class="bi bi-envelope mr-2"></i> Kontakt
        </a>
        <div class="border-t border-border my-3"></div>
        <div class="flex items-center justify-between px-3 py-2">
            <span class="text-sm font-semibold text-slate-500">Zmień motyw</span>
            <div class="flex space-x-1">
                <button onclick="setTheme('light')" class="p-2 rounded-lg text-amber-500 hover:bg-slate-100 dark:hover:bg-slate-700/50" title="Jasny"><i class="bi bi-sun-fill"></i></button>
                <button onclick="setTheme('dark')" class="p-2 rounded-lg text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-700/50" title="Ciemny"><i class="bi bi-moon-stars-fill"></i></button>
                <button onclick="setTheme('beige')" class="p-2 rounded-lg text-[#c2593f] hover:bg-slate-100 dark:hover:bg-slate-700/50" title="Kremowy"><i class="bi bi-palette-fill"></i></button>
                <button onclick="setTheme('system')" class="p-2 rounded-lg text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50" title="Systemowy"><i class="bi bi-circle-half"></i></button>
            </div>
        </div>
        <div class="border-t border-border my-3"></div>
        @if (Auth::check())
            <div class="px-3 py-2">
                <div class="text-base font-bold text-text-body mb-2"><i class="bi bi-person-circle mr-2 text-primary"></i>{{ Auth::user()->name }}</div>
                <a class="block py-2 text-sm text-slate-600 dark:text-slate-300 hover:text-primary" href="{{ route('dashboard') }}">
                    <i class="bi bi-person-vcard mr-2"></i> Mój profil
                </a>
                <a class="block py-2 text-sm text-slate-600 dark:text-slate-300 hover:text-primary" href="{{ route('notes.create') }}">
                    <i class="bi bi-plus-circle mr-2"></i> Dodaj notatkę
                </a>
                <form action="{{ route('logout') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center py-2 bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-400 font-bold rounded-xl text-sm hover:bg-red-100/50 dark:hover:bg-red-950/40 transition-colors cursor-pointer">
                        <i class="bi bi-box-arrow-right mr-2"></i> Wyloguj się
                    </button>
                </form>
            </div>
        @else
            <div class="grid grid-cols-2 gap-2 pt-2 px-3">
                <a class="flex justify-center items-center py-2.5 border border-border rounded-xl text-sm font-semibold text-text-body hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors" href="{{ route('login') }}">
                    Zaloguj się
                </a>
                <a class="flex justify-center items-center py-2.5 bg-primary hover:bg-primary-hover text-white rounded-xl text-sm font-bold shadow-sm transition-colors" href="{{ route('register') }}">
                    Zarejestruj się
                </a>
            </div>
        @endif
    </div>

    <!-- Toggle scripts for menus -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Theme dropdown
            const themeBtn = document.getElementById('themeDropdownBtn');
            const themeMenu = document.getElementById('themeDropdownMenu');
            if (themeBtn && themeMenu) {
                themeBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    themeMenu.classList.toggle('hidden');
                    // Hide user menu if open
                    if (userMenu) userMenu.classList.add('hidden');
                });
            }

            // User dropdown
            const userBtn = document.getElementById('userDropdownBtn');
            const userMenu = document.getElementById('userDropdownMenu');
            if (userBtn && userMenu) {
                userBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userMenu.classList.toggle('hidden');
                    // Hide theme menu if open
                    if (themeMenu) themeMenu.classList.add('hidden');
                });
            }

            // Mobile menu toggle
            const mobileBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const iconClosed = document.getElementById('menu-icon-closed');
            const iconOpened = document.getElementById('menu-icon-opened');
            if (mobileBtn && mobileMenu) {
                mobileBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    iconClosed.classList.toggle('hidden');
                    iconOpened.classList.toggle('hidden');
                });
            }

            // Close dropdowns on body click
            document.addEventListener('click', () => {
                if (themeMenu) themeMenu.classList.add('hidden');
                if (userMenu) userMenu.classList.add('hidden');
            });
        });
    </script>

    @include('shared.success-toast')
</nav>
