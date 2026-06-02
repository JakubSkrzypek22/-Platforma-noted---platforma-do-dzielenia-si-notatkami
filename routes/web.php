<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\NoteController;

/*
|--------------------------------------------------------------------------
| Web Routes - Platforma do dzielenia się notatkami (Open Model OLX/Vinted)
|--------------------------------------------------------------------------
*/

// ==========================================
// TRASY PUBLICZNE (Dostępne dla każdego)
// ==========================================

// Główna strona katalogu notatek (strona startowa)
Route::get('/', [NoteController::class, 'index'])->name('home');

// Wyszukiwanie notatek
Route::get('/search', function () {
    return "Wyniki wyszukiwania...";
})->name('notes.search');

// Filtrowanie notatek według kategorii
Route::get('/categories/{category}', function ($category) {
    return "Notatki z kategorii: " . $category;
})->name('categories.show');


// ==========================================
// TRASY REJESTRACJI I LOGOWANIA (Tylko dla gości)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


// ==========================================
// TRASY ZABEZPIECZONE (Wymagają zalogowania)
// ==========================================
Route::middleware('auth')->group(function () {
    // Wylogowanie
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Panel użytkownika (Dashboard)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tworzenie notatki (formularz + zapis pliku)
    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');

    // Proces zakupu (symulowana płatność)
    Route::get('/notes/{note}/checkout', [NoteController::class, 'checkout'])->name('notes.checkout');
    Route::post('/notes/{note}/checkout', [NoteController::class, 'processPayment'])->name('notes.payment');

    // Pobranie pełnego pliku (po zakupie / autor / darmowe)
    Route::get('/notes/{note}/download', [NoteController::class, 'download'])->name('notes.download');

    // Ocena sprzedawcy po zakupie
    Route::post('/notes/{note}/reviews', [NoteController::class, 'storeReview'])->name('notes.reviews.store');

    // Zaplecze geograficzne (Istniejące trasy z layoutu)
    Route::get('/countries', [CountryController::class, 'index'])->name('countries');
    Route::get('/trips', [TripController::class, 'index'])->name('trips');

    Route::middleware('can:admin')->group(function () {
        Route::post('/trips', [TripController::class, 'store'])->name('trips.store');
    });
});


// ==========================================
// PODGLĄD I SZCZEGÓŁY NOTATKI (publiczne, na końcu z uwagi na {note})
// ==========================================

// Podgląd 1. strony (dla gościa rozmyty po stronie widoku)
Route::get('/notes/{note}/preview', [NoteController::class, 'preview'])->name('notes.preview');

// Szczegóły konkretnej notatki
Route::get('/notes/{note}', [NoteController::class, 'show'])->whereNumber('note')->name('notes.show');
