<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])
    ->name('login');


Route::prefix('admin')->name('admin.')->group(
    function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login');

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

        Route::get('/dashboard', [AuthController::class, 'showDashboardForm'])->name('dashboard');
        
        Route::get('/users', [AuthController::class, 'showUsersForm'])->name('users');
    }
);
