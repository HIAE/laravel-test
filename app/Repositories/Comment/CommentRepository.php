<?php

namespace App\Repositories\Comment;

use App\Models\Comment as CommentModel;
use App\Models\Idea as IdeaModel;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\DB;

class CommentRepository implements CommentRepositoryInterface
{
    public function __construct()
    {
    }

    /**
     * New comment
     *
     * @param  array $data
     * @return mixed
     */
    public function new(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = UserModel::where('uuid', $data['user_id'])->first();
            $idea = IdeaModel::where('uuid', $data['idea_id'])->first();

            unset($data['user_id']);
            unset($data['idea_id']);

            $comment = new CommentModel($data);

            $comment->user()->associate($user);
            $comment->idea()->associate($idea);

            return $comment->save();
        });
    }

    /**
     * Update comment
     *
     * @param  array        $data
     * @param  CommentModel $comment
     * @return mixed
     */
    public function update(array $data, CommentModel $comment)
    {
        return DB::transaction(function () use ($data, $comment) {
            $comment->update($data);
            return $comment->wasChanged();
        });
    }

    /**
     * Delete an comment
     *
     * @param  CommentModel $comment
     * @return mixed
     */
    public function delete(CommentModel $comment)
    {
        return DB::transaction(function () use ($comment) {
            return $comment->delete();
        });
    }
}
