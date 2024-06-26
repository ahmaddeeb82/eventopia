<?php

use Illuminate\Support\Facades\Route;
use Modules\Reservation\Http\Controllers\ReservationController;

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
    Route::apiResource('reservation', ReservationController::class)->names('reservation');
});

Route::middleware('localizeApi') -> controller(ReservationController::class)
->prefix('reservation')
->group(function(){
    Route::post('add', 'add');
    Route::get('getInfo', 'getInfo');
});
