<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resource('/categories', CategoryController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    Route::resource('/ideas', IdeaController::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);

    Route::resource('/ideas/{idea}/comments', CommentController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    Route::resource('/ideas/{idea}/votes', VoteController::class)
        ->only(['store', 'destroy']);

    Route::resource('/status', StatusController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    Route::patch('/users/{user}/photo', [UserController::class, 'photo']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'delete']);
    Route::get('/users', [UserController::class, 'index']);
});

Route::post('/login', [LoginController::class, 'store']);

Route::post('/users', [UserController::class, 'store']);
