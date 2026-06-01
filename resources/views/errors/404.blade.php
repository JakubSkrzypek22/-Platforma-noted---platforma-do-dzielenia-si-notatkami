@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-bg-body relative overflow-hidden">
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-primary/10 blur-[120px]"></div>
    
    <div class="z-10 text-center max-w-lg p-6">
        <h1 class="text-9xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-indigo-500 mb-4">404</h1>
        <h2 class="text-3xl font-semibold text-text-body mb-6">Strona nie znaleziona</h2>
        <p class="text-slate-500 dark:text-slate-400 mb-8">Wygląda na to, że zabłądziłeś. Droga, której szukasz, nie istnieje lub została przeniesiona.</p>
        
        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-indigo-500 hover:from-primary-hover hover:to-indigo-600 text-white rounded-xl font-medium transition-transform duration-300 hover:scale-105 shadow-lg cursor-pointer">
            <i class="bi bi-house mr-2 text-base"></i> Wróć do Panelu
        </a>
    </div>
</div>
@endsection
