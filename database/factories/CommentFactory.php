<?php

namespace Database\Factories;

use App\Models\Idea;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $idea = Idea::factory()->create();

        return [
            'idea_id' => $idea->id,
            'user_id' => $idea->user_id,
            'body' => $this->faker->sentence(),
        ];
    }
}
