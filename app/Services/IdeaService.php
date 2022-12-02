<?php

namespace App\Services;

use App\Http\Requests\IdeaRequest;
use App\Http\Resources\IdeaResource;
use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaService
{
    public function getAllIdeas(Request $request)
    {
        $category_id = $request->get('category');
        $keyword = $request->get('q');
        $status_id = $request->get('status');

        return IdeaResource::collection(
            Idea::query()
                ->when($category_id, fn ($query) => $query
                    ->where('category_id', '=', $category_id)
                )
                ->when($keyword, fn ($query) => $query
                    ->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                )
                ->when($status_id, fn ($query) => $query
                    ->where('status_id', '=', $status_id)
                )
                ->with([
                    'user:id,name',
                    'category:id,name',
                    'status:id,name',
                ])
                ->paginate()
        );
    }

    public function showIdea(Idea $idea)
    {
        return new IdeaResource(
            $idea->load([
                'user:id,name',
                'category:id,name',
                'status:id,name',
            ])
        );
    }

    public function createIdea(IdeaRequest $request): Idea
    {
        $idea = new Idea();

        $idea->title = $request->title;
        $idea->description = $request->description;
        $idea->user_id = $request->user()->id;
        $idea->category_id = $request->categoryId;

        $idea->save();

        return $idea;
    }

    public function updateIdea(Idea $idea, IdeaRequest $request): bool
    {
        $idea->title = $request->title;
        $idea->description = $request->description;
        $idea->category_id = $request->categoryId;

        return $idea->save();
    }

    public function destroyIdea(Idea $idea): bool
    {
        return $idea->delete();
    }
}
