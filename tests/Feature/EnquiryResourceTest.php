<?php

namespace Tests\Feature;

use App\Filament\Resources\Enquiries\EnquiryResource;
use App\Filament\Resources\Enquiries\Pages\ListEnquiries;
use App\Filament\Resources\Enquiries\Pages\ViewEnquiry;
use App\Mail\EnquiryReceived;
use App\Models\Enquiry;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class EnquiryResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'site.admin_emails' => ['owner@example.test'],
            'site.contact_email' => 'owner@example.test',
        ]);

        $owner = User::factory()->create(['email' => 'owner@example.test']);
        $owner->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');

        $this->actingAs($owner);
    }

    public function test_lists_enquiries_newest_first(): void
    {
        $old = Enquiry::factory()->create(['created_at' => now()->subDay()]);
        $new = Enquiry::factory()->create();

        Livewire::test(ListEnquiries::class)
            ->assertCanSeeTableRecords([$new, $old], inOrder: true);
    }

    public function test_not_emailed_filter_shows_only_failed_emails(): void
    {
        $sent = Enquiry::factory()->create(['sent_at' => now()]);
        $unsent = Enquiry::factory()->create();

        Livewire::test(ListEnquiries::class)
            ->filterTable('not_emailed')
            ->assertCanSeeTableRecords([$unsent])
            ->assertCanNotSeeTableRecords([$sent]);
    }

    public function test_navigation_badge_counts_failed_emails(): void
    {
        Enquiry::factory()->create(['sent_at' => now()]);
        Enquiry::factory()->count(2)->create();

        $this->assertSame('2', EnquiryResource::getNavigationBadge());
    }

    public function test_view_page_shows_the_full_enquiry(): void
    {
        $enquiry = Enquiry::factory()->create([
            'message' => 'A long and detailed message about a project.',
            'ip_address' => '203.0.113.7',
        ]);

        $this->get(EnquiryResource::getUrl('view', ['record' => $enquiry]))
            ->assertOk()
            ->assertSee('A long and detailed message about a project.')
            ->assertSee('203.0.113.7')
            ->assertSee('mailto:'.$enquiry->email, false);
    }

    public function test_enquiries_cannot_be_created_or_edited(): void
    {
        $this->assertFalse(EnquiryResource::hasPage('create'));
        $this->assertFalse(EnquiryResource::hasPage('edit'));
    }

    public function test_an_enquiry_can_be_deleted(): void
    {
        $enquiry = Enquiry::factory()->create();

        Livewire::test(ViewEnquiry::class, ['record' => $enquiry->getRouteKey()])
            ->callAction(DeleteAction::class);

        $this->assertModelMissing($enquiry);
    }

    public function test_a_failed_email_can_be_resent(): void
    {
        Mail::fake();

        $enquiry = Enquiry::factory()->create();

        Livewire::test(ViewEnquiry::class, ['record' => $enquiry->getRouteKey()])
            ->callAction('resend')
            ->assertNotified('Enquiry emailed');

        $this->assertNotNull($enquiry->fresh()?->sent_at);
        Mail::assertSent(EnquiryReceived::class);
    }

    public function test_resend_is_hidden_once_emailed(): void
    {
        $enquiry = Enquiry::factory()->create(['sent_at' => now()]);

        Livewire::test(ViewEnquiry::class, ['record' => $enquiry->getRouteKey()])
            ->assertActionHidden('resend');
    }
}
