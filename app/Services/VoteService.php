<?php

namespace App\Services;

use App\Models\Idea;
use App\Models\User;
use App\Models\Vote;

class VoteService
{
    public function checkIfUserVotedOnIdea(User $user, Idea $idea): bool
    {
        return $idea->votes()
            ->where('user_id', '=', $user->id)
            ->exists();
    }

    public function createVote(User $user, Idea $idea): Vote
    {
        return $idea->votes()->create([
            'user_id' => $user->id,
        ]);
    }

    public function destroyVote(Vote $vote): bool
    {
        return $vote->delete();
    }
}
