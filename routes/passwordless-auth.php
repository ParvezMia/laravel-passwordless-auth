<?php

/*
|--------------------------------------------------------------------------
| Passwordless Authentication Routes
|--------------------------------------------------------------------------
|
| This file contains the routes for passwordless authentication.
| Include this file in your web.php file using:
| require_once(base_path('routes/passwordless-auth.php'));
|
*/

use Illuminate\Support\Facades\Route;
use Jea\PasswordlessAuth\Http\Controllers\PasswordlessLoginController;

Route::group(['middleware' => ['web']], function () {
    Route::get('/login/passwordless', [PasswordlessLoginController::class, 'showLoginForm'])
        ->name('passwordless.login');
    
    Route::post('/login/passwordless', [PasswordlessLoginController::class, 'sendLoginLink'])
        ->name('passwordless.send');
    
    Route::get('/login/passwordless/verify/{token}', [PasswordlessLoginController::class, 'verifyToken'])
        ->name('passwordless.verify');
    
    Route::post('/logout', [PasswordlessLoginController::class, 'logout'])
        ->name('passwordless.logout')
        ->middleware('auth');
});