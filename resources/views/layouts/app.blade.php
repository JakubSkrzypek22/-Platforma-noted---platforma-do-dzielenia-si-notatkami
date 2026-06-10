@include('shared.html')
@include('shared.head', ['pageTitle' => $pageTitle ?? 'Noted — Drugie Życie Twoich Notatek 📚'])
@if(auth()->check() && auth()->user()->isAdmin())
    <div class="bg-red-600 text-white text-center py-2 px-4 text-sm font-bold shadow-md z-50 relative flex flex-wrap justify-center items-center gap-4">
        <span>
            <i class="bi bi-shield-lock-fill mr-1 text-lg"></i> 
            Tryb Administratora Aktywny (Widzisz wszystkie notatki bez ukrywania)
        </span>
        <a href="{{ route('admin.index') }}" class="bg-white text-red-600 px-4 py-1 rounded-full text-xs hover:bg-red-50 hover:scale-105 transition-all shadow-sm">
            Przejdź do panelu
        </a>
    </div>
@endif
<body class="flex flex-col min-h-screen bg-bg-body text-text-body font-sans antialiased">
    @yield('content')

    {{-- Driver.js + Chat Help Widget — tylko dla zalogowanych użytkowników --}}
    @auth
        <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.iife.js"></script>
        <script defer src="{{ asset('js/chat-widget.js') }}"></script>
    @endauth
</body>
</html>

