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

Route::prefix('/users/')->group(function () {
    Route::get('{user}', [UserController::class, 'show'])->name('user.show');
    Route::post('/', [UserController::class, 'store'])->name('user.store');
    Route::put('{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/', [UserController::class, 'index'])->name('user.index');
});

Route::prefix('/groups/')->group(function () {
    Route::get('{group}', [GroupController::class, 'show'])->name('group.show');
    Route::post('/', [GroupController::class, 'store'])->name('group.store');
    Route::put('{group}', [GroupController::class, 'update'])->name('group.update');
    Route::delete('{group}', [GroupController::class, 'destroy'])->name('group.destroy');
    Route::get('/', [GroupController::class, 'index'])->name('group.index');
});

Route::prefix('/votes/')->group(function () {
    Route::get('{vote}', [VoteController::class, 'show'])->name('vote.show');
    Route::post('/', [VoteController::class, 'store'])->name('vote.store');
    Route::put('{vote}', [VoteController::class, 'update'])->name('vote.update');
    Route::delete('{vote}', [VoteController::class, 'destroy'])->name('vote.destroy');
    Route::get('/', [VoteController::class, 'index'])->name('vote.index');
});

Route::prefix('/comments/')->group(function () {
    Route::get('{comment}', [CommentController::class, 'show'])->name('comment.show');
    Route::post('/', [CommentController::class, 'store'])->name('comment.store');
    Route::put('{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
    Route::get('/', [CommentController::class, 'index'])->name('comment.index');
});

Route::prefix('/ideas/')->group(function () {
    Route::get('{idea}', [IdeaController::class, 'show'])->name('idea.show');
    Route::post('/', [IdeaController::class, 'store'])->name('idea.store');
    Route::put('{idea}', [IdeaController::class, 'update'])->name('idea.update');
    Route::delete('{idea}', [IdeaController::class, 'destroy'])->name('idea.destroy');
    Route::get('/', [IdeaController::class, 'index'])->name('idea.index');
});

Route::prefix('/categories/')->group(function () {
    Route::get('{category}', [CategoryController::class, 'show'])->name('category.show');
    Route::post('/', [CategoryController::class, 'store'])->name('category.store');
    Route::put('{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');
});
