@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden bg-darker">
    
    <!-- Sidebar -->
    <aside class="w-64 glass border-r border-slate-800 hidden md:flex flex-col relative z-20">
        <div class="h-16 flex items-center px-6 border-b border-slate-800">
            <h1 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">Platforma noted</h1>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-primary/20 text-primary border border-primary/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-house w-6"></i>
                <span class="font-medium">Pulpit</span>
            </a>
            <a href="{{ route('trips') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('trips*') ? 'bg-primary/20 text-primary border border-primary/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-book-open w-6"></i>
                <span class="font-medium">Moje Notatki</span>
            </a>
            <a href="{{ route('countries') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('countries*') ? 'bg-primary/20 text-primary border border-primary/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-graduation-cap w-6"></i>
                <span class="font-medium">Przedmioty</span>
            </a>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 transition-colors">
                    <i class="fa-solid fa-right-from-bracket w-6"></i>
                    <span class="font-medium">Wyloguj się</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col relative z-10 h-full overflow-hidden">
        <!-- Background Glow -->
        <div class="absolute top-0 right-0 w-[50%] h-[50%] rounded-full bg-primary/5 blur-[150px] pointer-events-none"></div>
        
        <!-- Topbar -->
        <header class="h-16 glass border-b border-slate-800 flex items-center justify-between px-6 z-20">
            <div class="flex items-center md:hidden">
                <span class="text-xl font-bold text-white">Platforma noted</span>
            </div>
            <div class="hidden md:block text-slate-300 font-medium">
                Witaj, {{ Auth::user()->name ?? 'Podróżniku' }}!
            </div>
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-secondary p-[2px]">
                    <div class="w-full h-full rounded-full bg-dark flex items-center justify-center">
                        <i class="fa-regular fa-user text-slate-300"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 scroll-smooth">
            <div class="max-w-7xl mx-auto">
                @yield('dashboard-content')
            </div>
        </main>
    </div>
</div>
@endsection
