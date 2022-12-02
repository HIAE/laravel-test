<?php

namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryService
{
    public function getAllCategories()
    {
        return CategoryResource::collection(Category::paginate());
    }

    public function createCategory(CategoryRequest $request): Category
    {
        $category = new Category();

        $category->name = $request->name;

        $category->save();

        return $category;
    }

    public function updateCategory(Category $category, CategoryRequest $request): bool
    {
        $category->name = $request->name;

        return $category->save();
    }

    public function destroyCategory(Category $category): bool
    {
        return $category->delete();
    }
}
