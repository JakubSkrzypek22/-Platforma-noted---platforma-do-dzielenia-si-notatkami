@extends('layouts.app')

@section('content')
@include('shared.navbar')

<main class="flex-grow-1 py-4">
    <div class="container">
        @yield('dashboard-content')
    </div>
</main>

@include('shared.footer')
@endsection

