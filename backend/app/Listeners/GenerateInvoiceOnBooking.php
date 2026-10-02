<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\BookingConfirmed;
use Illuminate\Support\Facades\Log;

class GenerateInvoiceOnBooking
{
    /**
     * Handle the event.
     * Invoice logic will be built in AGENT-10.
     */
    public function handle(BookingConfirmed $event): void
    {
        Log::info('Invoice generation stub', [
            'booking_id' => $event->booking->id,
            'reference' => $event->booking->reference_number,
            'total_amount' => $event->booking->total_amount,
        ]);
    }
}
