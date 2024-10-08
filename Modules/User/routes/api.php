<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\ProfileController;
use Modules\User\Http\Controllers\UserController;

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
    Route::apiResource('user', UserController::class)->names('user');
});

Route::controller(UserController::class)
->prefix('auth')
->group(function(){
    Route::post('register', 'register');
    Route::post('add-user', 'addUser')->middleware(['auth:sanctum','role:Admin']);
    Route::get('list-investors', 'listInvestors')->middleware(['auth:sanctum','role:Admin']);
    Route::get('get-investor', 'getWithContract')->middleware(['auth:sanctum','role:Admin']);
    Route::post('login','login');
    Route::post('forget-password','forgetPassword');
    Route::post('res-pass-verification','checkOtp');
    Route::post('reset-password','resetPassword');
    Route::get('logout','logout')->middleware(['auth:sanctum']);
    Route::post('email-verification','emaiVerification')->middleware(['auth:sanctum']);
    Route::post('add-cart', 'addToCart')->middleware(['auth:sanctum']);
    
});

Route::controller(ProfileController::class)
->middleware('auth:sanctum')
->prefix('profile')
->group( function () {
    Route::get('get', 'get');
    Route::post('update','update');
    Route::post('set-photo', 'setPhoto');
    Route::delete('delete-photo', 'deletePhoto');
});
Route::get('profile/viewC', [ProfileController::class,'viewContract']);
Route::get('profile/viewR', [ProfileController::class,'viewReport']);
