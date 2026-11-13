<?php

namespace App\Providers;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
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
        // A muted PHP-logo purple. Hand-tuned rather than Color::hex(), whose shades are
        // brighter and fail text contrast. Filament only uses white text on a button when
        // both 600 and its hover shade 500 reach 4.5:1, so keep 500 dark enough for that.
        // The site's own buttons use these shades too (bg-primary-600 etc.).
        FilamentColor::register([
            'primary' => [
                50 => 'oklch(0.977 0.015 279)',
                100 => 'oklch(0.950 0.030 279)',
                200 => 'oklch(0.905 0.050 279)',
                300 => 'oklch(0.840 0.075 279)',
                400 => 'oklch(0.750 0.100 279)',
                500 => 'oklch(0.570 0.125 279)',
                600 => 'oklch(0.520 0.130 279)',
                700 => 'oklch(0.455 0.120 279)',
                800 => 'oklch(0.410 0.100 279)',
                900 => 'oklch(0.360 0.080 279)',
                950 => 'oklch(0.260 0.060 279)',
            ],
            'gray' => Color::Neutral,
        ]);
    }
}
