<?php

namespace App\Http\Controllers;

use App\Helpers\IdeaMessageHelper;
use App\Http\Requests\Idea\CreateIdeaRequest;
use App\Http\Requests\Idea\UpdateIdeaRequest;
use App\Services\Ideas\IdeaService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class IdeaController extends Controller
{
    private IdeaService $ideaService;

    public function __construct(IdeaService $ideaService)
    {
        $this->ideaService = $ideaService;
    }

    public function list(): JsonResponse
    {
        try {
            $result = $this->ideaService->all();
            return response()->json($result, Response::HTTP_OK);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => IdeaMessageHelper::GET_ALL_IDEA_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(CreateIdeaRequest $request): JsonResponse
    {
        try {
            $result = $this->ideaService->create($request->validated());
            return response()->json($result, Response::HTTP_CREATED);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => IdeaMessageHelper::CREATE_IDEA_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(int $ideaId): JsonResponse
    {
        try {
            $result = $this->ideaService->get($ideaId);
            return response()->json($result, Response::HTTP_OK);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => IdeaMessageHelper::GET_IDEA_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(int $ideaId, UpdateIdeaRequest $request): JsonResponse
    {
        try {
            $result = $this->ideaService->update($ideaId, $request->validated());
            return response()->json($result, Response::HTTP_OK);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => IdeaMessageHelper::UPDATE_IDEA_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }

    public function change(int $ideaId): JsonResponse
    {
        try {
            $statusFromRequest = request()->only('status');
            $result = $this->ideaService->updateStatus($ideaId, $statusFromRequest['status']);
            return response()->json($result, Response::HTTP_OK);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => IdeaMessageHelper::UPDATE_IDEA_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete(int $ideaId): JsonResponse
    {
        try {
            $result = $this->ideaService->delete($ideaId);
            return response()->json(['deleted' => $result], Response::HTTP_NO_CONTENT);
        } catch (\Exception|\Throwable $err) {
            return response()->json(['message' => IdeaMessageHelper::DELETE_IDEA_GENERAL_ERROR], Response::HTTP_BAD_REQUEST);
        }
    }
}
