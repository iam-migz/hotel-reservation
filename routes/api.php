<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/rooms', [RoomController::class, 'index']);
Route::prefix('/room')->group( function() {
    Route::get('/{id}', [RoomController::class, 'show']);
});

Route::get('/reservations', [ReservationController::class, 'index']);
Route::prefix('/reservation')->group( function() {
    Route::post('/store', [ReservationController::class, 'store']);
    Route::get('/room/{id}', [ReservationController::class, 'roomReservations']);
    Route::get('/{id}', [ReservationController::class, 'show']);
    Route::put('/{id}', [ReservationController::class, 'update']);
    Route::delete('/{id}', [ReservationController::class, 'destroy']);
});

Route::get('/user/{id}', [UserController::class, 'show']);


