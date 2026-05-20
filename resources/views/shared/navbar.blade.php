<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">
    <div class="container-fluid">
      <a class="navbar-brand fw-extrabold d-flex align-items-center" href="{{ url('/') }}">
        <span class="fs-4 me-2">📚</span>
        <span class="fw-bold bg-gradient-to-r from-primary to-secondary bg-clip-text">Notet</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link @if (request()->is('/')) active @endif" href="{{ url('/') }}">
                    <i class="bi bi-house-door me-1"></i> Panel Główny
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (str_contains(request()->path(), 'trips')) active @endif"
                    href="{{ route('trips') }}">
                    <i class="bi bi-journal-text me-1"></i> Baza Notatek
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (str_contains(request()->path(), 'countries')) active @endif"
                    href="{{ route('countries') }}">
                    <i class="bi bi-mortarboard me-1"></i> Przedmioty
                </a>
            </li>
        </ul>
        <ul id="navbar-user" class="navbar-nav mb-2 mb-lg-0 align-items-lg-center">
            <!-- Premium Theme Switcher Dropdown -->
            <li class="nav-item dropdown me-3">
                <button class="btn nav-link dropdown-toggle d-flex align-items-center" id="themeDropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i id="theme-icon-active" class="bi bi-circle-half me-2"></i>
                    <span id="theme-text-active">Motyw</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-1" aria-labelledby="themeDropdown">
                    <li>
                        <button class="dropdown-item d-flex align-items-center" data-theme-value="light" onclick="setTheme('light')">
                            <i class="bi bi-sun-fill me-2"></i> Jasny
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center" data-theme-value="dark" onclick="setTheme('dark')">
                            <i class="bi bi-moon-stars-fill me-2"></i> Ciemny
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center" data-theme-value="beige" onclick="setTheme('beige')">
                            <i class="bi bi-palette-fill me-2"></i> Kremowy
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center" data-theme-value="system" onclick="setTheme('system')">
                            <i class="bi bi-laptop me-2"></i> Systemowy
                        </button>
                    </li>
                </ul>
            </li>

            <!-- Authentication Links -->
            @if (Auth::check())
                <li class="nav-item">
                    <span class="navbar-text me-2 text-secondary">Witaj, {{ Auth::user()->name }}</span>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i> Wyloguj się
                        </button>
                    </form>
                </li>
            @else
                <li class="nav-item">
                    <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Zaloguj się
                    </a>
                </li>
            @endif
        </ul>
      </div>
      @include('shared.success-toast')
    </div>
  </nav>
