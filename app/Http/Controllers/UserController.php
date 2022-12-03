<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     *  Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return new UserCollection(User::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest   $request
     * @param  UserRepository $repository
     * @return Response
     */
    public function store(StoreRequest $request, UserRepository $repository)
    {
        $dataValidated = $request->validated();
        $dataValidated['password'] = $dataValidated['password'] ?? Hash::make(Str::random(8));
        $result = $repository->new($dataValidated);

        return response()->json($result, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return Response
     */
    public function show(User $user)
    {
        return (new UserResource($user))->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  User           $user
     * @param  UserRepository $repository
     * @return Response
     */
    public function update(
        UpdateRequest $request,
        User $user,
        UserRepository $repository
    ) {
        $dataValidated = $request->validated();
        $result = $repository->update($dataValidated, $user);

        return $result ?
            response()->json() :
            response()->json(['error: Não foi possível atualizar os dados.'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User           $user
     * @param  UserRepository $repository
     * @return Response
     */
    public function destroy(
        User $user,
        UserRepository $repository,
    ) {
        $result = $repository->delete($user);
        return $result ?
            response()->json(status: 204) :
            response()->json(['error: Não foi possível excluir os dados.'], 500);
    }
}
