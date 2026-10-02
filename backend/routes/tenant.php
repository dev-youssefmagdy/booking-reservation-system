<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\Auth\LoginController;
use App\Http\Controllers\Tenant\Auth\PasswordResetController;
use App\Http\Controllers\Tenant\BookingController;
use App\Http\Controllers\Tenant\Customer\LeadController;
use App\Http\Controllers\Tenant\CustomerController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\Staff\AttendanceController;
use App\Http\Controllers\Tenant\Staff\LeaveController;
use App\Http\Controllers\Tenant\Staff\ScheduleController;
use App\Http\Controllers\Tenant\StaffController;
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

        // Customers CRM
        Route::resource('customers', CustomerController::class)->names('tenant.customers');
        Route::post('customers/{customer}/blacklist', [CustomerController::class, 'blacklist'])->name('tenant.customers.blacklist');
        Route::post('customers/{customer}/remove-blacklist', [CustomerController::class, 'removeBlacklist'])->name('tenant.customers.remove-blacklist');
        Route::post('customers/{customer}/notes', [CustomerController::class, 'addNote'])->name('tenant.customers.notes.store');
        Route::get('customers-blacklisted', [CustomerController::class, 'blacklistView'])->name('tenant.customers.blacklist.view');

        // Leads
        Route::resource('leads', LeadController::class)->names('tenant.leads');
        Route::post('leads/{lead}/convert', [LeadController::class, 'convert'])->name('tenant.leads.convert');

        // Staff
        Route::resource('staff', StaffController::class)->names('tenant.staff');
        Route::post('staff/{staff}/clock-in', [StaffController::class, 'clockIn'])->name('tenant.staff.clock-in');
        Route::post('staff/{staff}/clock-out', [StaffController::class, 'clockOut'])->name('tenant.staff.clock-out');
        Route::get('staff/{staff}/schedule', [ScheduleController::class, 'index'])->name('tenant.staff.schedule');
        Route::post('staff/{staff}/schedule', [ScheduleController::class, 'update'])->name('tenant.staff.schedule.update');

        // Leave Requests
        Route::get('leave', [LeaveController::class, 'index'])->name('tenant.leave.index');
        Route::post('leave', [LeaveController::class, 'store'])->name('tenant.leave.store');
        Route::post('leave/{leave}/approve', [LeaveController::class, 'approve'])->name('tenant.leave.approve');
        Route::post('leave/{leave}/reject', [LeaveController::class, 'reject'])->name('tenant.leave.reject');

        // Attendance
        Route::get('attendance', [AttendanceController::class, 'index'])->name('tenant.attendance.index');
        Route::get('staff/{staff}/attendance-report', [AttendanceController::class, 'report'])->name('tenant.staff.attendance-report');

        // Finance
        Route::get('/finance', fn () => 'Finance')->name('tenant.finance.index');

        // Reports
        Route::get('/reports', fn () => 'Reports')->name('tenant.reports.index');

        // Settings
        Route::get('/settings', fn () => 'Settings')->name('tenant.settings.index');
    });
});
