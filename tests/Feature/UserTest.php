<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_users_can_register()
    {
        $response = $this->postJson('/api/users', [
            'name' => 'Nome',
            'email' => 'email@company.com',
            'cpf' => '263.905.370-18',
            'password' => 'password-not-leaked',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'token'
            ]);
    }
}
