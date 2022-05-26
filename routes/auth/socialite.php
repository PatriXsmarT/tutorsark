<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Socialite\ProviderCallbackController;
use App\Http\Controllers\Auth\Socialite\ProviderRedirectController;


/*
|--------------------------------------------------------------------------
| Socialite Routes
|--------------------------------------------------------------------------
|
| Here is where you can register social login routes for your application.
|
*/


// Social Authentication...
Route::get('login/{provider}', [ProviderRedirectController::class,'__invoke']);
Route::get('login/{provider}/callback', [ProviderCallbackController::class,'__invoke']);
