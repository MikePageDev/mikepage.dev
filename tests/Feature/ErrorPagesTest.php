<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use RuntimeException;
use Tests\TestCase;

class ErrorPagesTest extends TestCase
{
    public function test_not_found_page_uses_the_site_layout(): void
    {
        $this->get('/no-such-page')
            ->assertNotFound()
            ->assertSee('Page not found')
            ->assertSee('<nav aria-label="Main"', false)
            ->assertSee('href="'.route('home').'"', false);
    }

    public function test_server_error_page_renders_without_the_app_layout(): void
    {
        config(['app.debug' => false]);
        Route::get('/_boom', fn () => throw new RuntimeException('Boom'));

        $this->get('/_boom')
            ->assertInternalServerError()
            ->assertSee('Something went wrong')
            ->assertDontSee('Boom')
            ->assertDontSee('<nav aria-label="Main"', false);
    }
}
