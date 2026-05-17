@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center relative overflow-hidden bg-darker">
    <!-- Background Gradients -->
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-primary/20 blur-[120px]"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-secondary/20 blur-[120px]"></div>
    
    <div class="z-10 w-full max-w-md p-6">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary mb-2">Platforma noted</h1>
            <p class="text-slate-400">Dziel się swoimi notatkami z innymi</p>
        </div>
        
        <!-- Glassmorphism Card -->
        <div class="glass rounded-2xl shadow-2xl p-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-secondary"></div>
            @yield('auth-content')
        </div>
    </div>
</div>
@endsection
