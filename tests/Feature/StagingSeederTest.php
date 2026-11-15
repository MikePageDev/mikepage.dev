<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use Database\Seeders\StagingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use MikePageDev\FilamentPortfolio\Models\Project;
use RuntimeException;
use Tests\TestCase;

class StagingSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake(config()->string('filament-portfolio.disk'));
    }

    public function test_seeds_projects_and_an_enquiry_for_each_state(): void
    {
        $this->seed(StagingSeeder::class);

        $this->assertTrue(Project::query()->where('is_published', true)->exists());
        $this->assertTrue(Project::query()->where('is_published', false)->exists());

        // Emailed, not emailed (badge and resend), IP due for removal, and due for deletion.
        $this->assertTrue(Enquiry::query()->whereNotNull('sent_at')->exists());
        $this->assertTrue(Enquiry::query()->whereNull('sent_at')->exists());
        $this->assertTrue(Enquiry::query()->whereNotNull('ip_address')
            ->whereBetween('created_at', [now()->subMonths(12), now()->subDays(30)])->exists());
        $this->assertTrue(Enquiry::query()->where('created_at', '<', now()->subMonths(12))->exists());
    }

    public function test_running_it_again_does_not_duplicate_anything(): void
    {
        $this->seed(StagingSeeder::class);
        $projects = Project::query()->count();
        $enquiries = Enquiry::query()->count();

        $this->seed(StagingSeeder::class);

        $this->assertSame($projects, Project::query()->count());
        $this->assertSame($enquiries, Enquiry::query()->count());
    }

    public function test_refuses_to_run_in_production(): void
    {
        $this->app->detectEnvironment(fn (): string => 'production');

        $this->expectException(RuntimeException::class);

        (new StagingSeeder)->run();
    }
}
