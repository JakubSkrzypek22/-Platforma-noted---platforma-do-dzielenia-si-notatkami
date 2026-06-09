@extends('layouts.app')

@section('content')
@include('shared.navbar')

<main class="flex-grow py-8 bg-slate-50 dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3 text-red-500">
                <i class="bi bi-people-fill text-4xl"></i>
                <div>
                    <h1 class="text-2xl font-bold text-text-body">Użytkownicy</h1>
                    <p class="text-sm text-slate-500">Zarządzaj kontami na platformie</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.index') }}" class="px-5 py-2.5 bg-white border border-border text-slate-700 hover:bg-slate-50 font-bold rounded-xl transition-colors">Notatki</a>
                <a href="{{ route('admin.users') }}" class="px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-md">Użytkownicy</a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-100 text-emerald-700 rounded-xl font-bold">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-xl font-bold">{{ session('error') }}</div>
        @endif

        <div class="bg-card-bg border border-border rounded-2xl overflow-hidden shadow-sm">
            <table class="w-full text-left text-sm text-slate-500 dark:text-slate-400">
                <thead class="bg-slate-100 dark:bg-slate-800 text-xs uppercase text-slate-700 dark:text-slate-300">
                    <tr>
                        <th class="px-6 py-4">Użytkownik</th>
                        <th class="px-6 py-4">Adres Email</th>
                        <th class="px-6 py-4 text-center">Aktywność</th>
                        <th class="px-6 py-4 text-center">Status VIP</th>
                        <th class="px-6 py-4 text-right">Akcje</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach ($users as $user)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-text-body flex items-center gap-2">
                                    {{ $user->name }} 
                                    @if($user->isAdmin())
                                        <span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded uppercase">Admin</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="block font-bold">{{ $user->notes_count }} notatek</span>
                                <span class="text-xs text-slate-400">{{ $user->purchases_count }} zakupów</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($user->is_vip)
                                    <span class="inline-flex items-center gap-1 text-amber-500 font-bold bg-amber-100 px-3 py-1 rounded-full text-xs">
                                        <i class="bi bi-star-fill"></i> VIP
                                    </span>
                                @else
                                    <span class="text-slate-400 text-xs font-semibold">Standard</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-2">
                                <form action="{{ route('admin.users.vip', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-3 py-1.5 {{ $user->is_vip ? 'bg-amber-100 text-amber-600 hover:bg-amber-200' : 'bg-slate-100 text-slate-600 hover:bg-amber-100 hover:text-amber-600' }} rounded-lg transition-colors font-semibold" title="Zmień status VIP">
                                        <i class="bi bi-star"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Na pewno usunąć tego użytkownika? Wszystkie jego notatki również mogą zostać usunięte!');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1.5 bg-red-100 text-red-600 hover:bg-red-500 hover:text-white rounded-lg transition-colors font-semibold" {{ $user->isAdmin() ? 'disabled' : '' }}>
                                        <i class="bi bi-person-x"></i>
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