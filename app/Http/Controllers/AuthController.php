<?php

namespace App\Http\Controllers;

use App\Helpers\UserMessageHelper;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
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

    public function create(CreateUserRequest $request): JsonResponse
    {
        try {
            $result = $this->userService->create($request->validated());
            return response()->json($result, Response::HTTP_CREATED);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => UserMessageHelper::CREATE_USER_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }

    public function userInfo(): JsonResponse
    {
        try {
            return response()->json($this->userService->get(), Response::HTTP_OK);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => UserMessageHelper::GET_USER_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        try {
            $result = $this->userService->update($request->validated());
            return response()->json($result, Response::HTTP_OK);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => UserMessageHelper::UPDATE_USER_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }
}
