<?php

use App\Http\Controllers\DashboardController;
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

Route::get('/appointment',[AppointmentController::class,'create']

)->middleware('auth');

Route::post('/appointment', [AppointmentController::class, 'store'])
    ->middleware('auth');
Route::get('/dashboard', [DashboardController::class,'index'])->middleware('auth')->name('dashboard');
//phan quyen cho patient
Route::middleware(['auth','role:patient'])->group(function () {
    Route::get('appointment', [AppointmentController::class, 'create']);
    Route::post('appointment', [AppointmentController::class, 'store']);
});
//doctor
Route::middleware(['auth','role:doctor'])->group(function () {

});
//admin dashboard
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/accounts', [AdminController::class, 'manageAccounts'])->name('admin.accounts');
    Route::get('/doctors', [AdminController::class, 'manageDoctors'])->name('admin.doctors');
    Route::get('/patients', [AdminController::class, 'managePatients'])->name('admin.patients');
    Route::get('/cities', [AdminController::class, 'manageCities'])->name('admin.cities');
    Route::get('/contents', [AdminController::class, 'manageContents'])->name('admin.contents');
});
