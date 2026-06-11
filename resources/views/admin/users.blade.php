@extends('layouts.app')

@section('content')
@include('shared.navbar')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 text-sm font-semibold shadow-sm">
            <i class="bi bi-check-circle-fill text-lg"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl flex items-center gap-3 text-sm font-semibold shadow-sm">
            <i class="bi bi-exclamation-triangle-fill text-lg"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="bg-blue-100 dark:bg-blue-900/30 p-3.5 rounded-2xl border border-blue-200 dark:border-blue-800">
                <i class="bi bi-people-fill text-blue-600 dark:text-blue-500 text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900 dark:text-white">Użytkownicy</h1>
                <p class="text-sm text-slate-500 font-medium">Zarządzaj kontami na platformie</p>
            </div>
        </div>
        <div class="flex gap-3 bg-slate-100 dark:bg-slate-800 p-1 rounded-xl border border-slate-200 dark:border-slate-700">
            <a href="{{ route('admin.index') }}" class="px-5 py-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white rounded-lg text-sm font-semibold transition-all">Notatki</a>
            <a href="{{ route('admin.users') }}" class="px-5 py-2 bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-sm rounded-lg text-sm font-bold transition-all">Użytkownicy</a>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
        <div class="p-6 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="bi bi-person-lines-fill"></i> Lista zarejestrowanych osób
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 dark:text-slate-400 text-[11px] font-bold uppercase tracking-widest border-b border-slate-200 dark:border-slate-700">
                        <th class="p-4 pl-6">Użytkownik</th>
                        <th class="p-4">Adres Email</th>
                        <th class="p-4">Aktywność</th>
                        <th class="p-4">Status VIP</th>
                        <th class="p-4 pr-6 text-right">Akcje</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                        
                        <td class="p-4 pl-6">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-slate-900 dark:text-white">
                                    {{ $user->name }}
                                </span>
                                @if(method_exists($user, 'isAdmin') && $user->isAdmin())
                                    <span class="px-2 py-0.5 bg-red-600 text-white text-[10px] font-black rounded-md">ADMIN</span>
                                @endif
                            </div>
                        </td>
                        
                        <td class="p-4 text-sm font-medium text-slate-600 dark:text-slate-400">
                            {{ $user->email }}
                        </td>

                        <td class="p-4">
                            <div class="flex flex-col gap-1 text-xs text-slate-500 font-medium">
                                <span><i class="bi bi-file-earmark-text mr-1"></i> {{ $user->notes_count ?? 0 }} notatek</span>
                                <span><i class="bi bi-cart-check mr-1"></i> {{ $user->purchases_count ?? 0 }} zakupów</span>
                            </div>
                        </td>
                        
                        <td class="p-4">
                            @if($user->is_vip)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    <i class="bi bi-crown-fill mr-1"></i> VIP
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                    Standard
                                </span>
                            @endif
                        </td>
                        
                        <td class="p-4 pr-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                
                                <form action="{{ route('admin.users.vip', $user) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('PATCH')
                                    @if($user->is_vip)
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition-colors" title="Odbierz status VIP">
                                            <i class="bi bi-star"></i> Zdejmij VIP
                                        </button>
                                    @else
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-xs font-bold transition-colors" title="Nadaj status VIP">
                                            <i class="bi bi-star-fill"></i> Daj VIP
                                        </button>
                                    @endif
                                </form>
                                
                                @if(! (method_exists($user, 'isAdmin') && $user->isAdmin()) )
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="m-0" onsubmit="return confirm('Czy na pewno chcesz usunąć tego użytkownika?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors" title="Usuń użytkownika">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                                @else
                                <div class="w-8 h-8 flex items-center justify-center text-slate-300" title="Nie można usunąć admina">
                                    <i class="bi bi-shield-lock-fill"></i>
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-500">
                            <i class="bi bi-people text-4xl block mb-2 opacity-50"></i>
                            Brak zarejestrowanych użytkowników.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('shared.footer')
@endsection