<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Passport\CallbackController;
use App\Http\Controllers\Auth\Passport\RedirectController;
use App\Http\Controllers\Auth\Passport\ClientTokenController;
use App\Http\Controllers\Auth\Passport\RevokeTokenController;
use App\Http\Controllers\Auth\Passport\RefreshTokenController;
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

// Oauth Redirect $ Callback...
Route::get('redirect',[RedirectController::class,'__invoke']);
Route::get('callback',[CallbackController::class,'__invoke']);

// Oauth Token Management...
Route::any('client-token',[ClientTokenController::class,'__invoke']);
Route::any('password-token',[PasswordTokenController::class,'__invoke']);
Route::any('personal-token',[PersonalTokenController::class,'__invoke']);
Route::any('refresh-token',[RefreshTokenController::class,'__invoke']);
Route::any('revoke-token',[RevokeTokenController::class,'__invoke']);
