<?php

use App\Http\Controllers\Central\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('central')->name('central.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
