<?php

use Illuminate\Support\Facades\Route;
use Modules\Contracts\Http\Controllers\ContractsController;

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




Route::controller(ContractsController::class)
->prefix('contracts')
->group(function(){
    Route::post('add', 'add');
    Route::post('update', 'update');
    Route::get('list', 'list');
    Route::get('get', 'get');
    Route::get('disactive', 'disactive');
    Route::get('get-pdf', 'getPdf');
});