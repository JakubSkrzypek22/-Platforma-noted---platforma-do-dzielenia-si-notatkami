@extends('layouts.app')

@section('content')
@include('shared.navbar')

@php
    // Awaryjne pobieranie statystyk, gdyby kontroler ich nie przekazywał
    $uCount = $usersCount ?? \App\Models\User::count();
    $nCount = $notesCount ?? \App\Models\Note::count();
    $revenue = $totalRevenue ?? \App\Models\Purchase::sum('amount');
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="bg-red-100 dark:bg-red-900/30 p-3.5 rounded-2xl border border-red-200 dark:border-red-800">
                <i class="bi bi-shield-lock-fill text-red-600 dark:text-red-500 text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900 dark:text-white">Panel Administratora</h1>
                <p class="text-sm text-slate-500 font-medium">Zarządzanie platformą Noted</p>
            </div>
        </div>
        <div class="flex gap-3 bg-slate-100 dark:bg-slate-800 p-1 rounded-xl border border-slate-200 dark:border-slate-700">
            <a href="{{ route('admin.index') }}" class="px-5 py-2 bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-sm rounded-lg text-sm font-bold transition-all">Notatki</a>
            <a href="{{ route('admin.users') ?? '#' }}" class="px-5 py-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white rounded-lg text-sm font-semibold transition-all">Użytkownicy</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-700 flex items-center gap-5">
            <div class="bg-blue-50 dark:bg-blue-900/30 p-4 rounded-full text-blue-600 dark:text-blue-400">
                <i class="bi bi-people-fill text-2xl"></i>
            </div>
            <div>
                <div class="text-3xl font-black text-slate-900 dark:text-white">{{ $uCount }}</div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-1">Zarejestrowanych</div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-700 flex items-center gap-5">
            <div class="bg-emerald-50 dark:bg-emerald-900/30 p-4 rounded-full text-emerald-600 dark:text-emerald-400">
                <i class="bi bi-file-earmark-text-fill text-2xl"></i>
            </div>
            <div>
                <div class="text-3xl font-black text-slate-900 dark:text-white">{{ $nCount }}</div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-1">Wgranych notatek</div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-700 flex items-center gap-5">
            <div class="bg-amber-50 dark:bg-amber-900/30 p-4 rounded-full text-amber-600 dark:text-amber-400">
                <i class="bi bi-cash-coin text-2xl"></i>
            </div>
            <div>
                <div class="text-3xl font-black text-slate-900 dark:text-white">{{ number_format($revenue, 2, ',', ' ') }} zł</div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-1">Obrót platformy</div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
        <div class="p-6 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="bi bi-database"></i> Baza Notatek
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 dark:text-slate-400 text-[11px] font-bold uppercase tracking-widest border-b border-slate-200 dark:border-slate-700">
                        <th class="p-4 pl-6">Tytuł notatki</th>
                        <th class="p-4">Kategoria</th>
                        <th class="p-4">Cena</th>
                        <th class="p-4">Autor</th>
                        <th class="p-4 pr-6 text-right">Akcje</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($notes as $note)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                        <td class="p-4 pl-6">
                            <p class="text-sm font-bold text-slate-900 dark:text-white truncate max-w-[300px]" title="{{ $note->title }}">
                                {{ $note->title }}
                            </p>
                        </td>
                        
                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                                {{ $note->category }}
                            </span>
                        </td>
                        
                        <td class="p-4 text-sm">
                            @if($note->price > 0)
                                <span class="font-extrabold text-slate-900 dark:text-white">{{ number_format($note->price, 2, ',', ' ') }} zł</span>
                            @else
                                <span class="font-bold text-emerald-600 dark:text-emerald-400">Darmowe</span>
                            @endif
                        </td>
                        
                        <td class="p-4 text-sm font-medium text-slate-600 dark:text-slate-400">
                            {{ $note->author->name ?? 'Nieznany' }}
                        </td>
                        
                        <td class="p-4 pr-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('notes.show', $note) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-800/40 text-blue-600 dark:text-blue-300 rounded-lg text-xs font-bold transition-colors">
                                    <i class="bi bi-eye-fill"></i> Podgląd
                                </a>
                                
                                <form action="{{ route('notes.destroy', $note) }}" method="POST" class="m-0" onsubmit="return confirm('Czy na pewno chcesz bezpowrotnie usunąć tę notatkę?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-800/40 text-red-600 dark:text-red-300 rounded-lg transition-colors" title="Usuń notatkę">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-500">
                            <i class="bi bi-inbox text-4xl block mb-2 opacity-50"></i>
                            Obecnie nie ma żadnych notatek w bazie.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(method_exists($notes, 'links'))
        <div class="p-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
            {{ $notes->links() }}
        </div>
        @endif
    </div>
</div>

@include('shared.footer')
@endsection