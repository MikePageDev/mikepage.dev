<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class EnquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_enquiry_can_be_stored_unsent(): void
    {
        $enquiry = Enquiry::create([
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.test',
            'message' => 'I would like to discuss a project.',
            'ip_address' => '203.0.113.7',
        ]);

        $this->assertDatabaseHas('enquiries', [
            'id' => $enquiry->id,
            'email' => 'ada@example.test',
            'ip_address' => '203.0.113.7',
            'sent_at' => null,
        ]);
    }

    public function test_sent_at_is_cast_to_a_date(): void
    {
        $enquiry = Enquiry::factory()->create(['sent_at' => '2026-10-06 12:00:00']);

        $this->assertInstanceOf(Carbon::class, $enquiry->fresh()?->sent_at);
    }

    public function test_factory_makes_unsent_enquiries_by_default(): void
    {
        $this->assertNull(Enquiry::factory()->create()->sent_at);
    }
}
