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