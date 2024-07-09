<?php

use App\Http\Controllers\Api\AiModelControleller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('upload', [AiModelControleller::class, 'upload_audio']);
Route::post('test', [AiModelControleller::class, 'test']);

