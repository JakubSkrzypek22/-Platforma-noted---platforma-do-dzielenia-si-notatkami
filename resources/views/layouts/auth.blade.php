@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 py-5">
    <div class="w-100" style="max-width: 440px; padding: 1.25rem;">
        <div class="text-center mb-4">
            <span class="fs-1 d-block mb-2">📚</span>
            <h1 class="display-6 fw-bold mb-1 text-body">Notet</h1>
            <p class="text-secondary">Platforma Dzielenia się Notatkami Studenckimi</p>
        </div>
        
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <!-- Top premium colored line -->
            <div style="height: 4px; background: linear-gradient(135deg, var(--bs-primary) 0%, #818cf8 100%);"></div>
            
            <div class="card-body p-4 p-md-5">
                @yield('auth-content')
            </div>
        </div>
    </div>
</div>
@endsection

