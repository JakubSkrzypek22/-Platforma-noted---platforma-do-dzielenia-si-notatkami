@extends('layouts.app')

@section('content')
@include('shared.navbar')

<main class="flex-grow py-8">
    <div class="container mx-auto px-4">
        @yield('dashboard-content')
    </div>
</main>

@include('shared.footer')
@endsection
