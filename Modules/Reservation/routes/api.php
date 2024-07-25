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

Route::middleware('localizeApi', 'auth:sanctum') -> controller(ReservationController::class)
->prefix('reservations')
->group(function(){
    Route::post('add-reservation', 'reserveEvent');
    Route::get('list-times-hall', 'listTimesForHallOwner');
    Route::get('list-times-organizer', 'listTimesForOrganizer');
    Route::post('add-photo', 'addPhotoForPublicEvent');
    Route::get('list-categories', 'listCategories');
    Route::get('list-investor', 'listForInvestor');
    Route::get('list-user', 'listForUser');
});
