<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
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

// Route::middleware('auth:sanctum')->prefix('api')
//     ->get('/user', function (Request $request) {
//         return $request->user();
//     });

// Route::group(['prefix' => 'auth', 'namespace' => 'Api'], function () {

//     Route::post('register',     'AuthController@register');
//     Route::post('login',        'AuthController@login');

//     Route::group(['middleware' => 'auth:sanctum'], function () {
//         Route::get('logout',    'AuthController@logout');
//         Route::get('user',      'AuthController@getUser');
//     });

//     Route::any('{segment}', function () {
//         return response()->json(['error' => 'Bad request.'], 400);
//     })->where('segment', '.*');
// });

Route::prefix('/user/')->group(function () {
    Route::get('{user}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('{user}/update', [UserController::class, 'update']);
    Route::delete('{user}/delete', [UserController::class, 'destroy']);
    Route::get('{user}/list', [UserController::class, 'index']);
});

Route::prefix('/group/')->group(function () {
    Route::get('{group}', [GroupController::class, 'show']);
    Route::post('/', [GroupController::class, 'store'])->name('group.store');
    Route::put('{group}/update', [GroupController::class, 'update']);
    Route::delete('{group}/delete', [GroupController::class, 'destroy'])->name('group.destroy');
    Route::get('{group}/list', [GroupController::class, 'index']);
});

Route::prefix('/vote/')->group(function () {
    Route::get('{vote}', [VoteController::class, 'show']);
    Route::post('/', [VoteController::class, 'store']);
    Route::put('{vote}/update', [VoteController::class, 'update']);
    Route::delete('{vote}/delete', [VoteController::class, 'destroy']);
    Route::get('{vote}/list', [VoteController::class, 'index']);
});

Route::prefix('/comment/')->group(function () {
    Route::get('{comment}', [CommentController::class, 'show']);
    Route::post('/', [CommentController::class, 'store']);
    Route::put('{comment}/update', [CommentController::class, 'update']);
    Route::delete('{comment}/delete', [CommentController::class, 'destroy']);
    Route::get('{comment}/list', [CommentController::class, 'index']);
});

Route::prefix('/idea/')->group(function () {
    Route::get('{idea}', [IdeaController::class, 'show']);
    Route::post('/', [IdeaController::class, 'store']);
    Route::put('{idea}/update', [IdeaController::class, 'update']);
    Route::delete('{idea}/delete', [IdeaController::class, 'destroy']);
    Route::get('{idea}/list', [IdeaController::class, 'index']);
});

Route::prefix('/category/')->group(function () {
    Route::get('{category}', [CategoryController::class, 'show']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::put('{category}/update', [CategoryController::class, 'update']);
    Route::delete('{category}/delete', [CategoryController::class, 'destroy']);
    Route::get('{category}/list', [CategoryController::class, 'index']);
});

Route::get('/hello/', function () {
    return JSON_ENCODE('Hello World!');
});
