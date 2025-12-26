<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\delivery\OrderController;
use App\Http\Controllers\vendor\reels\ReelController;
use App\Http\Controllers\client\AuthController as ClientAuthController;
use App\Http\Controllers\client\OrderController as ClientOrderController;
use App\Http\Controllers\delivery\AuthController as DeliveryAuthController;
use App\Http\Controllers\vendor\auth\AuthController as VendorAuthController;
use App\Http\Controllers\vendor\store\StoreController as vendorStoreController;
use App\Http\Controllers\vendor\product\ProductController as vendorProductController;


use App\Http\Controllers\delivery\OrderController as DeliveryOrderController;
use App\Models\Delivery;

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
            Route::delete('/removeReel/{reel}', [vendorProductController::class, 'removeReel']);
        });
        // Reel Routes--------------------------------------------------------------
        Route::prefix('reels')->group(function () {
            Route::get('/', [ReelController::class, 'index']);
            Route::post('/add', [ReelController::class, 'store']);
            Route::get('/{reel}', [ReelController::class, 'show']);
            Route::delete('/delete/{reel}', [ReelController::class, 'destroy']);
        });
    });
});

Route::prefix('client')->group(function () {
    Route::post('/register', [ClientAuthController::class, 'register']);
    Route::post('/login', [ClientAuthController::class, 'login']);
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [ClientAuthController::class, 'logout']);
        Route::prefix('orders')->group(function () {
            Route::post('/create', [ClientOrderController::class, 'create']);
            Route::get('/get', [ClientOrderController::class, 'index']);
        });

        Route::delete('/deleteCart/{cart}', [ClientOrderController::class, 'deleteCart']);
        Route::post('/confirm/{order}', [ClientOrderController::class, 'confirm_order']);
        Route::get('/allOrders', [ClientOrderController::class, 'showOrders']);
        Route::put('/updateCartQuantity/{cart}', [ClientOrderController::class, 'update_cart_quantity']);
        Route::put('/cancelOrder/{order}', [ClientOrderController::class, 'CancelOrder']);
    });
});



Route::prefix('delivery')->group(function () {
    Route::post('/register', [DeliveryAuthController::class, 'register']);
    Route::post('/login', [DeliveryAuthController::class, 'login']);
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [DeliveryAuthController::class, 'logout']);
        Route::prefix('orders')->group(function () {
            Route::get('/get', [DeliveryOrderController::class, 'getAllOrdersProcessing']);
            Route::post('/confirm/{order}', [DeliveryOrderController::class, 'confirm_Order']);
            Route::put('/updateMyOrder/{order}', [DeliveryOrderController::class, 'updateMyOrder']);
            Route::put('/cancelOrder/{order}', [DeliveryOrderController::class, 'cancelOrder']);
            Route::post('/show', [DeliveryOrderController::class, 'showMyOrder']);
        });
    });
});
