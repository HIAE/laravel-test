<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Idea;
use App\Services\CommentService;

class CommentController extends Controller
{
    protected $service;

    public function __construct(CommentService $service)
    {
        $this->service = $service;
    }

    /**
     * @lrd:start
     * Show comments of an idea.
     * @lrd:end
     */
    public function index(Idea $idea)
    {
        return $this->service->getAllComments($idea);
    }

    /**
     * @lrd:start
     * Create a comment.
     * @lrd:end
     */
    public function store(CommentRequest $request, Idea $idea)
    {
        $this->service->createComment($idea, $request);

        return ['message' => 'Comentário criado com sucesso'];
    }

    /**
     * @lrd:start
     * Update a comment.
     * @lrd:end
     */
    public function update(CommentRequest $request, Idea $idea, Comment $comment)
    {
        $this->authorize('update', $comment);

        $this->service->updateComment($comment, $request);

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

        $this->service->destroyComment($comment);

        return ['message' => 'Comentário removido com sucesso'];
    }
}
