<?php

namespace App\Services\Ideas;

use App\Constants\IdeaStatus;
use App\Constants\UserRoles;
use App\Repositories\IdeaRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Throwable;

class IdeaService
{
    private IdeaRepository $ideaRepository;

    public function __construct(IdeaRepository $ideaRepository)
    {
        $this->ideaRepository = $ideaRepository;
    }

    /**
     * @throws Throwable
     */
    public function create(array $data): Model
    {
        $data['status'] = IdeaStatus::CREATED;
        $data['user_id'] = Auth::id();
        $model = $this->ideaRepository->create($data);
        throw_if(!$model, \Exception::class);
        return $model;
    }

    /**
     * @throws Throwable
     */
    public function all(): Collection
    {
        $collection = $this->ideaRepository->findAll();
        throw_if(empty($collection), \Exception::class);
        return $collection;
    }

    /**
     * @throws Throwable
     */
    public function get(int $identifier): Model
    {
        $model = $this->ideaRepository->findOne($identifier);
        throw_if(!$model, \Exception::class);
        return $model;
    }

    /**
     * @throws Throwable
     */
    public function update(int $identifier, array $data): Model
    {
        $model = $this->ideaRepository->findOne($identifier);
        throw_if($model->user_id !== Auth::id() && Auth::user()['role'] !== UserRoles::ADMIN, \Exception::class);

        $updatedModel = $this->ideaRepository->update($data, $model);
        throw_if(!$updatedModel, \Exception::class);
        return $updatedModel;
    }

    /**
     * @throws Throwable
     */
    public function delete(int $identifier): bool
    {
        $model = $this->ideaRepository->findOne($identifier);
        throw_if($model->user_id !== Auth::id() && Auth::user()['role'] !== UserRoles::ADMIN, \Exception::class);

        $isDeleted = $this->ideaRepository->delete($model);
        throw_if(false === $isDeleted, \Exception::class);
        return $isDeleted;
    }

}
