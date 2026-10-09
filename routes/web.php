<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    // Rutas de los CRUDs generados con make:crud
    Route::resource('clients', ClientController::class);
});
