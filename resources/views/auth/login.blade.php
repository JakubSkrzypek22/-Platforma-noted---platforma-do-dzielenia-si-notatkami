@extends('layouts.auth')

@section('auth-content')
<div class="text-center mb-8">
    <h2 class="text-2xl font-bold text-white mb-2">Witaj ponownie!</h2>
    <p class="text-slate-400 text-sm">Zaloguj się, aby kontynuować swoją podróż.</p>
</div>

<form method="POST" action="{{ route('login') }}" class="space-y-5">
    @csrf
    
    <div>
        <label for="email" class="block text-sm font-medium text-slate-300 mb-1">Adres e-mail</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-regular fa-envelope text-slate-400"></i>
            </div>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full bg-slate-900/50 border border-slate-700 rounded-xl py-3 pl-10 pr-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
        </div>
        @error('email')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <div class="flex items-center justify-between mb-1">
            <label for="password" class="block text-sm font-medium text-slate-300">Hasło</label>
            <a href="#" class="text-sm font-medium text-primary hover:text-secondary transition-colors duration-300">Zapomniałeś hasła?</a>
        </div>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-lock text-slate-400"></i>
            </div>
            <input id="password" type="password" name="password" required class="w-full bg-slate-900/50 border border-slate-700 rounded-xl py-3 pl-10 pr-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
        </div>
    </div>

    <div class="flex items-center">
        <input id="remember" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-700 bg-slate-900 text-primary focus:ring-primary focus:ring-offset-darker">
        <label for="remember" class="ml-2 block text-sm text-slate-300">Zapamiętaj mnie</label>
    </div>

    <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary hover:from-blue-600 hover:to-purple-600 text-white font-medium py-3 px-4 rounded-xl shadow-lg transform transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
        Zaloguj się
    </button>
</form>

<div class="mt-8 text-center text-sm text-slate-400">
    Nie masz jeszcze konta? 
    <a href="{{ route('register') }}" class="font-medium text-primary hover:text-secondary transition-colors duration-300">Zarejestruj się</a>
</div>
@endsection
