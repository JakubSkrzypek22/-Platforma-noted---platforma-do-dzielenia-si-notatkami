@include('shared.html')
@include('shared.head', ['pageTitle' => $pageTitle ?? 'Notet — Drugie Życie Twoich Notatek 📚'])
<body class="d-flex flex-column min-vh-100 bg-body-tertiary text-body">
    @yield('content')
</body>
</html>

