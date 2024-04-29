<?php

use Illuminate\Support\Facades\Route;
use Modules\Event\Http\Controllers\EventController;
use Modules\Event\Http\Controllers\ServiceController;

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

Route::middleware('localizeApi')->controller(ServiceController::class)
->prefix('service')
->group(function() {
    Route::post('create','create');
    Route::post('update','update');
    Route::get('get','get');
});