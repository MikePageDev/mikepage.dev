<?php

namespace Database\Seeders;

use App\Models\Enquiry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use RuntimeException;

/**
 * Demo data for staging and local QA: the example portfolio plus one enquiry for each
 * state the admin panel and the enquiries:prune job handle. Safe to run repeatedly.
 *
 * Builds records directly rather than with factories: Faker is a dev dependency
 * and isn't installed on servers deployed with --no-dev.
 *
 * php artisan db:seed --class=StagingSeeder
 */
class StagingSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->isProduction()) {
            throw new RuntimeException('StagingSeeder adds demo data and must not run in production.');
        }

        $this->call(PortfolioExampleSeeder::class);

        foreach ($this->enquiries() as $attributes) {
            Enquiry::query()
                ->firstOrNew(['email' => $attributes['email']])
                // forceFill because the timestamps aren't fillable. Laravel keeps timestamps
                // that are set explicitly, so each enquiry gets the age it needs.
                ->forceFill($attributes)
                ->save();
        }
    }

    /**
     * @return list<array{name: string, email: string, message: string, ip_address: string, sent_at: Carbon|null, created_at: Carbon, updated_at: Carbon}>
     */
    private function enquiries(): array
    {
        return [
            // Recent and emailed: the normal case.
            $this->enquiry(
                name: 'Sarah Thompson',
                email: 'sarah.thompson@example.test',
                message: 'Hi Mike, we run our job scheduling from three shared spreadsheets and it is getting unmanageable. Could we have a chat about replacing them with something better?',
                ip: '203.0.113.10',
                received: now()->subHours(2),
                emailed: true,
            ),
            // Several paragraphs, to check line breaks show on the view page.
            $this->enquiry(
                name: 'James Patel',
                email: 'james.patel@example.test',
                message: "Hello,\n\nWe have a Laravel 8 application that needs upgrading to the current version. It has around 40 models and a fair amount of custom code.\n\nWould you be able to give a rough idea of the effort involved?\n\nThanks,\nJames",
                ip: '203.0.113.11',
                received: now()->subDays(3),
                emailed: true,
            ),
            // The email failed: shows the red badge, the "Not emailed" filter and the Resend button.
            $this->enquiry(
                name: 'Priya Shah',
                email: 'priya.shah@example.test',
                message: 'We need an API to connect our booking system to our accounting software. Is this something you could help with?',
                ip: '203.0.113.12',
                received: now()->subDay(),
                emailed: false,
            ),
            // Over 30 days old: the next enquiries:prune run removes its IP address.
            $this->enquiry(
                name: 'Tom Bennett',
                email: 'tom.bennett@example.test',
                message: 'Are you available for a short contract building a Filament admin panel for our internal team?',
                ip: '203.0.113.13',
                received: now()->subDays(45),
                emailed: true,
            ),
            // Over 12 months old: the next enquiries:prune run deletes it.
            $this->enquiry(
                name: 'Old Enquiry',
                email: 'old.enquiry@example.test',
                message: 'This enquiry is more than 12 months old and should be deleted by the cleanup job.',
                ip: '203.0.113.14',
                received: now()->subMonths(13),
                emailed: true,
            ),
        ];
    }

    /**
     * @return array{name: string, email: string, message: string, ip_address: string, sent_at: Carbon|null, created_at: Carbon, updated_at: Carbon}
     */
    private function enquiry(string $name, string $email, string $message, string $ip, Carbon $received, bool $emailed): array
    {
        return [
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'ip_address' => $ip,
            'sent_at' => $emailed ? $received->copy()->addMinute() : null,
            'created_at' => $received,
            'updated_at' => $received,
        ];
    }
}
