<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{

    protected string $model;

    public function create(array $data): Model|null
    {
        return DB::transaction(function () use ($data) {
            $model = new $this->model($data);

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

}
