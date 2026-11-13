<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use MikePageDev\FilamentPortfolio\Models\Project;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_lists_the_pages_and_published_case_studies(): void
    {
        $published = Project::factory()->create(['slug' => 'published-app', 'is_published' => true]);
        Project::factory()->create(['slug' => 'draft-app', 'is_published' => false]);

        $response = $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        foreach (['home', 'about', 'portfolio.index', 'services', 'contact', 'privacy'] as $route) {
            $response->assertSee('<loc>'.route($route).'</loc>', false);
        }

        $response
            ->assertSee('<loc>'.route('portfolio.show', $published->slug).'</loc>', false)
            ->assertDontSee('draft-app');

        // Crawlers reject the file if anything, even a newline, comes before the declaration.
        $this->assertStringStartsWith('<?xml', (string) $response->getContent());
    }
}
