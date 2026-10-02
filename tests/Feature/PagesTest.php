<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    /**
     * @return array<string, array{string, view-string}>
     */
    public static function pageProvider(): array
    {
        return [
            'home' => ['home', 'home'],
            'about' => ['about', 'about'],
            'portfolio' => ['portfolio', 'home'],
            'contact' => ['contact', 'home'],
        ];
    }

    /**
     * @param  view-string  $view
     */
    #[DataProvider('pageProvider')]
    public function test_page_renders_expected_view(string $route, string $view): void
    {
        $response = $this->get(route($route));

        $response->assertOk();
        $response->assertViewIs($view);
    }

    public function test_home_page_shows_introduction(): void
    {
        $response = $this->get(route('home'));

        $response->assertSeeText('Backend Developer');
        $response->assertSeeText('Hi, my name is Mike.');
    }

    public function test_layout_contains_navigation_links(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('href="'.route('home').'"', false);

        // Desktop nav and mobile menu each render the full set of links, in order.
        $links = [
            'href="'.route('about').'"',
            'href="'.route('portfolio').'"',
            'href="'.route('contact').'"',
        ];
        $response->assertSeeInOrder([...$links, ...$links], false);
    }

    public function test_layout_contains_footer_links(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('href="https://github.com/MikePageDev"', false);
        $response->assertSee('href="https://phpc.social/@MikePageDev"', false);
        $response->assertSee('href="https://www.linkedin.com/in/michaelaspage/"', false);
        $response->assertSee('href="https://github.com/MikePageDev/mikepage.dev"', false);
    }
}
