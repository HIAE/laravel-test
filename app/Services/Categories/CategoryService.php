<?php

namespace App\Services\Categories;

use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Model;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(array $data): Model
    {
        return $this->categoryRepository->create($data);
    }

}
