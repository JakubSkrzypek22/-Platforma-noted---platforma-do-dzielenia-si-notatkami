@include('shared.html')
@include('shared.head', ['pageTitle' => $pageTitle ?? 'Noted — Drugie Życie Twoich Notatek 📚'])
<body class="flex flex-col min-h-screen bg-bg-body text-text-body font-sans antialiased">
    @yield('content')
</body>
</html>
