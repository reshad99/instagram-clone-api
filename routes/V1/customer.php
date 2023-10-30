<?php

use App\Http\Controllers\V1\Api\Address\AddressController;
use App\Http\Controllers\V1\Api\Auth\AuthController;
use App\Http\Controllers\V1\Api\Post\PostController;
use App\Http\Controllers\V1\Api\Status\StatusController;
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
    Route::post('update-profile', [AuthController::class, 'updateProfile']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::prefix('posts')->group(function () {
        Route::get('', [PostController::class, 'getPosts']);
        Route::get('/{post}', [PostController::class, 'showPost']);
        Route::post('save', [PostController::class, 'savePost']);
        Route::get('like/{post}', [PostController::class, 'likePost']);
        Route::post('comment/{post}', [PostController::class, 'addComment']);
        Route::get('likes/{post}', [PostController::class, 'showLikes']);
        Route::get('comments/{post}', [PostController::class, 'showComments']);
    });

    Route::prefix('statuses')->group(function () {
        Route::get('', [StatusController::class, 'getStatuses']);
        Route::post('/save-story', [StatusController::class, 'saveStory']);
        Route::get('/status/{status}', [StatusController::class, 'getStatus']);
        Route::get('/story/{story}', [StatusController::class, 'getStory']);
        Route::get('/view-story/{story}', [StatusController::class, 'viewStory']);
    });
});

Route::middleware('guest')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});
