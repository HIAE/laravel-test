<?php

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
    Route::get('{categoryId}', [CategoryController::class, 'show']);
    Route::post('/', [CategoryController::class, 'create']);
    Route::put('{categoryId}', [CategoryController::class, 'update']);
    Route::delete('{categoryId}', [CategoryController::class, 'delete']);
    Route::get('/', [CategoryController::class, 'list']);
});

Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'create']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->get('/user-info', [AuthController::class, 'userInfo']);
});


