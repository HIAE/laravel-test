<?php

namespace App\Repositories\Category;

use App\Models\Category as CategoryModel;

interface CategoryRepositoryInterface
{
    public function __construct();
    public function new(array $data);
    public function update(array $data, CategoryModel $category);
    public function delete(CategoryModel $category);
}
