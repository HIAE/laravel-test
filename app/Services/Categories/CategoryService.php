<?php

namespace App\Services\Categories;

use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;
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
    public function all(): Collection
    {
        $collection = $this->categoryRepository->findAll();
        throw_if(empty($collection), \Exception::class);
        return $collection;
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

    /**
     * @throws Throwable
     */
    public function update(int $identifier, array $data): Model
    {
        $model = $this->categoryRepository->findOne($identifier);
        $updatedModel = $this->categoryRepository->update($data, $model);
        throw_if(!$updatedModel, \Exception::class);
        return $updatedModel;
    }

    /**
     * @throws Throwable
     */
    public function delete(int $identifier): bool
    {
        $model = $this->categoryRepository->findOne($identifier);
        $isDeleted = $this->categoryRepository->delete($model);
        throw_if(false === $isDeleted, \Exception::class);
        return $isDeleted;
    }

}
