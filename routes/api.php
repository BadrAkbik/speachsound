<?php

use App\Http\Controllers\Api\AgeController;
use App\Http\Controllers\Api\AiModelController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SoundController;
use App\Http\Controllers\Api\RatingController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('complete-profile', [UserController::class, 'completeProfile']);
   
    Route::get('sounds', [SoundController::class, 'index']);
    Route::get('ages', [AgeController::class, 'index']);

    Route::post('subscribe', [SubscriptionController::class, 'subscribe'])->middleware('completed-profile');

    Route::get('plans', [PlanController::class, 'index']);

    Route::get('current-subscription', [SubscriptionController::class, 'currentSubscription']);

    Route::get('ratings/{sound_id?}', [RatingController::class, 'index'])->whereNumber('sound_id');
    
    Route::get('levels/{sound_id}', [LevelController::class, 'index'])->whereNumber('sound_id');

    Route::get('progress', [RatingController::class, 'currentProgress']);
});
Route::post('upload', [AiModelController::class, 'upload_audio']);
Route::post('test', [AiModelController::class, 'test']);

