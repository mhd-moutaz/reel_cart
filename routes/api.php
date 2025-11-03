<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\vendor\StoreController;
use App\Http\Controllers\vendor\ProductController;
use App\Http\Controllers\client\AuthController as ClientAuthController;
use App\Http\Controllers\vendor\AuthController as VendorAuthController;
use App\Http\Controllers\delivery\AuthController as DeliveryAuthController;
=======
use App\Http\Controllers\client\AuthController as ClientAuthController;
use App\Http\Controllers\delivery\AuthController as DeliveryAuthController;
use App\Http\Controllers\delivery\OrderController;
use App\Http\Controllers\vendor\AuthController as VendorAuthController;
use App\Http\Controllers\vendor\StoreController;

>>>>>>> 12c093aa3fac98a9bf8a67e92719b69c1830755d
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('vendor')->group(function () {
    Route::post('/register', [VendorAuthController::class, 'register']);
    Route::post('/login', [VendorAuthController::class, 'login']);
    Route::post('/logout', [VendorAuthController::class, 'logout'])->middleware('auth:api');
});

Route::prefix('client')->group(function () {
    Route::post('/register', [ClientAuthController::class, 'register']);
    Route::post('/login', [ClientAuthController::class, 'login']);
    Route::post('/logout', [ClientAuthController::class, 'logout'])->middleware('auth:api');
});


Route::post('/stores', [StoreController::class, 'store'])->middleware('auth:api');

Route::prefix('delivery')->group(function () {
    Route::post('/register', [DeliveryAuthController::class, 'register']);
    Route::post('/login', [DeliveryAuthController::class, 'login']);
    Route::post('/logout', [DeliveryAuthController::class, 'logout'])->middleware('auth:api');
    Route::prefix('orders')->group(function () {
        Route::get('/get', [OrderController::class, 'getAllOrdersProcessing']);
        Route::post('/confirm/{order}', [OrderController::class, 'confirm_Order']);
    });
});
<<<<<<< HEAD

Route::post('products', [ProductController::class, 'store'])->middleware('auth:api');


=======
>>>>>>> 12c093aa3fac98a9bf8a67e92719b69c1830755d
