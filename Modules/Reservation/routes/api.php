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
    Route::get('list-public', 'listPublicEvents');
    Route::get('get', 'get');
    Route::get('list-tickets', 'listTickets');
    Route::post('reserve-tickets', 'reserveTicket');
    Route::get('update-payment', 'updatePayment');
    Route::get('update-ticket-payment', 'updateTicketPayment');
    Route::get('list-tickets-for-event', 'listTicketsForPublicEvent');
    Route::get('add-favorite', 'addPublicEventToFavorite');
    Route::get('get-favorites', 'getPublicEventFavorites');
    Route::get('get-categories-dash', 'getCategoriesForAdmin');
    Route::get('accept-category', 'AcceptCategory');
    Route::delete('delete-favorite', 'deletePublicEventFavorite');
});
