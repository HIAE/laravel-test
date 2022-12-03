<?php

namespace App\Repositories\Category;

use App\Models\Category as CategoryModel;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct()
    {
    }

    /**
     * New category
     *
     * @param  array $data
     * @return mixed
     */
    public function new(array $data)
    {
        return DB::transaction(function () use ($data) {
            $category = new CategoryModel($data);

            return $category->save();
        });
    }

    /**
     * Update category
     *
     * @param  array     $data
     * @param  CategoryModel $category
     * @return mixed
     */
    public function update(array $data, CategoryModel $category)
    {
        return DB::transaction(function () use ($data, $category) {
            $category->update($data);
            return $category->wasChanged();
        });
    }

    /**
     * Delete an category
     *
     * @param  CategoryModel $category
     * @return mixed
     */
    public function delete(CategoryModel $category)
    {
        return DB::transaction(function () use ($category) {
            return $category->delete();
        });
    }
}
