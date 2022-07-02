<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\Api\User\AvatarController;
use App\Http\Controllers\Api\User\ProfileController;

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
Broadcast::routes([
    'middleware' => ['auth:api'] // ['auth:sanctum']
]);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

require __DIR__.'/auth/api.php';

/**
 *
 */
Route::group([
    'namespace' => 'App\Http\Controllers\Api\User',
], function(){

    Route::get('/users/{user}/profile', [ProfileController::class, 'index']);
    Route::apiResource('users.profiles', ProfileController::class)->except('index')->shallow();

    Route::apiResource('users.avatars', AvatarController::class)->except('update')->shallow();
});
