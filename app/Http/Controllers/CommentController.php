<?php

namespace App\Http\Controllers;

use App\Helpers\CategoryMessageHelper;
use App\Helpers\CommentMessageHelper;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Comment\CreateCommentRequest;
use App\Services\Comments\CommentService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    private CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function list(int $ideaId): JsonResponse
    {
        try {
            $result = $this->commentService->all($ideaId);
            return response()->json($result, Response::HTTP_OK);
        } catch (\Exception|\Throwable $err) {
            dd($err);
            return response()->json(['message' => CategoryMessageHelper::GET_ALL_CATEGORY_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(int $ideaId, CreateCommentRequest $request): JsonResponse
    {
        try {
            $result = $this->commentService->create($ideaId, $request->validated());
            return response()->json($result, Response::HTTP_CREATED);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => CategoryMessageHelper::CREATE_CATEGORY_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(int $ideaId, int $commentId): JsonResponse
    {
        try {
            $result = $this->commentService->get($commentId);
            return response()->json($result, Response::HTTP_OK);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => CommentMessageHelper::GET_COMMENT_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }

}
