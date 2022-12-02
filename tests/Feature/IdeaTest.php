<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class IdeaTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_can_view_ideas()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/ideas');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }

    public function test_can_view_an_idea()
    {
        Sanctum::actingAs($this->user);

        $idea = Idea::factory()->create();

        $response = $this->getJson("/api/ideas/{$idea->id}");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'description',
                    'user',
                    'category',
                    'status',
                    'comments',
                    'votes',
                    'createdAt',
                ],
            ]);
    }

    public function test_users_can_create_ideas()
    {
        Sanctum::actingAs($this->user);

        $category = Category::where('name', '=', 'TI')->first();

        $title = 'Alterar grupos do WhatsApp para Slack';
        $description = 'Dessa forma os funcionários...';

        $response = $this->postJson('/api/ideas', [
            'title' => $title,
            'description' => $description,
            'categoryId' => $category->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Ideia criada com sucesso.',
            ]);

        $this
            ->assertDatabaseHas('ideas', [
                'title' => $title,
                'description' => $description,
                'category_id' => $category->id,
            ]);
    }

    public function test_users_can_update_own_idea()
    {
        Sanctum::actingAs($this->user);

        $idea = Idea::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $title = 'Novo título';
        $description = 'Nova descrição';

        $response = $this->putJson("/api/ideas/{$idea->id}", [
            'title' => $title,
            'description' => $description,
            'categoryId' => 1,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Ideia atualizada com sucesso.',
            ]);

        $this->assertDatabaseHas('ideas', [
            'title' => $title,
            'description' => $description,
            'category_id' => 1,
        ]);
    }

    public function test_users_cannot_update_ideas_from_others()
    {
        Sanctum::actingAs($this->user);

        $idea = Idea::factory()->create();

        $response = $this->putJson("/api/ideas/{$idea->id}", [
            'title' => '...',
            'description' => '...',
            'categoryId' => 1,
        ]);

        $response
            ->assertStatus(403);
    }

    public function test_users_can_delete_own_idea()
    {
        Sanctum::actingAs($this->user);

        $idea = Idea::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->deleteJson("/api/ideas/{$idea->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Ideia removida com sucesso.',
            ]);

        $idea->refresh();

        $this
            ->assertDatabaseHas('ideas', [
                'id' => $idea->id,
            ])
            ->assertNotNull($idea->deleted_at);
    }

    public function test_users_cannot_delete_ideas_from_others()
    {
        Sanctum::actingAs($this->user);

        $idea = Idea::factory()->create();

        $response = $this->deleteJson("/api/ideas/{$idea->id}");

        $response
            ->assertStatus(403);
    }
}
