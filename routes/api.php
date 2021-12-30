<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\WishController;

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
        Route::get('email/{id}', [UserController::class, 'email']);
        Route::get('index', [UserController::class, 'index']);
        Route::put('update/{id}', [UserController::class, 'update']);
    });
});

Route::group([
    'prefix' => 'books'
], function () {
    Route::get('index', [BookController::class, 'index']);
    Route::get('show/{id}', [BookController::class, 'show']);
    Route::get('search', [BookController::class, 'search']);
    Route::get('category/{id}', [BookController::class, 'category']);

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('isbn/{id}', [BookController::class, 'isbn']);
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
    Route::get('show/user/{id}', [BorrowController::class, 'byuser']);

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::post('store', [BorrowController::class, 'store']);
        Route::put('update/{id}', [BorrowController::class, 'update']);
        Route::delete('delete/{id}', [BorrowController::class, 'destroy']);
    });
});

Route::group([
    'prefix' => 'wish'
], function () {
    Route::get('index', [WishController::class, 'index']);
    Route::get('show/{id}', [WishController::class, 'show']);
    Route::get('show/user/{id}', [WishController::class, 'byuser']);

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::post('store', [WishController::class, 'store']);
        Route::put('update/{id}', [WishController::class, 'update']);
        Route::delete('delete/{id}', [WishController::class, 'destroy']);
    });
});
