<?php

namespace App\Repositories;

use App\Models\Idea;

class IdeaRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = new Idea();
    }

}
