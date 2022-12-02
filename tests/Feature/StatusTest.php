<?php

namespace Tests\Feature;

use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private $user;
    private $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_can_list_status()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/status');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }

    public function test_admins_can_create_status()
    {
        Sanctum::actingAs($this->admin);

        $status_count = Status::count();

        $response = $this->postJson('/api/status', [
            'name' => 'Novo status',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Status Novo status criado com sucesso',
            ]);

        $this->assertDatabaseHas('statuses', [
            'name' => 'Novo status',
            'number' => $status_count + 1,
        ]);
    }

    public function test_users_cannot_create_status()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/status', [
            'name' => 'Outro status',
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('statuses', [
            'name' => 'Outro status',
        ]);
    }

    public function test_admins_can_edit_status()
    {
        Sanctum::actingAs($this->admin);

        $status = Status::factory()->create();

        $response = $this->putJson("/api/status/{$status->id}", [
            'name' => 'Status alterado',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Status atualizado com sucesso',
            ]);

        $this->assertDatabaseHas('statuses', [
            'name' => 'Status alterado',
        ]);
    }

    public function test_users_cannot_edit_status()
    {
        Sanctum::actingAs($this->user);

        $status = Status::factory()->create();

        $response = $this->putJson("/api/status/{$status->id}", [
            'name' => 'Status do usuário',
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('statuses', [
            'name' => 'Status do usuário',
        ]);
    }

    public function test_admins_can_delete_status()
    {
        Sanctum::actingAs($this->admin);

        $status = Status::factory()->create();

        $response = $this->deleteJson("/api/status/{$status->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Status removido com sucesso',
            ]);

        $status->refresh();

        $this
            ->assertDatabaseHas('statuses', [
                'id' => $status->id,
            ])
            ->assertNotNull($status->deleted_at);
    }

    public function test_users_cannot_delete_status()
    {
        Sanctum::actingAs($this->user);

        $status = Status::factory()->create();

        $response = $this->deleteJson("/api/status/{$status->id}");

        $response->assertStatus(403);
    }
}
