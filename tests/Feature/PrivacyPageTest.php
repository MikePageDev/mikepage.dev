<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrivacyPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_privacy_page_is_linked_from_the_footer(): void
    {
        config(['app.name' => 'Test Site']);

        $this->get('/privacy')
            ->assertOk()
            ->assertSee('<title>Privacy notice | Test Site</title>', false);

        $this->get('/')->assertSee('href="'.route('privacy').'"', false);
    }

    public function test_contact_form_links_to_the_privacy_page(): void
    {
        $this->get('/contact')->assertSee('href="'.route('privacy').'"', false);
    }
}
