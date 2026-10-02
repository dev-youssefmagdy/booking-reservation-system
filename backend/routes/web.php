<?php

use App\Http\Controllers\Central\PlanController;
use App\Http\Controllers\Central\SubscriptionController;
use App\Http\Controllers\Central\TenantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('central')->middleware(['central.auth'])->name('central.')->group(function () {
    Route::resource('tenants', TenantController::class);
    Route::post('tenants/{tenant}/suspend', [TenantController::class, 'suspend'])->name('tenants.suspend');
    Route::post('tenants/{tenant}/reactivate', [TenantController::class, 'reactivate'])->name('tenants.reactivate');
    Route::post('tenants/{tenant}/impersonate', [TenantController::class, 'impersonate'])->name('tenants.impersonate');
    Route::resource('plans', PlanController::class);
    Route::resource('subscriptions', SubscriptionController::class);
});
