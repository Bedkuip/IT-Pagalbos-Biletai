<?php

use Illuminate\Support\Facades\Route;
use App\Models\Workplace;
use App\Http\Controllers\DashboardController;

// Login page
Route::get('/', function () {
    return view('auth.login');
})->name('login');

// Tickets page (su workplaces)
Route::get('/tickets', function () {
    return view('tickets.index', [
        'workplaces' => Workplace::all()
    ]);
});

// Kiti puslapiai
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/devices', fn() => view('devices.index'));
Route::get('/tickets/create', fn() => view('tickets.create'));
Route::get('/tickets/{id}/edit', fn($id) => view('tickets.edit', ['id' => $id]));





/*
use Illuminate\Support\Facades\Route;
#use App\Http\Controllers\WorkplaceController;
#use App\Http\Controllers\DeviceController;
#use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Auth;

// Root URL → Login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes (disable registration)
Auth::routes(['register' => false]);

// Protected routes (only accessible after login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // create resources/views/dashboard.blade.php
    })->name('dashboard');
});
*/
/*
Route::get('/', function () {
    return redirect()->route('login');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // other protected routes...
});

*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/
/*
// API maršrutai be CSRF
Route::prefix('api/v1')
    ->middleware('api')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->group(function () {
        Route::apiResource('workplaces', WorkplaceController::class);
        Route::apiResource('devices', DeviceController::class);
        Route::apiResource('tickets', TicketController::class);
    });
*/
/*
Route::prefix('api/v1')
    ->middleware('api')
    ->group(function () {
        Route::get('/ping', fn() => response()->json(['pong' => true]));

        Route::apiResource('workplaces', WorkplaceController::class);
        Route::apiResource('devices', DeviceController::class);
        Route::apiResource('tickets', TicketController::class);
    });
*/
