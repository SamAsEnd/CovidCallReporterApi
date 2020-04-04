<?php

namespace Tests\Feature\Authentications;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function testExample()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/api/authenticate', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->dump();

        $response->assertOk();
    }
}
