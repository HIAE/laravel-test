<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\IdeaController;
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

Route::prefix('/users/')->group(function () {
    Route::get('{user}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('{user}', [UserController::class, 'update']);
    Route::delete('{user}', [UserController::class, 'destroy']);
    Route::get('/', [UserController::class, 'index']);
});

Route::prefix('/groups/')->group(function () {
    Route::get('{group}', [GroupController::class, 'show'])->name('group.show');
    Route::post('/', [GroupController::class, 'store'])->name('group.store');
    Route::put('{group}', [GroupController::class, 'update'])->name('group.update');
    Route::delete('{group}', [GroupController::class, 'destroy'])->name('group.destroy');
    Route::get('/', [GroupController::class, 'index'])->name('group.index');
});

Route::prefix('/votes/')->group(function () {
    Route::get('{vote}', [VoteController::class, 'show']);
    Route::post('/', [VoteController::class, 'store']);
    Route::put('{vote}', [VoteController::class, 'update']);
    Route::delete('{vote}', [VoteController::class, 'destroy']);
    Route::get('/', [VoteController::class, 'index']);
});

Route::prefix('/comments/')->group(function () {
    Route::get('{comment}', [CommentController::class, 'show']);
    Route::post('/', [CommentController::class, 'store']);
    Route::put('{comment}', [CommentController::class, 'update']);
    Route::delete('{comment}', [CommentController::class, 'destroy']);
    Route::get('/', [CommentController::class, 'index']);
});

Route::prefix('/ideas/')->group(function () {
    Route::get('{idea}', [IdeaController::class, 'show']);
    Route::post('/', [IdeaController::class, 'store']);
    Route::put('{idea}', [IdeaController::class, 'update']);
    Route::delete('{idea}', [IdeaController::class, 'destroy']);
    Route::get('/', [IdeaController::class, 'index']);
});

Route::prefix('/categories/')->group(function () {
    Route::get('{category}', [CategoryController::class, 'show']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::put('{category}', [CategoryController::class, 'update']);
    Route::delete('{category}', [CategoryController::class, 'destroy']);
    Route::get('/', [CategoryController::class, 'index']);
});

Route::get('/hello/', function () {
    return JSON_ENCODE('Hello World!');
});
