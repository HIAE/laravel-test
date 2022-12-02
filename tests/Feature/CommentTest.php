<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_can_list_comments()
    {
        Sanctum::actingAs(User::factory()->create());

        $idea = Idea::factory()->create();

        Comment::factory(10)->create([
            'idea_id' => $idea->id,
        ]);

        $response = $this->getJson("/api/ideas/{$idea->id}/comments");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }

    public function test_can_comment_an_idea()
    {
        Sanctum::actingAs(User::factory()->create());

        $idea = Idea::factory()->create();

        $response = $this->postJson("/api/ideas/{$idea->id}/comments", [
            'body' => 'Ótima ideia!',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Comentário criado com sucesso',
            ]);

        $idea->refresh();

        $this->assertEquals($idea->comments_count, 1);
    }

    public function test_user_cannot_update_comments_from_others()
    {
        Sanctum::actingAs(User::factory()->create());

        $comment = Comment::factory()->create();

        $response = $this->putJson("/api/ideas/{$comment->idea_id}/comments/{$comment->id}", [
            'body' => '...',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_update_own_comment()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->putJson("/api/ideas/{$comment->idea_id}/comments/{$comment->id}", [
            'body' => '...',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Comentário atualizado com sucesso',
            ]);
    }

    public function test_user_cannot_remove_comments_from_others()
    {
        Sanctum::actingAs(User::factory()->create());

        $comment = Comment::factory()->create();

        $response = $this->deleteJson("/api/ideas/{$comment->idea_id}/comments/{$comment->id}");

        $response->assertStatus(403);
    }

    public function test_user_can_remove_own_comment()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->deleteJson("/api/ideas/{$comment->idea_id}/comments/{$comment->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Comentário removido com sucesso',
            ]);
    }
}
