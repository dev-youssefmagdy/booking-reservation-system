<?php

declare(strict_types=1);

use App\Http\Controllers\Central\Auth\LoginController;
use App\Http\Middleware\Central\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Central Admin — Authentication (guest)
Route::prefix('central')->name('central.')->group(function (): void {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Central Admin — Protected routes
Route::prefix('central')->name('central.')->middleware(AuthMiddleware::class)->group(function (): void {
    Route::get('/dashboard', fn () => view('welcome'))->name('dashboard');
    Route::get('/profile', fn () => view('welcome'))->name('profile');

    // Tenants
    Route::get('/tenants', fn () => view('welcome'))->name('tenants.index');

    // Plans
    Route::get('/plans', fn () => view('welcome'))->name('plans.index');

    // Settings
    Route::get('/settings', fn () => view('welcome'))->name('settings.index');
});
