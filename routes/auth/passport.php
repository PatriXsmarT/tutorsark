<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Passport\CallbackController;
use App\Http\Controllers\Auth\Passport\RedirectController;
use App\Http\Controllers\Auth\Passport\ClientTokenController;
use App\Http\Controllers\Auth\Passport\RevokeTokenController;
use App\Http\Controllers\Auth\Passport\RefreshTokenController;
use App\Http\Controllers\Auth\Passport\ImplicitTokenController;
use App\Http\Controllers\Auth\Passport\PasswordTokenController;
use App\Http\Controllers\Auth\Passport\PersonalTokenController;

/*
|--------------------------------------------------------------------------
| Passport Routes
|--------------------------------------------------------------------------
|
|
|
*/

// Oauth Token Management...
Route::any('oauth/redirect',[RedirectController::class,'__invoke']);

Route::get('oauth/callback',[CallbackController::class,'__invoke']);

Route::post('oauth/client-token',[ClientTokenController::class,'__invoke']);

Route::post('oauth/implicit-token',[ImplicitTokenController::class,'__invoke']);

Route::post('oauth/password-token',[PasswordTokenController::class,'__invoke']);

Route::post('oauth/personal-token',[PersonalTokenController::class,'__invoke']);

Route::post('oauth/refresh-token',[RefreshTokenController::class,'__invoke']);

Route::any('oauth/revoke-token',[RevokeTokenController::class,'__invoke']);
