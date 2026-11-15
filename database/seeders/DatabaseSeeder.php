<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin users are created with php artisan make:filament-user, so the
        // authenticator app is set up at first login.
        $this->call(StagingSeeder::class);
    }
}
