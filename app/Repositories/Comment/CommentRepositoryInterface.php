<?php

namespace App\Repositories\Comment;

use App\Models\Comment as CommentModel;

interface CommentRepositoryInterface
{
    public function __construct();
    public function new(array $data);
    public function update(array $data, CommentModel $comment);
    public function delete(CommentModel $comment);
}
