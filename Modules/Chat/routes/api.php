<?php

use Illuminate\Support\Facades\Route;
use Modules\Chat\Http\Controllers\ChatController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('chat', ChatController::class)->names('chat');
});

Route::post('/send-message', [ChatController::class, 'sendMessage']);
Route::post('/join-room', [ChatController::class, 'joinRoom']);
Route::post('/leave-room', [ChatController::class, 'leaveRoom']);
