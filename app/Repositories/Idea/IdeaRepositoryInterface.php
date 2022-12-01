<?php

namespace App\Repositories\Idea;

use App\Models\Idea as IdeaModel;

interface IdeaRepositoryInterface
{
    public function __construct();
    public function new(array $data);
    public function updateById(array $data, IdeaModel $idea);
    public function deleteById(IdeaModel $idea);
}
