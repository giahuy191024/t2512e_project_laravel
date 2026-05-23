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
use App\Http\Controllers\NotificationController;
//Route::get('/', function () {
//    return view('home');
//});
Route::get('/', [HomeController::class, 'index']);

Route::get('/login', function () {
    return view('auth');
})->name('login');
//Route::get('/login', function () {
//    return view('auth');
//})->name('login');

Route::post('/auth', [AuthController::class, 'handleAuth']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/appointment',[AppointmentController::class,'create']

)->middleware('auth');

Route::post('/appointment', [AppointmentController::class, 'store'])->middleware('auth');
Route::get('/dashboard', [DashboardController::class,'index'])->middleware('auth')->name('dashboard');
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

// PayPal IPN/Notify endpoint
Route::post('payment/paypal/notify', [\App\Http\Controllers\PaymentController::class, 'handlePaypalNotify'])->name('payment.paypal.notify');
// PayPal payment routes
Route::middleware(['auth', 'role:patient'])->group(function() {
    Route::get('payment/paypal/{booking}/create', [\App\Http\Controllers\PaymentController::class, 'createPaypalPayment'])->name('payment.paypal.create');
    Route::get('payment/paypal/{booking}/return', [\App\Http\Controllers\PaymentController::class, 'handlePaypalReturn'])->name('payment.paypal.return');
    Route::get('payment/paypal/{booking}/cancel', [\App\Http\Controllers\PaymentController::class, 'handlePaypalCancel'])->name('payment.paypal.cancel');
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

    // Delete entire week schedule (by week_start)
    Route::delete('/week/delete', [DoctorController::class, 'destroyWeek'])->name('destroyWeek');

    // Toggle a slot in a week (on/off) via AJAX
    Route::post('/week/toggle', [DoctorController::class, 'toggleWeekSlot'])->name('toggleWeekSlot');

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

// Notifications routes (dùng chung cho admin và doctor)
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.markRead');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unreadCount');
});
