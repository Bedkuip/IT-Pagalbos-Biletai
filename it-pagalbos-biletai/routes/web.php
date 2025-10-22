<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkplaceController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return view('welcome');
});

// API maršrutai be CSRF
Route::prefix('api/v1')
    ->middleware('api')
    ->group(function () {
        Route::get('/ping', fn() => response()->json(['pong' => true]));

        Route::apiResource('workplaces', WorkplaceController::class);
        Route::apiResource('devices', DeviceController::class);
        Route::apiResource('tickets', TicketController::class);
    });

