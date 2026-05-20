@extends('layouts.auth')

@section('auth-content')
<div class="text-center mb-4">
    <h2 class="h4 fw-bold text-body mb-1">Witaj ponownie!</h2>
    <p class="text-secondary small">Zaloguj się, aby kontynuować naukę na platformie.</p>
</div>

<form method="POST" action="{{ route('login') }}" class="vstack gap-3">
    @csrf
    
    <div>
        <label for="email" class="form-label small fw-bold text-body">Adres e-mail</label>
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-secondary"><i class="bi bi-envelope"></i></span>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control border-start-0 ps-0" placeholder="nazwa@uczelnia.edu.pl">
        </div>
        @error('email')
            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <div class="d-flex align-items-center justify-content-between mb-1">
            <label for="password" class="form-label small fw-bold text-body mb-0">Hasło</label>
            <a href="#" class="small text-primary text-decoration-none fw-bold">Zapomniałeś?</a>
        </div>
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-secondary"><i class="bi bi-lock"></i></span>
            <input id="password" type="password" name="password" required class="form-control border-start-0 ps-0" placeholder="••••••••">
        </div>
        @error('password')
            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-check my-2">
        <input id="remember" type="checkbox" name="remember" class="form-check-input">
        <label for="remember" class="form-check-label small text-secondary">Zapamiętaj mnie</label>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold shadow mt-2">
        Zaloguj się
    </button>
</form>

<div class="mt-4 text-center small text-secondary">
    Nie masz jeszcze konta? 
    <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold">Zarejestruj się</a>
</div>
@endsection
