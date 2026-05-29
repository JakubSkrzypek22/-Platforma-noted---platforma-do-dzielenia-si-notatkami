<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\TripController;

/*
|--------------------------------------------------------------------------
| Web Routes - Platforma do dzielenia się notatkami (Open Model OLX/Vinted)
|--------------------------------------------------------------------------
*/

// ==========================================
// TRASY PUBLICZNE (Dostępne dla każdego)
// ==========================================

// Główna strona katalogu notatek (strona startowa)
Route::get('/', function () {
    return view('index');
})->name('home');

// Podgląd szczegółów konkretnej notatki (widok publiczny, ale pobranie/pełna treść wymaga logowania)
Route::get('/notes/{id}', function ($id) {
    return "Szczegóły notatki o ID: " . $id;
})->name('notes.show');

// Filtrowanie notatek według kategorii
Route::get('/categories/{category}', function ($category) {
    return "Notatki z kategorii: " . $category;
})->name('categories.show');

// Wyszukiwanie notatek
Route::get('/search', function () {
    return "Wyniki wyszukiwania...";
})->name('notes.search');


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
    
    // Tworzenie i zarządzanie notatkami
    Route::get('/notes/create', function () {
        return "Formularz dodawania notatki (Tylko dla zalogowanych)";
    })->name('notes.create');
    
    Route::post('/notes', function () {
        return "Zapisywanie notatki...";
    })->name('notes.store');
    
    // Polubienie/Zapisanie notatki
    Route::post('/notes/{id}/like', function ($id) {
        return "Polubiono notatkę o ID: " . $id;
    })->name('notes.like');
    
    // Pobieranie pełnej wersji notatki (PDF)
    Route::get('/notes/{id}/download', function ($id) {
        return "Pobieranie pliku PDF dla notatki o ID: " . $id;
    })->name('notes.download');

    // Zaplecze geograficzne (Istniejące trasy z layoutu)
    Route::get('/countries', [CountryController::class, 'index'])->name('countries');
    Route::get('/trips', [TripController::class, 'index'])->name('trips');
    
    Route::middleware('can:admin')->group(function () {
        Route::post('/trips', [TripController::class, 'store'])->name('trips.store');
    });
});
