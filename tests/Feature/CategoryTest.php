<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryTest extends TestCase
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

    public function test_can_view_categories()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/categories');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }

    public function test_can_create_category()
    {
        Sanctum::actingAs($this->user);

        $category_name = 'Nova Categoria';

        $response = $this->postJson('/api/categories', [
            'name' => $category_name,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "A categoria {$category_name} foi criada com sucesso.",
            ]);

        $this
            ->assertDatabaseHas('categories', ['name' => $category_name]);
    }

    public function test_admins_can_edit_category()
    {
        Sanctum::actingAs($this->admin);

        $category = Category::first();

        $old_name = $category->name;
        $new_name = 'Novo nome';

        $response = $this->putJson("/api/categories/{$category->id}", [
            'name' => $new_name,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "O nome da categoria foi alterado para {$new_name}.",
            ]);

        $this
            ->assertDatabaseMissing('categories', [
                'name' => $old_name,
            ])
            ->assertDatabaseHas('categories', [
                'name' => $new_name,
            ]);
    }

    public function test_users_cannot_update_categories()
    {
        Sanctum::actingAs($this->user);

        $category = Category::first();

        $response = $this->putJson("/api/categories/{$category->id}", [
            'name' => 'Novo nome',
        ]);

        $response
            ->assertStatus(403)
            ->assertJson([
                'message' => 'This action is unauthorized.',
            ]);
    }

    public function test_admins_can_remove_category()
    {
        Sanctum::actingAs($this->admin);

        $category = Category::first();

        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "A categoria {$category->name} foi removida.",
            ]);
    }

    public function test_users_cannot_remove_categories()
    {
        Sanctum::actingAs($this->user);

        $category = Category::first();

        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response
            ->assertStatus(403)
            ->assertJson([
                'message' => 'This action is unauthorized.',
            ]);
    }
}
