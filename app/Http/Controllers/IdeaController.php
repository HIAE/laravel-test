<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdeaRequest;
use App\Models\Idea;
use App\Services\IdeaService;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    protected $service;

    public function __construct(IdeaService $service)
    {
        $this->service = $service;
    }

    /**
     * @lrd:start
     * List ideas
     * @lrd:end
     *
     * @QAparam category integer nullable
     * @QAparam q string nullable
     * @QAparam status integer nullable
     */
    public function index(Request $request)
    {
        return $this->service->getAllIdeas($request);
    }

    /**
     * @lrd:start
     * Show an idea
     * @lrd:end
     */
    public function show(Idea $idea)
    {
        return $this->service->showIdea($idea);
    }

    /**
     * @lrd:start
     * Create an idea.
     * @lrd:end
     */
    public function store(IdeaRequest $request)
    {
        $this->service->createIdea($request);

        return ['message' => 'Ideia criada com sucesso.'];
    }

    /**
     * @lrd:start
     * Update an idea.
     * @lrd:end
     */
    public function update(IdeaRequest $request, Idea $idea)
    {
        $this->authorize('update', $idea);

        $this->service->updateIdea($idea, $request);

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

        $this->service->destroyIdea($idea);

        return ['message' => 'Ideia removida com sucesso.'];
    }
}
