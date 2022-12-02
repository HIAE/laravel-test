<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * @lrd:start
     * List categories.
     * @lrd:end
     */
    public function index()
    {
        return $this->service->getAllCategories();
    }

    /**
     * @lrd:start
     * Create a category.
     * @lrd:end
     *
     * @QAparam name string required max:255
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->service->createCategory($request);

        return ['message' => "A categoria {$category->name} foi criada com sucesso."];
    }

    /**
     * @lrd:start
     * Edit category. Only admins.
     * @lrd:end
     *
     * @QAparam name string required max:255
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);

        $this->service->updateCategory($category, $request);

        return ['message' => "O nome da categoria foi alterado para {$category->name}."];
    }

    /**
     * @lrd:start
     * Delete a category. Only admins.
     * @lrd:end
     */
    public function destroy(Category $category)
    {
        $this->authorize('destroy', $category);

        $this->service->destroyCategory($category);

        return ['message' => "A categoria {$category->name} foi removida."];
    }
}
