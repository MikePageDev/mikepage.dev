<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class PruneEnquiriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_deletes_enquiries_older_than_twelve_months(): void
    {
        $old = Enquiry::factory()->create(['created_at' => now()->subMonths(12)->subDay()]);
        $recent = Enquiry::factory()->create(['created_at' => now()->subMonths(12)->addDay()]);

        $this->assertSame(0, Artisan::call('enquiries:prune'));

        $this->assertModelMissing($old);
        $this->assertModelExists($recent);
    }

    public function test_removes_ip_addresses_older_than_thirty_days(): void
    {
        $old = Enquiry::factory()->create(['ip_address' => '203.0.113.7', 'created_at' => now()->subDays(31)]);
        $recent = Enquiry::factory()->create(['ip_address' => '203.0.113.8', 'created_at' => now()->subDays(29)]);

        $this->assertSame(0, Artisan::call('enquiries:prune'));

        $this->assertNull($old->fresh()?->ip_address);
        $this->assertSame('203.0.113.8', $recent->fresh()?->ip_address);
    }

    public function test_runs_daily(): void
    {
        $events = collect(app(Schedule::class)->events())
            ->filter(fn (Event $event): bool => str_contains((string) $event->command, 'enquiries:prune'));

        $this->assertCount(1, $events);
        $this->assertSame('0 0 * * *', $events->first()?->expression);
    }
}
