@extends('layouts.auth')

@section('auth-content')
<div class="text-center mb-6">
    <h2 class="text-xl font-bold text-text-body mb-1">Witaj ponownie!</h2>
    <p class="text-slate-500 dark:text-slate-400 text-sm">Zaloguj się, aby kontynuować naukę na platformie.</p>
</div>

<form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
    @csrf
    
    <div>
        <label for="email" class="block text-xs font-bold text-text-body mb-1.5">Adres e-mail</label>
        <div class="flex rounded-xl shadow-sm border border-border bg-card-bg overflow-hidden focus-within:ring-2 focus-within:ring-primary/30 focus-within:border-primary transition-all">
            <span class="inline-flex items-center px-3 text-slate-400 bg-transparent border-r-0"><i class="bi bi-envelope"></i></span>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-3 py-2 bg-transparent text-text-body border-0 focus:ring-0 focus:outline-none placeholder-slate-400 text-sm" placeholder="nazwa@uczelnia.edu.pl">
        </div>
        @error('email')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <div class="flex items-center justify-between mb-1.5">
            <label for="password" class="block text-xs font-bold text-text-body mb-0">Hasło</label>
            <a href="#" class="text-xs text-primary font-bold hover:underline">Zapomniałeś?</a>
        </div>
        <div class="flex rounded-xl shadow-sm border border-border bg-card-bg overflow-hidden focus-within:ring-2 focus-within:ring-primary/30 focus-within:border-primary transition-all">
            <span class="inline-flex items-center px-3 text-slate-400 bg-transparent border-r-0"><i class="bi bi-lock"></i></span>
            <input id="password" type="password" name="password" required class="w-full px-3 py-2 bg-transparent text-text-body border-0 focus:ring-0 focus:outline-none placeholder-slate-400 text-sm" placeholder="••••••••">
        </div>
        @error('password')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center my-1">
        <input id="remember" type="checkbox" name="remember" class="w-4 h-4 rounded border-border text-primary focus:ring-primary">
        <label for="remember" class="ml-2 text-sm text-slate-500 dark:text-slate-400">Zapamiętaj mnie</label>
    </div>

    <button type="submit" class="w-full py-2.5 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold shadow-md hover:shadow-lg transition-all mt-2 cursor-pointer">
        Zaloguj się
    </button>
</form>

<div class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
    Nie masz jeszcze konta? 
    <a href="{{ route('register') }}" class="text-primary font-bold hover:underline">Zarejestruj się</a>
</div>
@endsection
