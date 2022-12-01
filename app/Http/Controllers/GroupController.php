<?php

namespace App\Http\Controllers;

use App\Http\Requests\Group\StoreRequest as GroupStoreRequest;
use App\Http\Requests\Group\UpdateRequest;
use App\Http\Resources\GroupCollection;
use App\Models\Group;
use App\Repositories\Group\GroupRepository;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new GroupCollection(Group::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupStoreRequest $request, GroupRepository $repository)
    {
        $dataValidated = $request->validated();
        $result = $repository->new($dataValidated);

        return response()->json($result, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group, GroupRepository $repository)
    {
        return response()->json($group->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  Group         $group
     * @return Response
     */
    public function update(UpdateRequest $request, Group $group, GroupRepository $repository)
    {
        $dataValidated = $request->validated();
        $result = $repository->updateById($dataValidated, $group);

        return $result ?
            response()->json() :
            response()->json(['error: Não foi possível atualizar os dados.'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Group           $group
     * @param  GroupRepository $repository
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Group $group,
        GroupRepository $repository,
    ) {
        $result = $repository->deleteById($group);
        return $result ?
            response()->json(status: 204) :
            response()->json(['error: Não foi possível excluir os dados.'], 500);
    }
}
