<?php

use App\Http\Controllers\Api\AiModelController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('complete-profile', [UserController::class, 'completeProfile']);
    
});
Route::post('upload', [AiModelController::class, 'upload_audio']);
Route::post('test', [AiModelController::class, 'test']);

