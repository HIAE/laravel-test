<?php

namespace App\Http\Controllers;

use App\Helpers\CategoryMessageHelper;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
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

    public function list(): JsonResponse
    {
        try {
            $result = $this->categoryService->all();
            return response()->json($result, Response::HTTP_OK);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => CategoryMessageHelper::GET_ALL_CATEGORY_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(CreateCategoryRequest $request): JsonResponse
    {
        try {
            $result = $this->categoryService->create($request->validated());
            return response()->json($result, Response::HTTP_CREATED);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => CategoryMessageHelper::CREATE_CATEGORY_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(int $categoryId): JsonResponse
    {
        try {
            $result = $this->categoryService->get($categoryId);
            return response()->json($result, Response::HTTP_OK);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => CategoryMessageHelper::GET_CATEGORY_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(int $categoryId, UpdateCategoryRequest $request): JsonResponse
    {
        try {
            $result = $this->categoryService->update($categoryId, $request->validated());
            return response()->json($result, Response::HTTP_OK);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => CategoryMessageHelper::UPDATE_CATEGORY_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete(int $categoryId): JsonResponse
    {
        try {
            $result = $this->categoryService->delete($categoryId);
            return response()->json(['deleted' => $result], Response::HTTP_NO_CONTENT);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => CategoryMessageHelper::DELETE_CATEGORY_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }
}
