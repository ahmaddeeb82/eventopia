<?php

use Illuminate\Support\Facades\Route;
use Modules\Asset\Http\Controllers\AssetController;

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

Route::middleware('localizeApi', 'auth:sanctum')->controller(AssetController::class)
->prefix('assets')
->group(function() {
    Route::post('add-info','add');
    Route::post('add-photos','addPhotos');
    Route::post('update-hall','update');
    Route::post('update-service','updateSereviceForOrganizer');
    Route::post('add-services','addServicesForOrganizer');
    Route::get('get','get');
    Route::get('list','list');
    Route::get('list-for-investor','listForInvestor');
    Route::put('rate','rate');
    Route::get('recent', 'recentlyAdded');
    Route::get('favorite' , 'addToFavorite');
    Route::get('get-favorites' , 'getFavorites');
    Route::get('get-filters' , 'getFilters');
    Route::delete('delete-favorite' , 'deleteFavorite');
    Route::delete('delete-service' , 'deleteService');
    Route::delete('delete' , 'deleteAsset');
    Route::delete('delete-time' , 'deleteTime');
    Route::get('get-analytics' , 'getAnalytics');
});
