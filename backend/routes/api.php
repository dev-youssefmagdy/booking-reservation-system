<?php

declare(strict_types=1);

use App\Http\Controllers\Api\StripeWebhookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public Webhooks (no auth)
Route::post('webhooks/stripe', [StripeWebhookController::class, 'handleWebhook'])->name('webhooks.stripe');
