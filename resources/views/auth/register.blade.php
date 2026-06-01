@extends('layouts.auth')

@section('auth-content')
<div class="text-center mb-6">
    <h2 class="text-xl font-bold text-text-body mb-1">Dołącz do nas!</h2>
    <p class="text-slate-500 dark:text-slate-400 text-sm">Zarejestruj się, aby dzielić się notatkami studenckimi.</p>
</div>

<form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4">
    @csrf
    
    <div>
        <label for="name" class="block text-xs font-bold text-text-body mb-1.5">Nazwa użytkownika</label>
        <div class="flex rounded-xl shadow-sm border border-border bg-card-bg overflow-hidden focus-within:ring-2 focus-within:ring-primary/30 focus-within:border-primary transition-all">
            <span class="inline-flex items-center px-3 text-slate-400 bg-transparent border-r-0"><i class="bi bi-person"></i></span>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full px-3 py-2 bg-transparent text-text-body border-0 focus:ring-0 focus:outline-none placeholder-slate-400 text-sm" placeholder="np. JanKowalski">
        </div>
        @error('name')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-xs font-bold text-text-body mb-1.5">Adres e-mail</label>
        <div class="flex rounded-xl shadow-sm border border-border bg-card-bg overflow-hidden focus-within:ring-2 focus-within:ring-primary/30 focus-within:border-primary transition-all">
            <span class="inline-flex items-center px-3 text-slate-400 bg-transparent border-r-0"><i class="bi bi-envelope"></i></span>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full px-3 py-2 bg-transparent text-text-body border-0 focus:ring-0 focus:outline-none placeholder-slate-400 text-sm" placeholder="nazwa@uczelnia.edu.pl">
        </div>
        @error('email')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-xs font-bold text-text-body mb-1.5">Hasło</label>
        <div class="flex rounded-xl shadow-sm border border-border bg-card-bg overflow-hidden focus-within:ring-2 focus-within:ring-primary/30 focus-within:border-primary transition-all">
            <span class="inline-flex items-center px-3 text-slate-400 bg-transparent border-r-0"><i class="bi bi-lock"></i></span>
            <input id="password" type="password" name="password" required class="w-full px-3 py-2 bg-transparent text-text-body border-0 focus:ring-0 focus:outline-none placeholder-slate-400 text-sm" placeholder="••••••••">
        </div>
        @error('password')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-xs font-bold text-text-body mb-1.5">Powtórz hasło</label>
        <div class="flex rounded-xl shadow-sm border border-border bg-card-bg overflow-hidden focus-within:ring-2 focus-within:ring-primary/30 focus-within:border-primary transition-all">
            <span class="inline-flex items-center px-3 text-slate-400 bg-transparent border-r-0"><i class="bi bi-lock-fill"></i></span>
            <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full px-3 py-2 bg-transparent text-text-body border-0 focus:ring-0 focus:outline-none placeholder-slate-400 text-sm" placeholder="••••••••">
        </div>
    </div>

    <div class="flex items-start my-1">
        <input id="terms" type="checkbox" name="terms" required class="w-4 h-4 mt-0.5 rounded border-border text-primary focus:ring-primary">
        <label for="terms" class="ml-2 text-sm text-slate-500 dark:text-slate-400 leading-tight">
            Akceptuję <a href="#" class="text-primary font-bold hover:underline">Regulamin</a> i <a href="#" class="text-primary font-bold hover:underline">Politykę Prywatności</a>
        </label>
        @error('terms')
            <p class="mt-1 text-xs text-red-500 block">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="w-full py-2.5 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold shadow-md hover:shadow-lg transition-all mt-2 cursor-pointer">
        Utwórz konto
    </button>
</form>

<div class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
    Masz już konto? 
    <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Zaloguj się</a>
</div>
@endsection
