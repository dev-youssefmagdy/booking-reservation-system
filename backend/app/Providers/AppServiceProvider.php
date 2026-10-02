<?php

namespace App\Providers;

use App\Events\BookingConfirmed;
use App\Events\BookingCreated;
use App\Listeners\GenerateInvoiceOnBooking;
use App\Listeners\SendBookingConfirmationNotification;
use App\Listeners\UpdateResourceAvailability;
use Illuminate\Support\Facades\Event;
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
        Event::listen(BookingCreated::class, SendBookingConfirmationNotification::class);
        Event::listen(BookingCreated::class, UpdateResourceAvailability::class);
        Event::listen(BookingConfirmed::class, GenerateInvoiceOnBooking::class);
    }
}
