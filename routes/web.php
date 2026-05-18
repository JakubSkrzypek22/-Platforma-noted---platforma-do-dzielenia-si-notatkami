<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\NoteController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes (Guests only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes (Logged in users)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Subjects
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects');
    
    // Notes
    Route::get('/notes', [NoteController::class, 'index'])->name('notes');
    
    // Admin routes (Example middleware placeholder for admin role)
    Route::middleware('can:admin')->group(function () {
        Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    });
});
