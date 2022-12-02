<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    /**
     * @lrd:start
     * List ideas
     * @lrd:end
     *
     * @QAparam status integer nullable
     * @QAparam category integer nullable
     * @QAparam q string nullable
     */
    public function index(Request $request)
    {
        $status_id = $request->get('status');
        $category_id = $request->get('category');
        $keyword = $request->get('q');

        return Idea::when(
            $status_id,
            fn ($query) => $query->where('status_id', '=', $status_id)
        )
            ->when(
                $category_id,
                fn ($query) => $query->where('category_id', '=', $category_id)
            )
            ->when(
                $keyword,
                fn ($query) => $query
                    ->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
            )
            ->with([
                'user:id,name',
                'category:id,name',
                'status:id,name',
            ])
            ->paginate(15, [
                'id',
                'title',
                'user_id',
                'category_id',
                'status_id',
                'comments_count',
                'votes_count',
                'created_at',
            ]);
    }

    /**
     * @lrd:start
     * Show an idea
     * @lrd:end
     */
    public function show(Idea $idea)
    {
        return $idea->load([
            'user:id,name',
            'category:id,name',
            'status:id,name',
        ]);
    }

    /**
     * @lrd:start
     * Create an idea.
     * @lrd:end
     *
     * @QAparam title string required max:255
     * @QAparam description string required
     * @QAparam categoryId integer required exists:categories,id
     */
    public function store(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $idea = new Idea();

        $idea->title = $request->title;
        $idea->description = $request->description;
        $idea->user_id = $request->user()->id;
        $idea->category_id = $request->categoryId;

        $idea->save();

        return ['message' => 'Ideia criada com sucesso.'];
    }

    /**
     * @lrd:start
     * Update an idea.
     * @lrd:end
     *
     * @QAparam title string required max:255
     * @QAparam description string required
     * @QAparam categoryId integer required exists:categories,id
     */
    public function update(Request $request, Idea $idea)
    {
        $this->authorize('update', $idea);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'categoryId' => 'required|exists:categories,id',
        ]);

        $idea->title = $request->title;
        $idea->description = $request->description;
        $idea->category_id = $request->categoryId;

        $idea->save();

        return ['message' => 'Ideia atualizada com sucesso.'];
    }

    /**
     * @lrd:start
     * Delete an idea.
     * @lrd:end
     */
    public function destroy(Idea $idea)
    {
        $this->authorize('delete', $idea);

        $idea->delete();

        return ['message' => 'Ideia removida com sucesso.'];
    }
}
