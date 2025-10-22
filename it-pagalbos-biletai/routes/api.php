<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkplaceController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\TicketController;

Route::prefix('v1')->group(function () {
    // Paprastas ping testas
    Route::get('/ping', function () {
        return response()->json(['pong' => true]);
    });

    // CRUD resursai
    Route::apiResource('workplaces', WorkplaceController::class);
    Route::apiResource('devices', DeviceController::class);
    Route::apiResource('tickets', TicketController::class);
    Route::get('/test', fn() => 'works');

});

/*
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkplaceController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\TicketController;

Route::prefix('v1')->group(function () {
  // Auth
  Route::post('/auth/register', [AuthController::class, 'register']);
  Route::post('/auth/login', [AuthController::class, 'login']);
  Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/me', [AuthController::class, 'update']);
  });

Route::get('/ping', function () {
    return response()->json(['pong' => true]);
});

Route::get('/ping', [PingController::class, 'ping']);

  // Protected CRUD
  Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('workplaces', WorkplaceController::class);
    Route::apiResource('devices', DeviceController::class);
    Route::apiResource('tickets', TicketController::class);
  });

  // Public filtered lists for fast demo
  Route::get('tickets', [TicketController::class, 'index']);
  Route::get('devices', [DeviceController::class, 'index']);
  Route::get('workplaces', [WorkplaceController::class, 'index']);

  // Public CRUD routes (no Sanctum)
Route::apiResource('workplaces', WorkplaceController::class);
Route::apiResource('devices', DeviceController::class);
Route::apiResource('tickets', TicketController::class);
});
*/