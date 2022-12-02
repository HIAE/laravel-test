<?php

namespace Tests\Feature;

use App\Models\Idea;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class VoteTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_user_can_vote_an_idea()
    {
        Sanctum::actingAs($this->user);

        $idea = Idea::factory()->create();

        $response = $this->postJson("/api/ideas/{$idea->id}/votes");

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Voto realizado com sucesso',
            ]);

        $idea->refresh();

        $this->assertEquals($idea->votes_count, 1);

        $response = $this->postJson("/api/ideas/{$idea->id}/votes");

        $response
            ->assertStatus(400)
            ->assertJson([
                'message' => 'Seu voto já foi realizado para esta ideia',
            ]);
    }

    public function test_user_cannot_delete_votes_from_others()
    {
        Sanctum::actingAs($this->user);

        $vote = Vote::factory()->create();

        $response = $this->deleteJson("/api/ideas/{$vote->idea_id}/votes/{$vote->id}");

        $response
            ->assertStatus(403);
    }

    public function test_user_can_delete_own_votes()
    {
        Sanctum::actingAs($this->user);

        $vote = Vote::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->deleteJson("/api/ideas/{$vote->idea_id}/votes/{$vote->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Voto removido com sucesso',
            ]);
    }
}
