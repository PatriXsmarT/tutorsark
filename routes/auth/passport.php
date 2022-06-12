<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Passport\CallbackController;
use App\Http\Controllers\Auth\Passport\RedirectController;
use App\Http\Controllers\Auth\Passport\RevokeTokenController;

/*
|--------------------------------------------------------------------------
| Passport Routes
|--------------------------------------------------------------------------
|
|
|
*/

// Oauth Redirect $ Callback...
Route::get('oauth/redirect',[RedirectController::class,'__invoke']);
Route::get('oauth/callback',[CallbackController::class,'__invoke']);
Route::any('oauth/revoke-token',[RevokeTokenController::class,'__invoke']);
