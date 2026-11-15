<?php

namespace Tests\Feature;

use Tests\TestCase;

class NoIndexTest extends TestCase
{
    public function test_non_production_pages_ask_search_engines_not_to_index(): void
    {
        $this->get('/')->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $this->get('/no-such-page')->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_production_pages_can_be_indexed(): void
    {
        $this->app->detectEnvironment(fn (): string => 'production');

        $this->get('/')->assertHeaderMissing('X-Robots-Tag');
    }
}
