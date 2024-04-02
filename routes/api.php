<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\CarparkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {
    Route::apiResource('carpark', CarparkController::class);
    Route::apiResource('booking', BookingController::class);
    Route::post('carpark/{carpark}/space-check', [CarparkController::class, 'spaceCheck']);
    Route::get('carpark/{carpark}/spaces-for-next-week', [CarparkController::class, 'availableSpacesForNextWeek']);
});
