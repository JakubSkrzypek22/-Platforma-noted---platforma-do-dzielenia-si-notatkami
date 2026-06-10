@extends('layouts.app')

@section('content')
@include('shared.navbar')

<main class="flex-grow py-8 theme-page">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div class="flex items-center gap-3">
                <i class="bi bi-people-fill text-4xl text-red-500"></i>
                <div>
                    <h1 class="text-2xl font-bold text-text-body">Użytkownicy</h1>
                    <p class="text-sm text-muted-theme">Zarządzaj kontami na platformie</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.index') }}" class="admin-nav-tab">Notatki</a>
                <a href="{{ route('admin.users') }}" class="admin-nav-tab is-active">Użytkownicy</a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl font-bold alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 rounded-xl font-bold alert-error">{{ session('error') }}</div>
        @endif

        <div class="admin-card">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Użytkownik</th>
                        <th>Adres Email</th>
                        <th class="text-center">Aktywność</th>
                        <th class="text-center">Status VIP</th>
                        <th class="text-right">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <div class="cell-primary flex items-center gap-2">
                                    {{ $user->name }}
                                    @if($user->isAdmin())
                                        <span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded uppercase">Admin</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                <span class="block cell-primary">{{ $user->notes_count }} notatek</span>
                                <span class="text-xs text-subtle-theme">{{ $user->purchases_count }} zakupów</span>
                            </td>
                            <td class="text-center">
                                @if($user->is_vip)
                                    <span class="vip-badge"><i class="bi bi-star-fill"></i> VIP</span>
                                @else
                                    <span class="text-subtle-theme text-xs font-semibold">Standard</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <form action="{{ route('admin.users.vip', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-action btn-action-vip"
                                                title="{{ $user->is_vip ? 'Odbierz status VIP' : 'Nadaj status VIP' }}">
                                            <i class="bi {{ $user->is_vip ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Na pewno usunąć tego użytkownika? Wszystkie jego notatki również mogą zostać usunięte!');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-action-danger"
                                                title="{{ $user->isAdmin() ? 'Nie można usunąć administratora' : 'Usuń użytkownika' }}"
                                                {{ $user->isAdmin() ? 'disabled' : '' }}>
                                            <i class="bi bi-person-x"></i>
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
