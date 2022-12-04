<?php

namespace App\Services\Comments;

use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Throwable;

class CommentService
{
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @throws Throwable
     */
    public function create(int $idea_id, array $data): Model
    {
        $data['idea_id'] = $idea_id;
        $data['user_id'] = Auth::id();
        $model = $this->commentRepository->create($data);
        throw_if(!$model, \Exception::class);
        return $model;
    }

    /**
     * @throws Throwable
     */
    public function all(int $ideaId): Collection
    {
        $collection = $this->commentRepository->findAll($ideaId);
        throw_if(empty($collection), \Exception::class);
        return $collection;
    }

    /**
     * @throws Throwable
     */
    public function get(int $identifier): Model
    {
        $model = $this->commentRepository->findOne($identifier);
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
