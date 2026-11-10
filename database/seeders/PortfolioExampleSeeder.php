<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use MikePageDev\FilamentPortfolio\Models\Project;
use RuntimeException;

/**
 * Example portfolio projects for local development. Not called by DatabaseSeeder; run it with:
 * php artisan db:seed --class=PortfolioExampleSeeder
 */
class PortfolioExampleSeeder extends Seeder
{
    public function run(): void
    {
        $directory = config()->string('filament-portfolio.directory');

        $projects = [
            [
                'title' => 'Example: Booking Platform',
                'slug' => 'example-booking-platform',
                'summary' => 'A booking system for a chain of fitness studios, replacing spreadsheets and phone calls with online class bookings.',
                'problem' => 'Staff spent hours each week taking bookings by phone and reconciling paper registers. Classes were often double-booked or left half empty.',
                'role' => 'Sole developer: requirements, data model, Laravel application, Filament admin panel and deployment.',
                'tech' => ['Laravel', 'Filament', 'Livewire', 'MySQL', 'Stripe'],
                'case_study' => [
                    ['heading' => 'Approach', 'body' => 'Started with the studio managers to map how classes, instructors and memberships really worked, then built the booking flow first so it could be tested with real members early.'],
                    ['heading' => 'Outcome', 'body' => 'Phone bookings dropped by most of their volume within two months, and managers now see attendance for every class in one place.'],
                ],
                'images' => [
                    ['path' => $this->screenshot($directory, 'example-booking-1.png', 'Booking Platform', [30, 64, 175]), 'alt' => 'Class timetable with available spaces'],
                    ['path' => $this->screenshot($directory, 'example-booking-2.png', 'Booking Admin', [15, 118, 110]), 'alt' => 'Admin panel showing bookings for a class'],
                ],
                'live_url' => 'https://example.com',
                'source_url' => null,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Example: Stock Control API',
                'slug' => 'example-stock-control-api',
                'summary' => 'A REST API that keeps stock levels in sync between a warehouse system and two online shops.',
                'problem' => 'Each shop held its own stock count, so items sold out in one place were still on sale in the other.',
                'role' => 'Backend developer working alongside the client\'s in-house team.',
                'tech' => ['Laravel', 'REST API', 'Queues', 'Redis'],
                'case_study' => [
                    ['heading' => 'Approach', 'body' => 'Made the warehouse the single source of truth and pushed changes to the shops through queued jobs with retries, so a slow shop never blocked the others.'],
                ],
                'images' => [
                    ['path' => $this->screenshot($directory, 'example-stock-1.png', 'Stock Control API', [124, 58, 237]), 'alt' => 'API documentation page'],
                ],
                'live_url' => null,
                'source_url' => 'https://github.com/example/stock-control',
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Example: Legacy Upgrade',
                'slug' => 'example-legacy-upgrade',
                'summary' => 'Upgraded an ageing Laravel 5 application to the current release without downtime.',
                'problem' => null,
                'role' => null,
                'tech' => ['Laravel', 'PHPUnit'],
                'case_study' => null,
                'images' => null,
                'live_url' => null,
                'source_url' => null,
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Example: Draft Project',
                'slug' => 'example-draft-project',
                'summary' => 'This project is unpublished, so it only appears in the admin panel.',
                'problem' => null,
                'role' => null,
                'tech' => null,
                'case_study' => null,
                'images' => null,
                'live_url' => null,
                'source_url' => null,
                'is_published' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($projects as $attributes) {
            Project::query()->updateOrCreate(['slug' => $attributes['slug']], $attributes);
        }
    }

    /**
     * Draw a plain placeholder screenshot and store it on the portfolio disk.
     *
     * @param  array{int, int, int}  $rgb
     */
    private function screenshot(string $directory, string $filename, string $label, array $rgb): string
    {
        $image = imagecreatetruecolor(1200, 750);

        if ($image === false) {
            throw new RuntimeException('Could not create the placeholder image.');
        }

        $background = imagecolorallocate($image, max(0, min(255, $rgb[0])), max(0, min(255, $rgb[1])), max(0, min(255, $rgb[2])));
        $white = imagecolorallocate($image, 255, 255, 255);

        if ($background === false || $white === false) {
            throw new RuntimeException('Could not allocate placeholder colours.');
        }

        imagefill($image, 0, 0, $background);
        imagestring($image, 5, 40, 40, $label, $white);
        imagestring($image, 3, 40, 70, 'Example screenshot', $white);

        ob_start();
        imagepng($image);
        $png = ob_get_clean();

        if ($png === false) {
            throw new RuntimeException('Could not render the placeholder image.');
        }

        $path = $directory.'/'.$filename;
        Project::disk()->put($path, $png);

        return $path;
    }
}
