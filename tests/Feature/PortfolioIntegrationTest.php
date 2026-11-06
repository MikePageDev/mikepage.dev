<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use MikePageDev\FilamentPortfolio\Models\Project;
use Tests\TestCase;

class PortfolioIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['app.name' => 'Test Site']);
    }

    public function test_portfolio_index_renders_inside_the_site_layout(): void
    {
        Project::factory()->published()->create(['title' => 'Demo App', 'slug' => 'demo-app']);

        $this->get('/portfolio')
            ->assertOk()
            ->assertSee('<title>Portfolio | Test Site</title>', false)
            ->assertSee('<nav aria-label="Main"', false)
            ->assertSee('Demo App');
    }

    public function test_case_study_keeps_portfolio_marked_current_in_the_nav(): void
    {
        Project::factory()->published()->create(['title' => 'Demo App', 'slug' => 'demo-app']);

        $content = $this->get('/portfolio/demo-app')
            ->assertOk()
            ->assertSee('<title>Demo App | Test Site</title>', false)
            ->getContent();

        $this->assertIsString($content);
        $this->assertMatchesRegularExpression(
            '#href="'.preg_quote(route('portfolio.index'), '#').'"\s+aria-current="page"#',
            $content,
        );
    }

    public function test_case_study_contact_link_points_at_the_contact_page(): void
    {
        Project::factory()->published()->create(['slug' => 'demo-app']);

        $this->get('/portfolio/demo-app')->assertSee('href="'.route('contact').'"', false);
    }

    public function test_site_keeps_its_own_portfolio_wording(): void
    {
        $this->get('/portfolio')
            ->assertSee('<meta name="description" content="Selected projects and case studies: Laravel applications, admin panels and backend work.">', false)
            ->assertSee('A selection of things I&#039;ve built, with the problem each one solved and the part I played.', false)
            ->assertSee('Project write-ups are on their way.')
            ->assertSee('In the meantime, <a href="'.route('contact').'" class="underline font-semibold">get in touch</a> to ask about my work.', false);

        Project::factory()->published()->create(['slug' => 'demo-app', 'role' => 'Lead developer.']);

        $this->get('/portfolio/demo-app')
            ->assertSee('My role</h2>', false)
            ->assertSee('Need something similar? <a href="'.route('contact').'"', false)
            ->assertSee('>Get in touch</a>.', false);
    }
}
