<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token'
            ]);
    }

    public function test_login_message_for_incorrect_login()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'incorrect',
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message'
            ]);
    }

    public function test_login_message_for_missing_email()
    {
        $user = User::factory()->create();

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
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => '',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'O campo password é obrigatório.',
            ]);
    }
}
