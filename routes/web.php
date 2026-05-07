<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminController;
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
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
    Route::get('/accounts', [AdminController::class, 'manageAccount'])->name('admin.accounts');
    Route::get('/doctors', [AdminController::class, 'manageDoctors'])->name('admin.doctors');
    Route::get('/patients', [AdminController::class, 'managePatients'])->name('admin.patients');
    Route::get('/cities', [AdminController::class, 'manageCities'])->name('admin.cities');
    Route::get('/contents', [AdminController::class, 'manageContents'])->name('admin.contents');

    //Route cho quan ly tai khoan admin
    Route::get('accounts/create',[AdminController::class,'createAccount'])->name('admin.accounts.create');
    Route::post('accounts/create',[AdminController::class,'storeAccount'])->name('admin.accounts.store');
    Route::get('accounts/{id}/edit',[AdminController::class,'editAccount'])->name('admin.accounts.edit');
    Route::post('accounts/{id}',[AdminController::class,'updateAccount'])->name('admin.accounts.update');
    Route::get('accounts/{id}/delete',[AdminController::class,'deleteAccount'])->name('admin.accounts.delete');

    //Route cho quan ly bac si admin
    Route::post('/doctors/store',[AdminController::class,'storeDoctor'])->name('admin.doctors.store');
    Route::get('/doctors/{id}/edit',[AdminController::class,'editDoctor'])->name('admin.doctos.edit');
    Route::put('/doctors/{id}',[AdminController::class,'updateDoctor'])->name('admin.doctos.update');
    Route::delete('/doctors/{id}',[AdminController::class,'deleteDoctor'])->name('admin.doctos.delete');
});
    //Test
    Route::get('/test',function(){
       return view('testview');
    });
    Route::post('/test1',function (){
        return view('viewforresult');
    })->name('viewforresult');

    Route::get('/user1',function(Request $request){
        $newName = $request->input('fullname');
        session(['name' => $newName]);
        return 'Ten hien tai la :' . session('name');
    });
    //Cap nhat lai ten nguoi dung
    Route::put('test',function(Request $request){
       $newName = $request->input('fullname');
       session(['name'=> $newName]);
       return 'Ten hien tai la :' . session('name');
    })->name('update-name');
