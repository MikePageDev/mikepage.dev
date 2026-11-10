<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['site.admin_emails' => ['owner@example.test']]);
    }

    private function owner(bool $withMfa = true, string $email = 'owner@example.test'): User
    {
        $user = User::factory()->create(['email' => $email]);

        if ($withMfa) {
            $user->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');
        }

        return $user;
    }

    public function test_guests_are_sent_to_the_login_page(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_users_not_on_the_allow_list_are_forbidden(): void
    {
        $this->actingAs($this->owner(email: 'someone@example.test'))
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_the_owner_without_mfa_must_set_it_up(): void
    {
        $this->actingAs($this->owner(withMfa: false))
            ->get('/admin')
            ->assertRedirect(route('filament.admin.auth.multi-factor-authentication.set-up-required'));
    }

    public function test_the_owner_with_mfa_reaches_the_dashboard(): void
    {
        $this->actingAs($this->owner())
            ->get('/admin')
            ->assertOk();
    }

    public function test_access_is_case_insensitive(): void
    {
        $this->actingAs($this->owner(email: 'Owner@Example.TEST'))
            ->get('/admin')
            ->assertOk();
    }

    public function test_nobody_gets_in_when_the_allow_list_is_empty(): void
    {
        config(['site.admin_emails' => []]);

        $this->actingAs($this->owner())
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_there_is_no_registration_page(): void
    {
        $this->get('/admin/register')->assertNotFound();
    }

    public function test_mfa_secret_is_stored_encrypted(): void
    {
        $user = $this->owner();

        $raw = User::query()->toBase()->where('id', $user->id)->value('app_authentication_secret');

        $this->assertIsString($raw);
        $this->assertNotSame('JBSWY3DPEHPK3PXP', $raw);
        $this->assertSame('JBSWY3DPEHPK3PXP', $user->fresh()?->getAppAuthenticationSecret());
    }
}
