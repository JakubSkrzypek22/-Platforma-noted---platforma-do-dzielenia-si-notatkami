@extends('layouts.app')

@section('content')
@include('shared.navbar')

<main class="flex-grow py-8 bg-slate-50 dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3 text-red-500">
                <i class="bi bi-shield-lock-fill text-4xl"></i>
                <div>
                    <h1 class="text-2xl font-bold text-text-body">Panel Administratora</h1>
                    <p class="text-sm text-slate-500">Zarządzanie platformą Noted</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.index') }}" class="px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-md">Notatki</a>
                <a href="{{ route('admin.users') }}" class="px-5 py-2.5 bg-white border border-border text-slate-700 hover:bg-slate-50 font-bold rounded-xl transition-colors">Użytkownicy</a>
            </div>
        </div>

        @if(!auth()->check() || !auth()->user()->isVip())
        <div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-3xl p-6 md:p-8 shadow-xl text-white flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden group mb-8">
            <div class="absolute -right-10 -bottom-10 text-white/10 text-9xl transform rotate-12 transition-transform group-hover:scale-110 duration-500 pointer-events-none">
                <i class="bi bi-crown-fill"></i>
            </div>
            
            <div class="z-10 text-center md:text-left">
                <h3 class="text-xl md:text-2xl font-black mb-2 flex items-center justify-center md:justify-start gap-2">
                    <i class="bi bi-crown-fill"></i> Zyskaj potężne przywileje z kontem Noted VIP!
                </h3>
                <p class="text-white/80 text-sm max-w-xl leading-relaxed">
                    Chcesz zarabiać więcej? Aktywuj pakiet VIP: sprzedawaj swoje notatki z <strong>prowizją 0%</strong>, pozycjonuj swoje materiały zawsze na górze listy i zdobądź unikalną złotą odznakę.
                </p>
            </div>
            
            <a href="{{ route('vip.index') }}" class="z-10 bg-white text-amber-600 font-extrabold px-6 py-3.5 rounded-xl shadow-md hover:bg-amber-50 hover:scale-105 transition-all text-sm whitespace-nowrap cursor-pointer">
                Sprawdź ofertę VIP <i class="bi bi-arrow-right ml-1"></i>
            </a>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-card-bg border border-border rounded-2xl p-6 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xl"><i class="bi bi-people-fill"></i></div>
                <div>
                    <div class="text-2xl font-black text-text-body">{{ $usersCount ?? 0 }}</div>
                    <div class="text-xs text-slate-500 uppercase font-bold tracking-wider">Zarejestrowanych</div>
                </div>
            </div>
            <div class="bg-card-bg border border-border rounded-2xl p-6 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl"><i class="bi bi-journal-text"></i></div>
                <div>
                    <div class="text-2xl font-black text-text-body">{{ $notesCount ?? 0 }}</div>
                    <div class="text-xs text-slate-500 uppercase font-bold tracking-wider">Wgranych notatek</div>
                </div>
            </div>
            <div class="bg-card-bg border border-border rounded-2xl p-6 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-xl"><i class="bi bi-cash-coin"></i></div>
                <div>
                    <div class="text-2xl font-black text-text-body">{{ isset($totalRevenue) ? number_format($totalRevenue, 2, ',', ' ') : '0,00' }} zł</div>
                    <div class="text-xs text-slate-500 uppercase font-bold tracking-wider">Obrót platformy</div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-100 text-emerald-700 rounded-xl font-bold">{{ session('success') }}</div>
        @endif

        <div class="bg-card-bg border border-border rounded-2xl overflow-hidden shadow-sm">
            <div class="p-5 border-b border-border bg-slate-50 dark:bg-slate-800">
                <h2 class="font-bold text-lg text-text-body">Baza Notatek</h2>
            </div>
            <table class="w-full text-left text-sm text-slate-500 dark:text-slate-400">
                <thead class="bg-slate-100 dark:bg-slate-800 text-xs uppercase text-slate-700 dark:text-slate-300">
                    <tr>
                        <th class="px-6 py-4">Tytuł notatki</th>
                        <th class="px-6 py-4">Kategoria</th>
                        <th class="px-6 py-4">Cena</th>
                        <th class="px-6 py-4">Autor</th>
                        <th class="px-6 py-4 text-right">Akcje</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach ($notes as $note)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-text-body">{{ $note->title }}</td>
                            <td class="px-6 py-4">{{ $note->category }}</td>
                            <td class="px-6 py-4 font-bold text-primary">{{ $note->isFree() ? 'Darmowe' : $note->price . ' zł' }}</td>
                            <td class="px-6 py-4">{{ $note->author->name ?? 'Konto usunięte' }}</td>
                            <td class="px-6 py-4 text-right flex justify-end gap-2">
                                <a href="{{ route('notes.show', $note) }}" target="_blank" class="px-3 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-lg transition-colors font-semibold">
                                    <i class="bi bi-eye"></i> Podgląd
                                </a>
                                <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Trwale usunąć notatkę?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1.5 bg-red-100 text-red-600 hover:bg-red-500 hover:text-white rounded-lg transition-colors font-semibold">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>
@include('shared.footer')
@endsection