<?php

namespace Tests\Feature;

use App\Models\Category;
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
}
