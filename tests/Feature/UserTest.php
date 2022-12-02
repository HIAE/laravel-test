<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private $user;

    private $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->admin = User::factory()->admin()->create();
    }

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
                'token',
            ]);
    }

    public function test_message_for_invalid_cpf()
    {
        $response = $this->postJson('/api/users', [
            'name' => 'Nome',
            'email' => 'email@company.com',
            'cpf' => '000.000.000-00',
            'password' => 'password-not-leaked',
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'O CPF deve ser válido.',
            ]);
    }

    public function test_admins_can_list_users()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->getJson('/api/users');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }

    public function test_users_cannot_list_users()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/users');

        $response
            ->assertStatus(403);
    }

    public function test_admins_can_show_users()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->getJson("/api/users/{$this->user->id}");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'emailVerifiedAt',
                    'cpf',
                    'isAdmin',
                    'createdAt',
                    'updatedAt',
                ],
            ]);
    }

    public function test_users_cannot_show_other_users()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson("/api/users/{$this->admin->id}");

        $response
            ->assertStatus(403);
    }

    public function test_admins_can_edit_users()
    {
        Sanctum::actingAs($this->admin);

        $data = [
            'name' => 'Novo nome',
            'email' => 'email@company.com',
        ];

        $response = $this->putJson("/api/users/{$this->user->id}", $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "O usuário #{$this->user->id} foi atualizado com sucesso."
            ]);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function test_users_cannot_edit_other_users()
    {
        Sanctum::actingAs($this->user);

        $response = $this->putJson("/api/users/{$this->admin->id}", [
            'name' => '...',
            'email' => 'other@company.com',
        ]);

        $response
            ->assertStatus(403);
    }

    public function test_users_can_edit_themselves()
    {
        Sanctum::actingAs($this->user);

        $data = [
            'name' => 'Outro nome',
            'email' => 'outro@company.com',
        ];

        $response = $this->putJson("/api/users/{$this->user->id}", $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "O usuário #{$this->user->id} foi atualizado com sucesso."
            ]);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function test_admins_can_delete_users()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->deleteJson("/api/users/{$this->user->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "O usuário #{$this->user->id} foi removido com sucesso."
            ]);

        $this->user->refresh();

        $this
            ->assertDatabaseHas('users', [
                'id' => $this->user->id,
            ])
            ->assertNotNull($this->user->deleted_at);
    }

    public function test_users_cannot_delete_other_users()
    {
        Sanctum::actingAs($this->user);

        $response = $this->deleteJson("/api/users/{$this->admin->id}");

        $response
            ->assertStatus(403);
    }

    public function test_users_can_delete_themselves()
    {
        Sanctum::actingAs($this->user);

        $response = $this->deleteJson("/api/users/{$this->user->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "O usuário #{$this->user->id} foi removido com sucesso."
            ]);

        $this->user->refresh();

        $this
            ->assertDatabaseHas('users', [
                'id' => $this->user->id,
            ])
            ->assertNotNull($this->user->deleted_at);
    }
}
