<?php

use App\Helpers\AuthScopes;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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

Route::middleware('auth:sanctum')->prefix('/categories')->group(function () {
    Route::get('{categoryId}', [CategoryController::class, 'show'])->middleware(['ability:'. AuthScopes::SCOPE_CATEGORY_SHOW]);
    Route::post('/', [CategoryController::class, 'create'])->middleware(['ability:'. AuthScopes::SCOPE_CATEGORY_CREATE]);
    Route::put('{categoryId}', [CategoryController::class, 'update'])->middleware(['ability:'. AuthScopes::SCOPE_CATEGORY_UPDATE]);
    Route::delete('{categoryId}', [CategoryController::class, 'delete'])->middleware(['ability:'. AuthScopes::SCOPE_CATEGORY_UPDATE]);
    Route::get('/', [CategoryController::class, 'list'])->middleware(['ability:'. AuthScopes::SCOPE_CATEGORY_LIST]);
});

Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'create']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->get('/user-info', [AuthController::class, 'userInfo']);
    Route::put('/user-update', [AuthController::class, 'update'])->middleware(['auth:sanctum' ,'ability:'. AuthScopes::SCOPE_USER_UPDATE]);
});


