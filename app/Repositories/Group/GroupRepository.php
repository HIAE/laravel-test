<?php

namespace App\Repositories\Group;

use App\Models\Group as GroupModel;
use Illuminate\Support\Facades\DB;

class GroupRepository implements GroupRepositoryInterface
{

    public function __construct()
    {
    }

    public function new(array $data)
    {
        return DB::transaction(function () use ($data) {
            $group = new GroupModel($data);

            return $group->save();
        });
    }

    public function updateById(array $data, GroupModel $group)
    {
        return DB::transaction(function () use ($data, $group) {
            $group->description = $data['description'];
            return $group->save();
        });
    }

    public function deleteById(GroupModel $group)
    {
        return DB::transaction(function () use ($group) {
            return $group->delete();
        });
    }
}
