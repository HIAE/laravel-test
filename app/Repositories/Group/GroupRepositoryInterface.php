<?php

namespace App\Repositories\Group;

use App\Models\Group as GroupModel;

interface GroupRepositoryInterface
{
    public function __construct();
    public function new(array $data);
    public function update(array $user, GroupModel $group);
    public function delete(GroupModel $UserGroup);
}
