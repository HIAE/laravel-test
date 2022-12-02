<?php

namespace App\Http\Controllers;

use App\Http\Requests\Idea\StoreRequest;
use App\Http\Requests\Idea\UpdateRequest;
use App\Http\Resources\Idea\IdeaCollection;
use App\Http\Resources\Idea\IdeaResource;
use App\Models\Idea as IdeaModel;
use App\Repositories\Idea\IdeaRepository;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new IdeaCollection(IdeaModel::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, IdeaRepository $repository)
    {
        $dataValidated = $request->validated();
        $result = $repository->new($dataValidated);

        return response()->json($result, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  IdeaModel $idea
     * @return Response
     */
    public function show(IdeaModel $idea)
    {
        $idea = IdeaModel::with(['user', 'category'])->first();

        return new IdeaResource($idea);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  IdeaModel      $idea
     * @param  IdeaRepository $repository
     * @return Response
     */
    public function update(
        UpdateRequest $request,
        IdeaModel $idea,
        IdeaRepository $repository,
    ) {
        $dataValidated = $request->validated();
        $result = $repository->update($dataValidated, $idea);

        return $result ?
            response()->json() :
            response()->json(['error: Não foi possível atualizar os dados.'], 500);
    }

    /**
     *  Remove the specified resource from storage.
     *
     * @param  IdeaModel      $idea
     * @param  IdeaRepository $repository
     * @return Response
     */
    public function destroy(
        IdeaModel $idea,
        IdeaRepository $repository,
    ) {
        $result = $repository->delete($idea);

        return $result ?
            response()->json(status: 204) :
            response()->json(['error: Não foi possível excluir os dados.'], 500);
    }
}
