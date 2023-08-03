<?php

use App\Http\Controllers\V1\Api\Address\AddressController;
use App\Http\Controllers\V1\Api\Auth\AuthController;
use App\Http\Controllers\V1\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:customer', 'throttle:60,1'])->group(function () {
    Route::get('test', [TestController::class, 'test']);
    Route::get('favorite-addresses', [AddressController::class, 'favoriteAddresses']);
    Route::post('update-profile', [AuthController::class, 'updateProfile']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('guest')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});
