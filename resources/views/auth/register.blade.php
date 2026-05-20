@extends('layouts.auth')

@section('auth-content')
<div class="text-center mb-4">
    <h2 class="h4 fw-bold text-body mb-1">Dołącz do nas!</h2>
    <p class="text-secondary small">Zarejestruj się, aby dzielić się notatkami studenckimi.</p>
</div>

<form method="POST" action="{{ route('register') }}" class="vstack gap-3">
    @csrf
    
    <div>
        <label for="name" class="form-label small fw-bold text-body">Nazwa użytkownika</label>
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-secondary"><i class="bi bi-person"></i></span>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="form-control border-start-0 ps-0" placeholder="np. JanKowalski">
        </div>
        @error('name')
            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="form-label small fw-bold text-body">Adres e-mail</label>
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-secondary"><i class="bi bi-envelope"></i></span>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-control border-start-0 ps-0" placeholder="nazwa@uczelnia.edu.pl">
        </div>
        @error('email')
            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="form-label small fw-bold text-body">Hasło</label>
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-secondary"><i class="bi bi-lock"></i></span>
            <input id="password" type="password" name="password" required class="form-control border-start-0 ps-0" placeholder="••••••••">
        </div>
        @error('password')
            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="form-label small fw-bold text-body">Powtórz hasło</label>
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-secondary"><i class="bi bi-lock-fill"></i></span>
            <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control border-start-0 ps-0" placeholder="••••••••">
        </div>
    </div>

    <div class="form-check my-2">
        <input id="terms" type="checkbox" name="terms" required class="form-check-input">
        <label for="terms" class="form-check-label small text-secondary">
            Akceptuję <a href="#" class="text-primary text-decoration-none fw-bold">Regulamin</a> i <a href="#" class="text-primary text-decoration-none fw-bold">Politykę Prywatności</a>
        </label>
        @error('terms')
            <p class="mt-1 text-sm text-danger d-block">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold shadow mt-2">
        Utwórz konto
    </button>
</form>

<div class="mt-4 text-center small text-secondary">
    Masz już konto? 
    <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-bold">Zaloguj się</a>
</div>
@endsection
