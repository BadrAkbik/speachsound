<?php

use App\Http\Controllers\Api\AgeController;
use App\Http\Controllers\Api\AiModelController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SoundController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('complete-profile', [UserController::class, 'completeProfile']);
   
    Route::get('sounds', [SoundController::class, 'index']);
    Route::get('ages', [AgeController::class, 'index']);
});
Route::post('upload', [AiModelController::class, 'upload_audio']);
Route::post('test', [AiModelController::class, 'test']);

