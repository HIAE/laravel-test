<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @lrd:start
     * List categories.
     * @lrd:end
     */
    public function index()
    {
        return Category::paginate();
    }

    /**
     * @lrd:start
     * Create a category.
     * @lrd:end
     *
     * @QAparam name string required max:255
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories',
        ]);

        $category = new Category();

        $category->name = $request->name;

        $category->save();

        return ['message' => "A categoria {$category->name} foi criada com sucesso."];
    }

    /**
     * @lrd:start
     * Edit category. Only admins.
     * @lrd:end
     *
     * @QAparam name string required max:255
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $request->validate([
            'name' => 'required|max:255',
        ]);

        $category->name = $request->name;

        $category->save();

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

        $category->delete();

        return ['message' => "A categoria {$category->name} foi removida."];
    }
}
