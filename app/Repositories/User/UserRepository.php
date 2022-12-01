<?php

namespace App\Repositories\User;

use App\Models\User as UserModel;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function __construct()
    {
    }

    /**
     * New user
     *
     * @param  array $data
     * @return mixed
     */
    public function new(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = new UserModel($data);

            return $user->save();
        });
    }

    /**
     * Update user
     *
     * @param  array     $data
     * @param  UserModel $user
     * @return mixed
     */
    public function update(array $data, UserModel $user)
    {
        return DB::transaction(function () use ($data, $user) {
            $user->update($data);
            return $user->wasChanged();
        });
    }

    /**
     * Delete an user
     *
     * @param  UserModel $user
     * @return mixed
     */
    public function delete(UserModel $user)
    {
        return DB::transaction(function () use ($user) {
            return $user->delete();
        });
    }
}
