<?php

namespace App\Repositories\User;

use App\Models\User as UserModel;

interface UserRepositoryInterface
{
    public function __construct();
    public function new(array $data);
    public function update(array $data, UserModel $user);
    public function delete(UserModel $user);
}