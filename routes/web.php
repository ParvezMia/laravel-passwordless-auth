<?php

use Illuminate\Support\Facades\Route;
use ParvezMia\LaravelPasswordlessAuth\Http\Controllers\PasswordlessLoginController;

Route::middleware('web')->group(function () {
    Route::get('/login/passwordless', [PasswordlessLoginController::class, 'showLoginForm'])->name('passwordless.login');
    Route::post('/login/passwordless', [PasswordlessLoginController::class, 'sendLoginLink'])->name('passwordless.send');
    Route::get('/login/passwordless/verify/{token}', [PasswordlessLoginController::class, 'verifyToken'])->name('passwordless.verify');
    Route::post('/logout', [PasswordlessLoginController::class, 'logout'])->name('passwordless.logout');
});
