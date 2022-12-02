<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_user_can_login()
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token',
            ]);
    }

    public function test_login_message_for_incorrect_login()
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'incorrect',
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function test_login_message_for_missing_email()
    {
        $response = $this->postJson('/api/login', [
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'O campo email é obrigatório.',
            ]);
    }

    public function test_login_message_for_missing_password()
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => '',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'O campo password é obrigatório.',
            ]);
    }
}
