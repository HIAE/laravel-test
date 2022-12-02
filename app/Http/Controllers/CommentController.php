<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment as CommentModel;
use App\Repositories\Comment\CommentRepository;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new CommentCollection(CommentModel::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, CommentRepository $repository)
    {
        $dataValidated = $request->validated();
        $result = $repository->new($dataValidated);

        return response()->json($result, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  CommentModel $comment
     * @return Response
     */
    public function show(CommentModel $comment)
    {
        $comment = CommentModel::with(['user', 'idea'])->first();

        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  CommentModel      $comment
     * @param  CommentRepository $repository
     * @return Response
     */
    public function update(
        UpdateRequest $request,
        CommentModel $comment,
        CommentRepository $repository,
    ) {
        $dataValidated = $request->validated();
        $result = $repository->update($dataValidated, $comment);

        return $result ?
            response()->json() :
            response()->json(['error: Não foi possível atualizar os dados.'], 500);
    }

    /**
     *  Remove the specified resource from storage.
     *
     * @param  CommentModel      $comment
     * @param  CommentRepository $repository
     * @return Response
     */
    public function destroy(
        CommentModel $comment,
        CommentRepository $repository,
    ) {
        $result = $repository->delete($comment);

        return $result ?
            response()->json(status: 204) :
            response()->json(['error: Não foi possível excluir os dados.'], 500);
    }
}
