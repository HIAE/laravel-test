<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoryRepository
{

    public function create(array $data): Category|null
    {
        return DB::transaction(function () use ($data) {
            $model = new Category($data);
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
            return Category::find($primaryKey);
        });
    }

}
