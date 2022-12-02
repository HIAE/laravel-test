<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Vote;
use App\Services\VoteService;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    protected $service;

    public function __construct(VoteService $service)
    {
        $this->service = $service;
    }

    /**
     * @lrd:start
     * Vote for an idea
     * @lrd:end
     */
    public function store(Request $request, Idea $idea)
    {
        $alreadyVoted = $this->service->checkIfUserVotedOnIdea($request->user(), $idea);

        if ($alreadyVoted) {
            return response([
                'message' => 'Seu voto já foi realizado para esta ideia',
            ], 400);
        }

        $this->service->createVote($request->user(), $idea);

        return ['message' => 'Voto realizado com sucesso'];
    }

    /**
     * @lrd:start
     * Remove vote for an idea
     * @lrd:end
     */
    public function destroy(Idea $idea, Vote $vote)
    {
        $this->authorize('delete', $vote);

        $this->service->destroyVote($vote);

        return ['message' => 'Voto removido com sucesso'];
    }
}
