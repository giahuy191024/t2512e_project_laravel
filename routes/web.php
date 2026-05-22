<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\BookingRequestController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }

    // Featured = doctor có kinh nghiệm cao nhất
    $featuredDoctor = \App\Models\Doctor::with('user')
        ->where('status', 1)
        ->orderByDesc('experience_years')
        ->first();

    // Helper: query base (loại bỏ featured)
    $base = fn() => \App\Models\Doctor::with('user')
        ->where('status', 1)
        ->when($featuredDoctor, fn($q) => $q->where('id', '!=', $featuredDoctor->id))
        ->orderByDesc('experience_years');

    // Group theo city
    $doctorsHaNoi  = (clone $base())->where('city', 'Hà Nội')->get();
    $doctorsHCM    = (clone $base())->where('city', 'Hồ Chí Minh')->get();
    $doctorsDaNang = (clone $base())->where('city', 'Đà Nẵng')->get();

    return view('auth', compact('featuredDoctor', 'doctorsHaNoi', 'doctorsHCM', 'doctorsDaNang'));
});

Route::post('/auth', [AuthController::class, 'handleAuth']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/appointment',[AppointmentController::class,'create']

)->middleware('auth');

Route::post('/appointment', [AppointmentController::class, 'store'])->middleware('auth');
Route::get('/dashboard', [DashboardController::class,'index'])->middleware('auth')->name('dashboard');
//menu
Route::view('/about', 'about-page');
Route::view('/services', 'services-page');
Route::view('/news', 'news-page');
Route::view('/contact', 'contact-page');

//phan quyen cho patient
    Route::middleware(['auth','role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard_patient');

    // 2. Tài khoản & Hồ sơ cá nhân
    Route::get('/profile', [PatientController::class, 'profile'])->name('profile');
    Route::put('profile/update', [PatientController::class, 'updateProfile'])->name('profile.update');

    // 3. Tìm kiếm và xem bác sĩ
    Route::get('/doctors', [PatientController::class, 'doctors'])->name('doctors');
    Route::get('/doctors/{id}', [PatientController::class, 'doctorDetail'])->name('doctors.detail');

    // 4. Đặt lịch khám
    Route::get('/booking/{doctor_id?}', [PatientController::class, 'booking'])->name('booking');
    Route::post('/booking/store', [PatientController::class, 'storeBooking'])->name('booking.store');

    // 5. Quản lý lịch hẹn
    Route::get('/appointments', [PatientController::class, 'appointments'])->name('appointments');

    // 6. Thông báo huỷ lịch
    Route::post('/notifications/{id}/read', [PatientController::class, 'markNotificationRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [PatientController::class, 'markAllNotificationsRead'])->name('notifications.readAll');

    // 7. Nội dung y tế (Làm sau)
    Route::get('/notifications', [PatientController::class, 'notifications'])->name('notifications');
    Route::get('/medical-news', [PatientController::class, 'news'])->name('news');
});
//doctor
Route::middleware(['auth','role:doctor'])->name('doctor.')->group(function () {
    // 1. DASHBOARD
    Route::get('/doctordashboard', [DoctorController::class, 'dashboard'])->name('dashboard');

    // 2. QUẢN LÝ LỊCH KHÁM (Bệnh nhân đặt)
    Route::prefix('bookings')->prefix('doctor')->name('bookings.')->group(function () {
        Route::get('/', [DoctorController::class, 'indexBookings'])->name('index');
        Route::get('/{id}', [DoctorController::class, 'showBooking'])->name('show');
        // Route POST để bác sĩ xác nhận hoặc hủy lịch của bệnh nhân
        Route::post('/{id}/status', [DoctorController::class, 'updateBookingStatus'])->name('updateStatus');
    });

    // 3. ĐĂNG KÝ GIỜ LÀM (Lịch làm việc cá nhân)
    Route::prefix('schedules')->name('schedules.')->group(function () {
        Route::get('/', [DoctorController::class, 'indexSchedules'])->name('index');
        Route::get('/create', [DoctorController::class, 'createSchedule'])->name('create');

        // Route POST để lưu lịch làm việc mới vào database
        Route::post('/store', [DoctorController::class, 'storeSchedule'])->name('store');

        Route::get('/edit/{id}', [DoctorController::class, 'editSchedule'])->name('edit');

        // Route POST (hoặc PUT) để cập nhật lịch đã có
        Route::post('/update/{id}', [DoctorController::class, 'updateSchedule'])->name('update');

        // Route DELETE (hoặc GET tạm thời) để xóa lịch
        Route::delete('/delete/{id}', [DoctorController::class, 'destroySchedule'])->name('destroy');

        //Route get cho tung cai
        Route::post('slot/update',[DoctorController::class,'updateSlot'])->name('updateSlot');
        Route::delete('slot/delete/{id}',[DoctorController::class,'destroySlot'])->name('destroySlot');
        //Route xoa dot lich
        Route::delete('schedule/delete',[DoctorController::class,'destroyGroup'])->name('destroy-Schedule_Group');
    });

    // 4. THÔNG TIN CÁ NHÂN
    Route::get('/profiledoctor', [DoctorController::class, 'profile'])->name('profile');

    // Route POST để lưu thông tin profile sau khi sửa
    Route::post('/profiledoctor/update', [DoctorController::class, 'updateProfile'])->name('profile.update');
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
// === ĐẶT LỊCH NHANH CHO KHÁCH VÃNG LAI (không cần đăng nhập) ===
Route::controller(BookingRequestController::class)
    ->prefix('dat-lich-nhanh')
    ->name('booking-requests.')
    ->group(function () {
        Route::get('/',               'create')->name('create');
        Route::post('/',              'store')->name('store');
        Route::get('/thanks/{code}',  'thanks')->name('thanks');
    });
