<?php

namespace App\Repositories\Group;

use App\Models\Group as GroupModel;
use Illuminate\Support\Facades\DB;

class GroupRepository implements GroupRepositoryInterface
{

    public function __construct()
    {
    }

    public function createNewGroup(array $data)
    {
        return DB::transaction(function () use ($data) {
            $group = new GroupModel($data);

            return $group->save();
        });
    }

    public function updateGroupById(array $user, $id)
    {
        //
    }

    public function deleteGroupById(GroupModel $group)
    {
        return DB::transaction(function () use ($group) {
            return $group->delete();
        });
    }
}
