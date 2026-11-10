<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContactPageTest extends TestCase
{
    public function test_renders_the_contact_form(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertSee('wire:name="contact-form"', false)
            ->assertSee('Send message');
    }

    public function test_offers_email_as_a_fallback_when_configured(): void
    {
        config(['site.contact_email' => 'hello@example.test']);

        $this->get('/contact')
            ->assertSee('Prefer email?')
            ->assertSee('href="mailto:hello@example.test"', false);
    }

    public function test_hides_the_email_fallback_when_not_configured(): void
    {
        config(['site.contact_email' => null]);

        $this->get('/contact')
            ->assertOk()
            ->assertDontSee('Prefer email?')
            ->assertDontSee('mailto:', false);
    }

    public function test_no_longer_lists_linkedin_and_github_in_the_page_body(): void
    {
        $content = $this->get('/contact')->getContent();

        $this->assertIsString($content);

        if (preg_match('#<main.*?</main>#s', $content, $matches) !== 1) {
            $this->fail('No <main> found.');
        }

        $this->assertStringNotContainsString('linkedin.com', $matches[0]);
        $this->assertStringNotContainsString('You can also find me on', $matches[0]);
    }

    public function test_has_own_title_and_is_not_the_home_page(): void
    {
        config(['app.name' => 'Test Site']);

        $this->get('/contact')
            ->assertViewIs('contact')
            ->assertSee('<title>Contact | Test Site</title>', false);
    }
}
