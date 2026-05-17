<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\TripController;

Route::get('/', function () {
    return view('trips.index');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

Route::get('/countries', function () {
    return view('countries.index');
})->name('countries');

Route::get('/trips', function () {
    return view('trips.index');
})->name('trips');
