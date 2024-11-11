<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TagsController;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\TwoFactorAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [ApiAuthController::class, 'login'])->name('login');


Route::group(["middleware" => ['auth:sanctum'] ], function () {
    Route::prefix('products')->group(function (){
        Route::get('/search', [ProductController::class, 'search']);
        Route::get('/price-range', [ProductController::class, 'filterByPriceRange']);

        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{id}', [ProductController::class, 'showById']);
        Route::post('/', [ProductController::class, 'store']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'delete']);
        
    });
    Route::prefix('orders')->group(function (){
        Route::get('/', [OrderController::class, 'index']);
        Route::get('/{id}', [OrderController::class, 'showById']);
        Route::post('/', [OrderController::class, 'store']);
        Route::delete('/{id}', [OrderController::class, 'delete']);

    });

    // Route::get('/stats', [AdminController::class, 'stats']);
});
