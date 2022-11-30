<?php

namespace App\Http\Controllers;

use App\Http\Requests\Group\StoreRequest as GroupStoreRequest;
use App\Models\Group;
use App\Repositories\Group\GroupRepository;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupStoreRequest $request, GroupRepository $repository)
    {
        $dataValiated = $request->validated();
        $result = $repository->createNewGroup($dataValiated);

        return response()->json($result, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
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
        $result = $repository->deleteGroupById($group);
        return $result ? response(null, 204) : response(null, 500);
    }
}
