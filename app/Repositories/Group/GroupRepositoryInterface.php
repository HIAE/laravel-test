<?php

namespace App\Repositories\Group;

use App\Models\Group as GroupModel;

interface GroupRepositoryInterface
{
    public function __construct();
    public function createNewGroup(array $data);
    public function updateGroupById(array $user, $id);
    public function deleteGroupById(GroupModel $UserGroup);
}
