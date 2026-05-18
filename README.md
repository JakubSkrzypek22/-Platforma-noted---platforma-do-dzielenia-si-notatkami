# Platforma noted 📚

Platforma do dzielenia się notatkami akademickimi, zbudowana na **Laravel 13**.

---

## 🌿 Gałęzie projektu

| Gałąź | Opis |
|-------|------|
| `main` | Wersja Jannka – architektura Trips/Countries (podróże, kraje) |
| `jannek` | Wersja Jakuba – architektura Notes/Subjects (notatki, przedmioty) |

---

## 🚀 Jak zacząć (dla każdego członka zespołu)

### 1. Sklonuj repozytorium
```bash
git clone https://github.com/JakubSkrzypek22/-Platforma-noted---platforma-do-dzielenia-si-notatkami.git
cd "-Platforma-noted---platforma-do-dzielenia-si-notatkami"
```

### 2. Przełącz się na odpowiednią gałąź

Wersja Jakuba (Notatki):
```bash
git checkout jannek
```
Wersja Jannka (Wycieczki):
```bash
git checkout main
```

### 3. Zainstaluj zależności PHP
```bash
composer install
```

### 4. Skonfiguruj plik środowiskowy
```bash
copy .env.example .env
php artisan key:generate
```

### 5. Zbuduj bazę danych i wypełnij danymi testowymi
```bash
php artisan migrate:fresh --seed
```

### 6. Uruchom serwer deweloperski
```bash
php artisan serve
```

Aplikacja będzie dostępna pod adresem: **http://localhost:8000**

---

## 🔐 Konta testowe

### Gałąź `jannek` (architektura Notes/Subjects)

| Email | Hasło | Rola |
|-------|-------|------|
| `jan@email.com` | `1234` | Admin |
| `marta@email.com` | `1234` | User |
| `pawel@email.com` | `1234` | User |

### Gałąź `main` (architektura Trips/Countries)

| Email | Hasło | Rola |
|-------|-------|------|
| `jan@email.com` | `1234` | Admin |
| `siuhun@email.com` | `1234` | User |
| `marta@email.com` | `1234` | User |

---

## 🛠 Wymagania

- PHP 8.2+
- Composer
- SQLite (domyślnie, bez dodatkowej konfiguracji)

---

## 📁 Architektura projektu

```
app/
├── Http/
│   ├── Controllers/       # AuthController, DashboardController, NoteController...
│   └── Middleware/        # RoleMiddleware
├── Models/                # User, Role, Note, Subject (lub Trip, Country)
database/
├── migrations/            # Struktura tabel
└── seeders/               # Dane testowe
resources/views/
├── layouts/               # app, auth, dashboard blade layouts
├── auth/                  # login, register
├── dashboard/             # panel główny
├── notes/ lub trips/      # lista materiałów
└── subjects/ lub countries/ # lista kategorii
routes/
└── web.php                # Routing aplikacji
```
