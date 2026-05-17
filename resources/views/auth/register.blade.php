@extends('layouts.auth')

@section('auth-content')
<div class="text-center mb-8">
    <h2 class="text-2xl font-bold text-white mb-2">Dołącz do nas</h2>
    <p class="text-slate-400 text-sm">Rozpocznij swoją podróż w 3 minuty.</p>
</div>

<form method="POST" action="{{ route('register') }}" class="space-y-5">
    @csrf
    
    <div>
        <label for="name" class="block text-sm font-medium text-slate-300 mb-1">Nazwa użytkownika</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-regular fa-user text-slate-400"></i>
            </div>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full bg-slate-900/50 border border-slate-700 rounded-xl py-3 pl-10 pr-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300">
        </div>
        @error('name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-slate-300 mb-1">Adres e-mail</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-regular fa-envelope text-slate-400"></i>
            </div>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full bg-slate-900/50 border border-slate-700 rounded-xl py-3 pl-10 pr-4 text-white focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300">
        </div>
        @error('email')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-slate-300 mb-1">Hasło</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-lock text-slate-400"></i>
            </div>
            <input id="password" type="password" name="password" required class="w-full bg-slate-900/50 border border-slate-700 rounded-xl py-3 pl-10 pr-4 text-white focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300">
        </div>
        @error('password')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-1">Powtórz hasło</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-lock text-slate-400"></i>
            </div>
            <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full bg-slate-900/50 border border-slate-700 rounded-xl py-3 pl-10 pr-4 text-white focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300">
        </div>
    </div>

    <div class="flex items-start">
        <div class="flex items-center h-5">
            <input id="terms" type="checkbox" name="terms" required class="w-4 h-4 rounded border-slate-700 bg-slate-900 text-primary focus:ring-primary">
        </div>
        <label for="terms" class="ml-2 block text-sm text-slate-300">
            Akceptuję <a href="#" class="text-primary hover:underline">Regulamin</a> i <a href="#" class="text-primary hover:underline">Politykę Prywatności</a>
        </label>
    </div>
    @error('terms')<p class="text-sm text-red-400">{{ $message }}</p>@enderror

    <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary hover:from-blue-600 hover:to-purple-600 text-white font-medium py-3 px-4 rounded-xl shadow-lg transform transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
        Utwórz konto
    </button>
</form>

<div class="mt-6 text-center text-sm text-slate-400">
    Masz już konto? <a href="{{ route('login') }}" class="font-medium text-primary hover:text-secondary transition-colors duration-300">Zaloguj się</a>
</div>
@endsection
