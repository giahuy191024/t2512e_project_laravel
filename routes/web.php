<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    return view('home');
});

Route::get('/auth', function () {
    if (auth()->check()) {
        return redirect('/appointment');
    }

    return view('auth');
})->name('auth');

Route::get('/login', function () {
    if (auth()->check()) {
        return redirect('/appointment');
    }

    return view('auth');
})->name('login');

Route::get('/register', function () {
    if (auth()->check()) {
        return redirect('/appointment');
    }

    return view('auth');
})->name('register');

Route::post('/auth', [AuthController::class, 'handleAuth']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/appointment/book', [AppointmentController::class, 'showBookingForm'])
    ->name('appointment.book.form');

Route::post('/appointment/book', [AppointmentController::class, 'storeBookingForm'])
    ->name('appointment.book.store');

Route::get('/appointment',[AppointmentController::class,'create']

)->middleware('auth');

Route::get('/appointments', [AppointmentController::class, 'index'])
    ->middleware('auth');

Route::post('/appointment', [AppointmentController::class, 'store'])
    ->middleware('auth');

// Terms and Conditions Page
Route::get('/terms', function () {
    return view('terms');
});

// Contact Page
Route::get('/contact', function () {
    return view('contact');
});

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'message' => 'required|string|max:2000',
    ]);

    return back()
        ->with('success', 'Gửi thành công')
        ->withInput();
});

Route::get('/about', function () {
    return view('about');
});
