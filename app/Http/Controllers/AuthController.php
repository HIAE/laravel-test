<?php

namespace App\Http\Controllers;

use App\Helpers\CategoryMessageHelper;
use App\Helpers\UserMessageHelper;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Requests\User\LoginUserRequest;
use App\Services\Users\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(LoginUserRequest $loginRequest): JsonResponse
    {
        try {
            $result = $this->userService->authenticate($loginRequest->validated());
            return response()->json(['access_token' => $result], Response::HTTP_CREATED);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => UserMessageHelper::GENERATE_TOKEN_ERROR], Response::HTTP_BAD_REQUEST);
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

    public function userInfo(int $categoryId): JsonResponse
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
}
