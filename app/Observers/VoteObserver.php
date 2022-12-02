<?php

namespace App\Observers;

use App\Models\Vote;

class VoteObserver
{
    public function created(Vote $vote)
    {
        $this->updateIdeaVotesCount($vote);
    }

    public function deleted(Vote $vote)
    {
        $this->updateIdeaVotesCount($vote);
    }

    public function restored(Vote $vote)
    {
        $this->updateIdeaVotesCount($vote);
    }

    public function forceDeleted(Vote $vote)
    {
        $this->updateIdeaVotesCount($vote);
    }

    private function updateIdeaVotesCount(Vote $vote)
    {
        $vote->idea()->update([
            'votes_count' => $vote->idea->votes()->count(),
        ]);
    }
}
