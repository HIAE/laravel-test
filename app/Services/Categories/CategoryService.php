<?php

namespace App\Services\Categories;

use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @throws Throwable
     */
    public function create(array $data): Model
    {
        $model = $this->categoryRepository->create($data);
        throw_if(!$model, \Exception::class);

        return $model;
    }

    /**
     * @throws Throwable
     */
    public function get(int $identifier): Model
    {
        $model = $this->categoryRepository->findOne($identifier);
        throw_if(!$model, \Exception::class);

        return $model;
    }

}
