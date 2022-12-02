<?php

namespace App\Services;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Idea;

class CommentService
{
    public function getAllComments(Idea $idea)
    {
        return CommentResource::collection(
            $idea->comments()->paginate()
        );
    }

    public function createComment(Idea $idea, CommentRequest $request): Comment
    {
        return $idea->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->body,
        ]);
    }

    public function updateComment(Comment $comment, CommentRequest $request): bool
    {
        $comment->body = $request->body;

        return $comment->save();
    }

    public function destroyComment(Comment $comment): bool
    {
        return $comment->delete();
    }
}
