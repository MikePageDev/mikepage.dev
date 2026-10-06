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
        // Match the site's black/white/grey palette instead of Filament's default amber.
        FilamentColor::register([
            'primary' => Color::Zinc,
            'gray' => Color::Neutral,
        ]);
    }
}
