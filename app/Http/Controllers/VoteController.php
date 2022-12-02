<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * @lrd:start
     * Vote for an idea
     * @lrd:end
     */
    public function store(Request $request, Idea $idea)
    {
        $alreadyVoted = $idea->votes()
            ->where('user_id', '=', $request->user()->id)
            ->exists();

        if ($alreadyVoted) {
            return response([
                'message' => 'Seu voto já foi realizado para esta ideia',
            ], 400);
        }

        $idea->votes()->create([
            'user_id' => $request->user()->id,
        ]);

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

        $vote->delete();

        return ['message' => 'Voto removido com sucesso'];
    }
}
