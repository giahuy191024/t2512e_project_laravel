<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientController;
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
Route::middleware(['auth','role:patient'])->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');

    // 2. Tài khoản & Hồ sơ cá nhân
    Route::get('/profile', [PatientController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [PatientController::class, 'updateProfile'])->name('profile.update');

    // 3. Tìm kiếm và xem bác sĩ
    Route::get('/doctors', [PatientController::class, 'doctors'])->name('doctors');
    Route::get('/doctors/{id}', [PatientController::class, 'doctorDetail'])->name('doctors.detail');

    // 4. Đặt lịch khám
    Route::get('/booking/{doctor_id?}', [PatientController::class, 'booking'])->name('booking');
    Route::post('/booking/store', [PatientController::class, 'storeBooking'])->name('booking.store');

    // 5. Quản lý lịch hẹn
    Route::get('/appointments', [PatientController::class, 'appointments'])->name('appointments');

    // 6. Thông báo & Nội dung y tế (Làm sau)
    Route::get('/notifications', [PatientController::class, 'notifications'])->name('notifications');
    Route::get('/medical-news', [PatientController::class, 'news'])->name('news');
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
    Route::delete('accounts/{id}/delete',[AdminController::class,'deleteAccount'])->name('admin.accounts.delete');

    //Route cho quan ly bac si admin
    Route::post('/doctors/store',[AdminController::class,'storeDoctor'])->name('admin.doctors.store');
    Route::get('/doctors/{id}/edit',[AdminController::class,'editDoctor'])->name('admin.doctors.edit');
    Route::put('/doctors/{id}',[AdminController::class,'updateDoctor'])->name('admin.doctors.update');
    Route::delete('/doctors/{id}',[AdminController::class,'deleteDoctor'])->name('admin.doctors.destroy');
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
    Route::controller(HomeController::class)->group(function () {
        Route::get('/trangchu','index');
        Route::get('/trangchu1','index2');
        Route::get('/trangchu2','index3');
    });
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/trangchu3', function () {
           return 'hello man';
        });
    });
