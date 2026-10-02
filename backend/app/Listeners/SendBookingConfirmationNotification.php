<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\BookingCreated;
use Illuminate\Support\Facades\Log;

class SendBookingConfirmationNotification
{
    /**
     * Handle the event.
     * Notification class will be built in AGENT-11.
     */
    public function handle(BookingCreated $event): void
    {
        $booking = $event->booking->load('customer');

        Log::info('Booking confirmation notification stub', [
            'booking_id' => $booking->id,
            'reference' => $booking->reference_number,
            'customer_email' => $booking->customer?->email,
        ]);
    }
}
