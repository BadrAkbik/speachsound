<?php

use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\MobileVerificationNotificationController;
use App\Http\Controllers\Api\Auth\NewPasswordController;
use App\Http\Controllers\Api\Auth\RegisteredUserController;
use App\Http\Controllers\Api\Auth\TokenAuthController;
use App\Http\Controllers\Api\Auth\VerifyMobileController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/mobile/verification-notification', [MobileVerificationNotificationController::class, 'store'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');

    Route::post('/verify-mobile', VerifyMobileController::class)
        ->middleware(['throttle:6,1'])
        ->name('verification.verify');

    Route::delete('logout', [TokenAuthController::class, 'destroy'])->name('logout');
});

Route::post('login', [TokenAuthController::class, 'store'])->name('login');

Route::post('sendsms', [TokenAuthController::class, 'sendsms'])->name('sendsms')->middleware(['throttle:3,1']);

Route::post('/register', [RegisteredUserController::class, 'store'])->name('student.register');

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
