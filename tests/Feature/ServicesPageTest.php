<?php

namespace Tests\Feature;

use Tests\TestCase;

class ServicesPageTest extends TestCase
{
    public function test_lists_services_with_a_heading_each(): void
    {
        $content = $this->get('/services')->assertOk()->getContent();

        $this->assertIsString($content);

        if (preg_match('#<ul class="grid.*?</ul>#s', $content, $matches) !== 1) {
            $this->fail('No services list found.');
        }

        $this->assertGreaterThan(0, substr_count($matches[0], '<li'));
        $this->assertSame(substr_count($matches[0], '<li'), substr_count($matches[0], '<h2'));
    }

    public function test_has_title_and_contact_link(): void
    {
        config(['app.name' => 'Test Site']);

        $this->get('/services')
            ->assertSee('<title>Services | Test Site</title>', false)
            ->assertSee('href="'.route('contact').'"', false);
    }

    public function test_services_is_in_the_nav_between_portfolio_and_contact(): void
    {
        $this->get('/')->assertSeeInOrder([
            route('portfolio'),
            route('services'),
            route('contact'),
        ]);
    }
}
