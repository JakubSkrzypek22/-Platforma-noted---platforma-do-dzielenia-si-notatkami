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

// Strony informacyjne
Route::view('/o-nas', 'pages.about')->name('about');
Route::view('/kontakt', 'pages.contact')->name('contact');

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

    // Profil użytkownika (notatki / zakupy / ulubione)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tworzenie i zarządzanie notatkami
    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->whereNumber('note')->name('notes.edit');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->whereNumber('note')->name('notes.update');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->whereNumber('note')->name('notes.destroy');
    Route::delete('/notes/{note}/files/{file}', [NoteController::class, 'destroyFile'])->name('notes.files.destroy');

    // Ulubione
    Route::post('/notes/{note}/favorite', [NoteController::class, 'toggleFavorite'])->name('notes.favorite');

    // Proces zakupu (płatność Stripe)
    Route::get('/notes/{note}/checkout', [NoteController::class, 'checkout'])->name('notes.checkout');
    Route::post('/notes/{note}/checkout', [NoteController::class, 'processPayment'])->name('notes.payment');
    Route::get('/notes/{note}/payment/success', [NoteController::class, 'paymentSuccess'])->whereNumber('note')->name('notes.payment.success');

    // Pobranie pełnej zawartości (po zakupie / autor / darmowe)
    Route::get('/notes/{note}/download', [NoteController::class, 'download'])->name('notes.download');

    // Ocena sprzedawcy po zakupie
    Route::post('/notes/{note}/reviews', [NoteController::class, 'storeReview'])->name('notes.reviews.store');

    // Zaplecze geograficzne (pozostałości z poprzedniego projektu — niewidoczne w nawigacji)
    Route::get('/countries', [CountryController::class, 'index'])->name('countries');
    Route::get('/trips', [TripController::class, 'index'])->name('trips');

    Route::middleware('can:admin')->group(function () {
        Route::post('/trips', [TripController::class, 'store'])->name('trips.store');
    });
});


// ==========================================
// PODGLĄD / PLIKI / SZCZEGÓŁY NOTATKI (publiczne — na końcu z uwagi na {note})
// ==========================================

// Podgląd okładki (dla gościa rozmyty po stronie widoku)
Route::get('/notes/{note}/preview', [NoteController::class, 'preview'])->name('notes.preview');
Route::get('/notes/{note}/cover', [NoteController::class, 'cover'])->name('notes.cover');

// Streamowanie konkretnego pliku (dostęp kontrolowany w kontrolerze)
Route::get('/notes/{note}/files/{file}', [NoteController::class, 'file'])->name('notes.files.show');

// Szczegóły konkretnej notatki
Route::get('/notes/{note}', [NoteController::class, 'show'])->whereNumber('note')->name('notes.show');
