<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{

    public function create(array $data): Model|null
    {
        return DB::transaction(function () use ($data) {
            $model = new User($data);
            $model->password = Hash::make($model->password);
            return $model->save() ? $model : null;
        });
    }

    public function update(array $data, Model $model): Model|bool
    {
        return DB::transaction(function () use ($data, $model) {
            $model->update($data);
            return $model->wasChanged() ? $model : false;
        });
    }

    public function delete(Model $model): bool
    {
        return DB::transaction(function () use ($model) {
            return $model->delete();
        });
    }

    public function findOne(int $primaryKey): Model|null
    {
        return DB::transaction(function () use ($primaryKey) {
            return User::find($primaryKey);
        });
    }

    public function findAll(): Collection
    {
        return DB::transaction(function () {
            return User::all();
        });
    }

}
