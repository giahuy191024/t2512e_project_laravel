<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ADMIN → hiển thị dashboard tổng quan (view của bạn)
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        // DOCTOR → redirect sang trang doctor
        if ($user->isDoctor()) {
            return redirect()->route('doctor.dashboard');
        }

        // PATIENT → redirect sang trang patient
        if ($user->isPatient()) {
            return redirect()->route('patient.dashboard_patient');
        }

        abort(403, 'Role không hợp lệ');
    }

    /**
     * Trang dashboard cho admin: tính các thống kê + lịch đặt gần đây
     */
    private function adminDashboard()
    {
        // Tổng số
        $totalUsers    = User::count();
        $totalDoctors  = Doctor::count();
        $totalPatients = Patient::count();
        $totalBookings = Booking::count();

        // Số booking theo trạng thái (dùng constants từ Booking model cho dễ đọc)
        $pendingBookings   = Booking::where('status', Booking::STATUS_PENDING)->count();
        $confirmedBookings = Booking::where('status', Booking::STATUS_CONFIRMED)->count();
        $doneBookings      = Booking::where('status', Booking::STATUS_COMPLETED)->count();
        $cancelledBookings = Booking::where('status', Booking::STATUS_CANCELLED)->count();

        // 10 booking gần đây nhất, eager load để giảm số query
        $recentBookings = Booking::with(['slot.schedule.doctor.user', 'patient.user'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'totalUsers', 'totalDoctors', 'totalPatients', 'totalBookings',
            'pendingBookings', 'confirmedBookings', 'doneBookings', 'cancelledBookings',
            'recentBookings'
        ));
    }
}
