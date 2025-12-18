<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkplaceController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/refresh', [AuthController::class, 'refresh']);
Route::post('/auth/logout', [AuthController::class, 'logout']);

Route::prefix('v1')->group(function () {
    // Simple ping test
    Route::get('/ping', function () {
        return response()->json(['pong' => true]);
    });

    
        // Dropdown endpoints
    Route::get('/workplaces/all', function () {
        return \App\Models\Workplace::all();
    });

    Route::get('/devices/all', function () {
        return \App\Models\Device::all();
    });
    
    // Protected CRUD resources
    Route::middleware('jwt')->group(function () {
        Route::apiResource('workplaces', WorkplaceController::class);
        Route::apiResource('devices', DeviceController::class);
        Route::apiResource('tickets', TicketController::class);
    });


    
    Route::get('/test', fn() => 'works');
});