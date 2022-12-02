<?php

namespace App\Observers;

use App\Models\Comment;

class CommentObserver
{
    public function created(Comment $comment)
    {
        $this->updateIdeaCommentsCount($comment);
    }

    public function deleted(Comment $comment)
    {
        $this->updateIdeaCommentsCount($comment);
    }

    public function restored(Comment $comment)
    {
        $this->updateIdeaCommentsCount($comment);
    }

    public function forceDeleted(Comment $comment)
    {
        $this->updateIdeaCommentsCount($comment);
    }

    private function updateIdeaCommentsCount(Comment $comment)
    {
        $comment->idea()->update([
            'comments_count' => $comment->idea->comments()->count(),
        ]);
    }
}
