<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\vendor\store\StoreController as vendorStoreController;
use App\Http\Controllers\vendor\auth\AuthController as VendorAuthController;
use App\Http\Controllers\vendor\product\ProductController as vendorProductController;
use App\Http\Controllers\client\AuthController as ClientAuthController;
use App\Http\Controllers\delivery\AuthController as DeliveryAuthController;
use App\Http\Controllers\delivery\OrderController;



Route::prefix('vendor')->group(function () {
    Route::post('/register', [VendorAuthController::class, 'register']);
    Route::post('/login', [VendorAuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [VendorAuthController::class, 'logout']);

        Route::prefix('stores')->group(function () {
            Route::post('/', [vendorStoreController::class, 'store']);
            Route::get('/', [vendorStoreController::class, 'show']);
            Route::put('/', [vendorStoreController::class, 'update']);
        });
    });
});

Route::prefix('client')->group(function () {
    Route::post('/register', [ClientAuthController::class, 'register']);
    Route::post('/login', [ClientAuthController::class, 'login']);
    Route::post('/logout', [ClientAuthController::class, 'logout'])->middleware('auth:api');
});



Route::prefix('delivery')->group(function () {
    Route::post('/register', [DeliveryAuthController::class, 'register']);
    Route::post('/login', [DeliveryAuthController::class, 'login']);
    Route::post('/logout', [DeliveryAuthController::class, 'logout'])->middleware('auth:api');
    Route::prefix('orders')->group(function () {
        Route::get('/get', [OrderController::class, 'getAllOrdersProcessing']);
        Route::post('/confirm/{order}', [OrderController::class, 'confirm_Order']);
    });
});

Route::post('products', [vendorProductController::class, 'store'])->middleware('auth:api');
