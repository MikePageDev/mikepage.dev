<?php

namespace Tests\Feature;

use Tests\TestCase;

class LayoutTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'app.name' => 'Test Site',
            'site.description' => 'Default description',
            'site.og_image' => 'img/mike.jpg',
        ]);
    }

    public function test_home_title_is_the_app_name(): void
    {
        $this->get('/')->assertSee('<title>Test Site</title>', false);
    }

    public function test_meta_description_defaults_to_site_description(): void
    {
        $this->get('/')->assertSee('<meta name="description" content="Default description">', false);
    }

    public function test_open_graph_tags_are_present(): void
    {
        $this->get('/')
            ->assertSee('<meta property="og:title" content="Test Site">', false)
            ->assertSee('<meta property="og:description" content="Default description">', false)
            ->assertSee('<meta property="og:url" content="'.url('/').'">', false)
            ->assertSee('<meta property="og:image" content="'.asset('img/mike.jpg').'">', false)
            ->assertSee('<meta property="og:type" content="website">', false)
            ->assertSee('<meta name="twitter:card" content="summary">', false)
            ->assertSee('<link rel="canonical" href="'.url('/').'">', false);
    }

    public function test_html_element_is_not_cloaked(): void
    {
        $content = $this->get('/')->getContent();

        $this->assertIsString($content);

        if (preg_match('/<html[^>]*>/s', $content, $matches) !== 1) {
            $this->fail('No <html> tag found.');
        }

        $this->assertStringNotContainsString('x-cloak', $matches[0]);
    }

    public function test_current_page_is_marked_in_nav(): void
    {
        $content = $this->get('/portfolio')->getContent();

        $this->assertIsString($content);
        $this->assertMatchesRegularExpression(
            '#href="'.preg_quote(route('portfolio'), '#').'"\s+aria-current="page"#',
            $content,
        );
    }

    public function test_home_has_no_current_nav_link(): void
    {
        $this->get('/')->assertDontSee('aria-current="page"', false);
    }

    public function test_mobile_menu_toggle_is_an_accessible_button(): void
    {
        $this->get('/')
            ->assertSee('aria-controls="mobile-menu"', false)
            ->assertSee('aria-expanded="false"', false)
            ->assertSee('id="mobile-menu"', false)
            ->assertSee('aria-label="Toggle dark mode"', false);
    }

    public function test_footer_has_social_links(): void
    {
        $this->get('/')
            ->assertSee('href="https://github.com/MikePageDev"', false)
            ->assertSee('href="https://phpc.social/@MikePageDev"', false)
            ->assertSee('href="https://www.linkedin.com/in/michaelaspage/"', false);
    }

    public function test_every_nav_link_is_in_both_desktop_and_mobile_menus(): void
    {
        $content = $this->get('/')->getContent();

        $this->assertIsString($content);

        if (preg_match('#<nav aria-label="Main".*?</nav>#s', $content, $matches) !== 1) {
            $this->fail('No main <nav> found.');
        }

        foreach (['about', 'portfolio', 'services', 'contact'] as $route) {
            $this->assertSame(
                2,
                substr_count($matches[0], 'href="'.route($route).'"'),
                "Expected [$route] in both the desktop and mobile menus.",
            );
        }
    }

    public function test_theme_preference_uses_the_dark_storage_key(): void
    {
        $this->get('/')
            ->assertSee("localStorage.getItem('dark') === 'true'", false)
            ->assertSee("localStorage.setItem('dark', val)", false);
    }
}
