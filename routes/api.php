<?php

use App\Http\Controllers\userController;
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

Route::prefix('v1')->group(function () {
    Route::get('/', function () {
        return response()->json(['message' => 'Welcome to API']);
    });
    //------------------- User route ------------------------------------------
    Route::prefix('user')->group(function () {
        Route::post('/register', [userController::class, 'register']);
        Route::post('/login', [userController::class, 'login']);
        Route::middleware('auth:sanctum')->group(function () {
            Route::put('/update', [userController::class, 'update']);
            Route::put('/change-password', [userController::class, 'changePassword']);
        });
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
