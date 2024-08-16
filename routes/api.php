<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Asset\Models\Asset;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/delete' , function () {
    $asset = Asset::find(3);
    $asset->delete();
    return 1;
});
