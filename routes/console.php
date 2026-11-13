<?php

use App\Models\Enquiry;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Retention periods are promised on the privacy page; change both together.
Artisan::command('enquiries:prune', function (): void {
    Enquiry::query()
        ->where('created_at', '<', now()->subMonths(12))
        ->delete();

    Enquiry::query()
        ->whereNotNull('ip_address')
        ->where('created_at', '<', now()->subDays(30))
        ->update(['ip_address' => null]);
})->purpose('Delete enquiries after 12 months and their IP addresses after 30 days');

Schedule::command('enquiries:prune')->daily();
