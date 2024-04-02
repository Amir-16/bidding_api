<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BidController;
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

Route::controller(AuthController::class)->group(function () {

    Route::post('/register', 'register')->middleware('throttle:10,1');
    Route::post('/login', 'login')->middleware('throttle:10,1');
    Route::post('/logout', 'logout');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/bid', [BidController::class, 'handleBidRequest']);

});
