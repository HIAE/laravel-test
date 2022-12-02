<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * @lrd:start
     * Show comments of an idea.
     * @lrd:end
     */
    public function index(Idea $idea)
    {
        return $idea->comments()
            ->paginate();
    }

    /**
     * @lrd:start
     * Create a comment.
     * @lrd:end
     *
     * @QAparam body string required
     */
    public function store(Request $request, Idea $idea)
    {
        $this->validateRequest($request);

        $idea->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->body,
        ]);

        return ['message' => 'Comentário criado com sucesso'];
    }

    /**
     * @lrd:start
     * Update a comment.
     * @lrd:end
     *
     * @QAparam body string required
     */
    public function update(Request $request, Idea $idea, Comment $comment)
    {
        $this->authorize('update', $comment);

        $this->validateRequest($request);

        $comment->body = $request->body;

        $comment->save();

        return ['message' => 'Comentário atualizado com sucesso'];
    }

    /**
     * @lrd:start
     * Remove a comment.
     * @lrd:end
     */
    public function destroy(Idea $idea, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return ['message' => 'Comentário removido com sucesso'];
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'body' => 'required|string',
        ]);
    }
}
