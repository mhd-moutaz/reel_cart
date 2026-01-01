<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.login.form');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // صفحات غير محمية
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    // صفحات محمية
    Route::middleware(['auth:web'])->group(function () {
        Route::get('/dashboard', [AuthController::class, 'showDashboardForm'])->name('dashboard');
        Route::get('/stores', [AuthController::class, 'showStoresForm'])->name('stores');
        Route::post('/stores/{store}/update-verification', [AuthController::class, 'updateVerification'])
            ->name('admin.stores.update-verification');
        Route::get('/users', [AuthController::class, 'showUsersForm'])->name('users');
        Route::get('/vendors', [AuthController::class, 'showVendorsForm'])->name('vendors');
        // في ملف routes/web.php
        Route::post('/users/{user}/update-verification', [AuthController::class, 'updateVerification'])
            ->name('admin.users.update-verification')
            ->middleware(['auth', 'admin']);
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
