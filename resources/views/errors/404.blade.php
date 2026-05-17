@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-darker relative overflow-hidden">
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-primary/20 blur-[120px]"></div>
    
    <div class="z-10 text-center max-w-lg p-6">
        <h1 class="text-9xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary mb-4">404</h1>
        <h2 class="text-3xl font-semibold text-white mb-6">Strona nie znaleziona</h2>
        <p class="text-slate-400 mb-8">Wygląda na to, że zabłądziłeś. Droga, której szukasz, nie istnieje lub została przeniesiona.</p>
        
        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary hover:from-blue-600 hover:to-purple-600 text-white rounded-xl font-medium transition-transform duration-300 hover:scale-105 shadow-lg">
            <i class="fa-solid fa-house mr-2"></i> Wróć do Panelu
        </a>
    </div>
</div>
@endsection
