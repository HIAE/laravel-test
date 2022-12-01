<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category as CategoryModel;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new CategoryCollection(CategoryModel::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest       $request
     * @param  CategoryRepository $repository
     * @return Response
     */
    public function store(StoreRequest $request, CategoryRepository $repository)
    {
        $dataValidated = $request->validated();
        $result = $repository->new($dataValidated);

        return response()->json($result, 201);
    }

    /**
     *  Display the specified resource.
     *
     * @param  CategoryModel $category
     * @return Response
     */
    public function show(CategoryModel $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest      $request
     * @param  CategoryModel      $category
     * @param  CategoryRepository $repository
     * @return Response
     */
    public function update(
        UpdateRequest $request,
        CategoryModel $category,
        CategoryRepository $repository
    ) {
        $dataValidated = $request->validated();
        $result = $repository->update($dataValidated, $category);

        return $result ?
            response()->json() :
            response()->json(['error: Não foi possível atualizar os dados.'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CategoryModel      $category
     * @param  CategoryRepository $repository
     * @return Response
     */
    public function destroy(
        CategoryModel $category,
        CategoryRepository $repository,
    ) {
        $result = $repository->delete($category);

        return $result ?
            response()->json(status: 204) :
            response()->json(['error: Não foi possível excluir os dados.'], 500);
    }
}
