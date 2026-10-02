<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\Auth\LoginController;
use App\Http\Controllers\Tenant\Auth\PasswordResetController;
use App\Http\Controllers\Tenant\BookingController;
use App\Http\Controllers\Tenant\DashboardController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function (): void {

    // Tenant public landing
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    });

    // Tenant Auth — Guest
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('tenant.login');
    Route::post('/login', [LoginController::class, 'login'])->name('tenant.login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('tenant.logout');

    // Password Reset
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('tenant.password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('tenant.password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('tenant.password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('tenant.password.update');

    // Tenant Admin — Protected routes
    Route::middleware('auth')->group(function (): void {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');
        Route::get('/profile', fn () => 'Profile')->name('tenant.profile');

        // Bookings
        Route::resource('bookings', BookingController::class)->names('tenant.bookings');
        Route::post('bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('tenant.bookings.confirm');
        Route::post('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('tenant.bookings.cancel');
        Route::post('bookings/{booking}/checkin', [BookingController::class, 'checkin'])->name('tenant.bookings.checkin');
        Route::post('bookings/{booking}/checkout', [BookingController::class, 'checkout'])->name('tenant.bookings.checkout');
        Route::post('bookings/{booking}/noshow', [BookingController::class, 'noshow'])->name('tenant.bookings.noshow');
        Route::get('bookings-pending', [BookingController::class, 'pending'])->name('tenant.bookings.pending');

        // Resources
        Route::get('/resources', fn () => 'Resources')->name('tenant.resources.index');

        // Customers
        Route::get('/customers', fn () => 'Customers')->name('tenant.customers.index');

        // Staff
        Route::get('/staff', fn () => 'Staff')->name('tenant.staff.index');

        // Finance
        Route::get('/finance', fn () => 'Finance')->name('tenant.finance.index');

        // Reports
        Route::get('/reports', fn () => 'Reports')->name('tenant.reports.index');

        // Settings
        Route::get('/settings', fn () => 'Settings')->name('tenant.settings.index');
    });
});
