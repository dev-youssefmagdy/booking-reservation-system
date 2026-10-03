<?php

namespace App\Providers;

use App\Events\BookingConfirmed;
use App\Events\BookingCreated;
use App\Events\PaymentReceived;
use App\Listeners\GenerateInvoiceOnBooking;
use App\Listeners\PostBookingRevenueJournal;
use App\Listeners\PostPaymentJournal;
use App\Listeners\SendBookingConfirmationNotification;
use App\Listeners\UpdateResourceAvailability;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request): Limit {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        Event::listen(BookingCreated::class, SendBookingConfirmationNotification::class);
        Event::listen(BookingCreated::class, UpdateResourceAvailability::class);
        Event::listen(BookingConfirmed::class, GenerateInvoiceOnBooking::class);
        Event::listen(BookingConfirmed::class, PostBookingRevenueJournal::class);
        Event::listen(PaymentReceived::class, PostPaymentJournal::class);
    }
}
