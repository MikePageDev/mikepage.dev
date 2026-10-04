<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_has_exactly_one_heading(): void
    {
        $content = $this->get('/')->assertOk()->getContent();

        $this->assertIsString($content);
        $this->assertSame(1, substr_count($content, '<h1'));
    }

    public function test_links_to_portfolio_and_contact(): void
    {
        $this->get('/')
            ->assertSee('href="'.route('portfolio').'"', false)
            ->assertSee('href="'.route('contact').'"', false)
            ->assertSee('See my work')
            ->assertSee('Get in touch');
    }
}
