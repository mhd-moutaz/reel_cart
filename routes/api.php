<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\vendor\store\StoreController as vendorStoreController;
use App\Http\Controllers\vendor\auth\AuthController as VendorAuthController;
use App\Http\Controllers\vendor\product\ProductController as vendorProductController;
use App\Http\Controllers\client\AuthController as ClientAuthController;
use App\Http\Controllers\client\OrderController as ClientOrderController;
use App\Http\Controllers\delivery\AuthController as DeliveryAuthController;
use App\Http\Controllers\delivery\OrderController;



Route::prefix('vendor')->group(function () {
    // Vendor Auth Routes ----------------------------------------------------------
    Route::post('/register', [VendorAuthController::class, 'register']);
    Route::post('/login', [VendorAuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        // Vendor Auth Routes--------------------------------------------------------
        Route::post('/logout', [VendorAuthController::class, 'logout']);
        // Store Routes--------------------------------------------------------------
        Route::prefix('stores')->group(function () {
            Route::get('/', [vendorStoreController::class, 'show']);
            Route::post('/create', [vendorStoreController::class, 'store']);
            Route::put('/update', [vendorStoreController::class, 'update']);
        });
        // Product Routes------------------------------------------------------------
        Route::prefix('products')->group(function () {
            Route::get('/', [vendorProductController::class, 'index']);
            Route::post('/add', [vendorProductController::class, 'store']);
            Route::get('/{product}', [vendorProductController::class, 'show']);
            Route::put('/update/{product}', [vendorProductController::class, 'update']);
            Route::delete('/delete/{product}', [vendorProductController::class, 'destroy']);
            Route::delete('/removeImage/{image}', [vendorProductController::class, 'removeImage']);
        });
    });
});

Route::prefix('client')->group(function () {
    Route::post('/register', [ClientAuthController::class, 'register']);
    Route::post('/login', [ClientAuthController::class, 'login']);
    Route::post('/logout', [ClientAuthController::class, 'logout'])->middleware('auth:api');
    Route::prefix('orders')->group(function () {
        Route::post('/create', [ClientOrderController::class, 'create'])->middleware('auth:api');
        Route::get('/get', [ClientOrderController::class, 'index'])->middleware('auth:api');
    });
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


