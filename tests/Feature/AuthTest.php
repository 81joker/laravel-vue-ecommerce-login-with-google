<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a user to use in tests
        $this->user = User::factory()->create([
            'email' => 'laura@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'laura@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticatedAs($this->user);
    }

    public function test_registration(): void
    {
        $response = $this->post('/register', [
            'name' => 'Tim',
            'email' => 'tim@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);
        // $this->assertAuthenticatedAs($this->user);
    }


        public function test_logout(): void
    {
        // Authenticate as the user before logout
        $this->actingAs($this->user);

        $response = $this->post('/logout');

        $response->assertStatus(302);
        $this->assertGuest();
    }
}