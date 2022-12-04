<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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

Route::prefix('/categories')->group(function () {
    Route::get('{categoryId}', [CategoryController::class, 'show']);
    Route::post('/', [CategoryController::class, 'create']);
    Route::put('{categoryId}', [CategoryController::class, 'update']);
    Route::delete('{categoryId}', [CategoryController::class, 'delete']);
    Route::get('/', [CategoryController::class, 'list']);
});

Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/user-info', [AuthController::class, 'userInfo']);
});

Route::post('/login', function (Request $request) {
    dump($request->cookie('token'));

    if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
        $user = Auth::user();
        $token = $user->createToken('JWT');

        return response()
            ->json($token, 200);
    }
    return response()->json('Usuario invalido', 401);
});

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
    return ['token' => $token->plainTextToken];
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


