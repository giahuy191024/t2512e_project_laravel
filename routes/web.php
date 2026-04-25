<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/appointment');
    }

    return view('auth');
});

Route::post('/auth', [AuthController::class, 'handleAuth']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/appointment', function () {
    return view('appointment');
})->middleware('auth');

Route::post('/appointment', [AppointmentController::class, 'store'])
    ->middleware('auth');
