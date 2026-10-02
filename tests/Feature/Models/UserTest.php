<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_is_hashed_when_set(): void
    {
        $user = User::factory()->create(['password' => 'secret-password']);

        $this->assertNotSame('secret-password', $user->getAttributes()['password']);
        $this->assertTrue(Hash::check('secret-password', $user->password));
    }
}
