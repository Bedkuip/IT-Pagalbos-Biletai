<?php

use Illuminate\Support\Facades\Route;

// Root URL → show login form
Route::get('/', function () {
    return view('auth.login'); // Blade login form
});

// Dashboard page (frontend view)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('jwt');

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
