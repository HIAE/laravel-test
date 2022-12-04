<?php

namespace App\Http\Controllers;

use App\Helpers\CategoryMessageHelper;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Services\Categories\CategoryService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function create(CreateCategoryRequest $request): JsonResponse
    {
        try {
            $result = $this->categoryService->create($request->validated());
            return response()->json($result, Response::HTTP_CREATED);
        } catch (\Exception $err) {
            return response()->json(['message' => CategoryMessageHelper::CREATE_CATEGORY_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }

    }
}
