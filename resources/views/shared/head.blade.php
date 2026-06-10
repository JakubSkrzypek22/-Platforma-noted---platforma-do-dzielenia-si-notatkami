<head>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📚</text></svg>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Driver.js — biblioteka do podświetlania elementów (samouczek) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">

    {{-- Chat Help Widget --}}
    <link rel="stylesheet" href="{{ asset('css/chat-widget.css') }}">

    <script src="{{ asset('js/theme.js') }}"></script>
    <script defer src="{{ asset('js/toast.js') }}"></script>
</head>
