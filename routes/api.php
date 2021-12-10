<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'users'
], function () {
    Route::post('register', [UserController::class, 'store']);
    Route::post('login', [UserController::class, 'login']);

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('show/{id}', [UserController::class, 'show']);
        Route::get('index', [UserController::class, 'index']);
        Route::put('update/{id}', [UserController::class, 'update']);
    });
});

Route::group([
    'prefix' => 'books'
], function () {
    Route::get('index', [BookController::class, 'index']);
    Route::get('show/{id}', [BookController::class, 'show']);

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::post('store', [BookController::class, 'store']);
        Route::post('update/{id}', [BookController::class, 'update']);
        Route::delete('delete/{id}', [BookController::class, 'destroy']);
    });
});

Route::group([
    'prefix' => 'borrow'
], function () {
    Route::get('index', [BorrowController::class, 'index']);
    Route::get('show/{id}', [BorrowController::class, 'show']);

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::post('store', [BorrowController::class, 'store']);
        Route::put('update/{id}', [BorrowController::class, 'update']);
        Route::delete('delete/{id}', [BorrowController::class, 'destroy']);
    });
});
