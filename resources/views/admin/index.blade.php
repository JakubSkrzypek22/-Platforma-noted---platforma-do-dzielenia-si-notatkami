@extends('layouts.app')

@section('content')
@include('shared.navbar')

<main class="flex-grow py-8 theme-page">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div class="flex items-center gap-3">
                <i class="bi bi-shield-lock-fill text-4xl text-red-500"></i>
                <div>
                    <h1 class="text-2xl font-bold text-text-body">Panel Administratora</h1>
                    <p class="text-sm text-muted-theme">Zarządzanie platformą Noted</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.index') }}" class="admin-nav-tab is-active">Notatki</a>
                <a href="{{ route('admin.users') }}" class="admin-nav-tab">Użytkownicy</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="admin-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full stat-icon-blue flex items-center justify-center text-xl"><i class="bi bi-people-fill"></i></div>
                <div>
                    <div class="text-2xl font-black text-text-body">{{ $usersCount ?? 0 }}</div>
                    <div class="text-xs text-muted-theme uppercase font-bold tracking-wider">Zarejestrowanych</div>
                </div>
            </div>
            <div class="admin-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full stat-icon-green flex items-center justify-center text-xl"><i class="bi bi-journal-text"></i></div>
                <div>
                    <div class="text-2xl font-black text-text-body">{{ $notesCount ?? 0 }}</div>
                    <div class="text-xs text-muted-theme uppercase font-bold tracking-wider">Wgranych notatek</div>
                </div>
            </div>
            <div class="admin-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full stat-icon-amber flex items-center justify-center text-xl"><i class="bi bi-cash-coin"></i></div>
                <div>
                    <div class="text-2xl font-black text-text-body">{{ isset($totalRevenue) ? number_format($totalRevenue, 2, ',', ' ') : '0,00' }} zł</div>
                    <div class="text-xs text-muted-theme uppercase font-bold tracking-wider">Obrót platformy</div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl font-bold alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 rounded-xl font-bold alert-error">{{ session('error') }}</div>
        @endif

        <div class="admin-card">
            <div class="p-5 border-b border-border" style="background-color: var(--color-table-head);">
                <h2 class="font-bold text-lg text-text-body">Baza Notatek</h2>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Tytuł notatki</th>
                        <th>Kategoria</th>
                        <th>Cena</th>
                        <th>Autor</th>
                        <th class="text-right">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notes as $note)
                        <tr>
                            <td class="cell-primary">{{ $note->title }}</td>
                            <td>{{ $note->category }}</td>
                            <td class="font-bold text-primary">{{ $note->isFree() ? 'Darmowe' : $note->price . ' zł' }}</td>
                            <td>{{ $note->author->name ?? 'Konto usunięte' }}</td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('notes.show', $note) }}" target="_blank" class="btn-action">
                                        <i class="bi bi-eye"></i> Podgląd
                                    </a>
                                    <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Trwale usunąć notatkę?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-action-danger" title="Usuń notatkę">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
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
