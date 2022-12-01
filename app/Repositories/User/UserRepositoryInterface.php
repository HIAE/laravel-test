<?php

namespace App\Repositories\User;

use App\Models\User as UserModel;

interface UserRepositoryInterface
{
    public function __construct();
    public function new(array $data);
    public function updateById(array $user, UserModel $group);
    public function deleteById(UserModel $UserGroup);
}
