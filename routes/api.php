<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\GuestReservationController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('check-stock/{startDay}/{endDay}/{roomMasterId}/{stayingPlanId}', [GuestReservationController::class, 'checkStock']);
