<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\Users\RoleController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatatableController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resources([
        'users' => UserController::class,
        'roles' => RoleController::class,
    ]);
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('datatable/{table}', [DatatableController::class, 'handle'])
        ->name('datatable.source');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'loginPage'])->name('loginPage');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});
