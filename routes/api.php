<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\userController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\blogController;
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
    // ------------------Admin routes----------------------
    Route::prefix('Auth')->group(function () {
        Route::post('/signup', [AuthController::class, 'signup']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::middleware('auth:admin')->get('/logout', [AuthController::class, 'logout']);
    });
    // ------------------User routes----------------------
    Route::prefix('user')->group(function () {
        Route::post('/register', [userController::class, 'register']);
        Route::post('/login', [userController::class, 'login']);
        Route::middleware('auth:sanctum')->group(function () {
            Route::put('/update', [userController::class, 'update']);
            Route::put('/change-password', [userController::class, 'changePassword']);
            Route::get('/logout', [userController::class, 'logout']);
        });
    });
    // -------------Categories Route--------------------------------
    Route::prefix('category')->group(function () {
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::post('/add', [CategoryController::class, 'store']);
            Route::get('/{id}', [categoryController::class, 'show']);
            Route::put('/{id}', [CategoryController::class, 'update']);
            Route::delete('/{id}', [CategoryController::class, 'destroy']);
            Route::get('search/{search}', [CategoryController::class, 'search']);
       
        });

 
    });

    // -------------Blog Route--------------------------------
    Route::prefix('Blog')->group(function () {
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/', [blogController::class, 'getAllBlog']);
            Route::post('/add', [blogController::class, 'addBlog']);
            Route::put('/edit/{id}', [blogController::class, 'update']);
            Route::delete('/{id}', [blogController::class, 'destroy']);
            Route::get('search/{search}', [blogController::class, 'search']);
            Route::get('/{id}', [blogController::class, 'show']);


        });
    });
    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
