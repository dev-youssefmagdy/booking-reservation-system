<?php

use App\Console\Commands\AlertExpiringDocuments;
use App\Console\Commands\DeliverScheduledReports;
use App\Console\Commands\SendBookingReminders;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(DeliverScheduledReports::class)->weekly();
Schedule::command(SendBookingReminders::class)->daily();
Schedule::command(AlertExpiringDocuments::class)->weekly();
