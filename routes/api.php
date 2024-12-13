<?php

use App\Http\Controllers\Api\V1\AdminOrderController;
use App\Http\Controllers\Api\V1\AdminProductController;
use App\Http\Controllers\Api\V1\BasketItemController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {

    //Регистрация, авторизация
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

    //BasketItem
    Route::apiResource('/basket-items', BasketItemController::class)->only(['index', 'store', 'destroy'])->middleware('auth:sanctum');
    Route::post('/basket-items/bulk-store', [BasketItemController::class, 'bulkStore'])->middleware('auth:sanctum');

    //Product
    Route::apiResource('/products', ProductController::class)->only(['index', 'show']);

    //Order
    Route::apiResource('/orders', OrderController::class)->only(['index', 'show', 'store'])->middleware('auth:sanctum');

    //Admin
    Route::apiResource('/admin/products', AdminProductController::class)->middleware('admin');
    Route::apiResource('/admin/orders', AdminOrderController::class)->only(['index'])->middleware('admin');
    Route::patch('admin/order-change-status/{order}', [AdminOrderController::class, 'changeStatus'])->middleware('admin');
});


