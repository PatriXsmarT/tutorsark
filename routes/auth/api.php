<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\UpdatePasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordConfirmationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('api.')->group(function () {
    /**
     * Login using Oauth client key and secret via authorization code.
     */
    require __DIR__.'/passport.php';

    /**
     * Login using social media account
     */
    require __DIR__.'/socialite.php';

    // Authentication...
    Route::get('user', [AuthenticationController::class, 'index']);
    Route::post('login', [AuthenticationController::class, 'store']);
    Route::post('logout', [AuthenticationController::class, 'logoutDevice'])->name('logout');

    // Registration...
    Route::post('register', [RegistrationController::class,'store']);

    // Password Confirmation...
    Route::post('confirm-password', [PasswordConfirmationController::class, 'store']);

    // Email Verification...
    Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationController::class, 'send'])->name('verification.send');

    // Forgot Password...
    Route::post('forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');

    // Password Reset...
    Route::post('reset-password', [PasswordResetController::class, 'store'])->name('password.update');

    // Update Password...
    Route::post('update-password', [UpdatePasswordController::class,'store']);
    Route::put('update-password', [UpdatePasswordController::class,'store']);
});
