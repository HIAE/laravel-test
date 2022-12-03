<?php

namespace App\Repositories\Idea;

use App\Models\Category as CategoryModel;
use App\Models\Idea as IdeaModel;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\DB;

class IdeaRepository implements IdeaRepositoryInterface
{
    public function __construct()
    {
    }

    /**
     * New idea
     *
     * @param  array $data
     * @return mixed
     */
    public function new(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = UserModel::where('uuid', $data['user_id'])->first();
            $category = CategoryModel::where('uuid', $data['category_id'])->first();

            unset($data['user_id']);
            unset($data['category_id']);

            $idea = new IdeaModel($data);

            $idea->user()->associate($user);
            $idea->category()->associate($category);

            return $idea->save();
        });
    }

    /**
     * Update idea
     *
     * @param  array     $data
     * @param  IdeaModel $idea
     * @return mixed
     */
    public function update(array $data, IdeaModel $idea)
    {
        return DB::transaction(function () use ($data, $idea) {
            $idea->update($data);
            return $idea->wasChanged();
        });
    }

    /**
     * Delete an idea
     *
     * @param  IdeaModel $idea
     * @return mixed
     */
    public function delete(IdeaModel $idea)
    {
        return DB::transaction(function () use ($idea) {
            return $idea->delete();
        });
    }

    /**
     * Search by key word.
     *
     * @param  string $keyWord
     * @return mixed
     */
    public function searchByKeyWord(string $keyWord)
    {
        return DB::transaction(function () use ($keyWord) {
            return IdeaModel::where('key_word', $keyWord)->first();
        });
    }
}
