<?php

namespace Tests\Feature;

use Tests\TestCase;

class AboutPageTest extends TestCase
{
    public function test_renders_inside_layout_with_its_own_title(): void
    {
        config(['app.name' => 'Test Site']);

        $this->get('/about')
            ->assertOk()
            ->assertSee('<title>About | Test Site</title>', false)
            ->assertSee('<h1', false);
    }

    public function test_podcast_link_opens_in_a_new_tab(): void
    {
        $content = $this->get('/about')->getContent();

        $this->assertIsString($content);

        if (preg_match('#<a href="https://www\.youtube\.com/[^"]*"[^>]*>#', $content, $matches) !== 1) {
            $this->fail('No podcast link found.');
        }

        $this->assertStringContainsString('target="_blank"', $matches[0]);
        $this->assertStringContainsString('rel="noopener noreferrer"', $matches[0]);
    }

    public function test_ends_with_a_route_to_contact(): void
    {
        $this->get('/about')->assertSee('href="'.route('contact').'"', false);
    }
}
