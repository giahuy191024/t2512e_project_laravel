<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\City;
use App\Models\Booking;
use App\Models\Patient;
use App\Models\TimeSlot;
use App\Models\Notification;
use App\Models\User;

class PatientController extends Controller
{
    public function dashboard()
    {
        $patient = auth()->user()->patient;

        $upcomingCount  = 0;
        $pastCount      = 0;
        $cancelledUnread = collect();

        if ($patient) {
            $upcomingCount = Booking::where('patient_id', $patient->id)
                ->whereIn('status', [0, 1])
                ->whereHas('timeSlot.doctorSchedule', function ($q) {
                    $q->where('work_date', '>=', now()->toDateString());
                })->count();

            $pastCount = Booking::where('patient_id', $patient->id)
                ->whereHas('timeSlot.doctorSchedule', function ($q) {
                    $q->where('work_date', '<', now()->toDateString());
                })->count();

            // Lịch bị huỷ mà bệnh nhân chưa đọc
            $cancelledUnread = Booking::with(['timeSlot.doctorSchedule.doctor'])
                ->where('patient_id', $patient->id)
                ->where('status', 3)
                ->where('patient_read', 0)
                ->orderByDesc('updated_at')
                ->get();
        }

        return view('patient.dashboardpatient', compact('upcomingCount', 'pastCount', 'cancelledUnread'));
    }

    // Đánh dấu đã đọc 1 thông báo
    public function markNotificationRead($bookingId)
    {
        $patient = auth()->user()->patient;
        if ($patient) {
            Booking::where('id', $bookingId)
                ->where('patient_id', $patient->id)
                ->update(['patient_read' => 1]);
        }
        return back();
    }

    // Đánh dấu đã đọc tất cả
    public function markAllNotificationsRead()
    {
        $patient = auth()->user()->patient;
        if ($patient) {
            Booking::where('patient_id', $patient->id)
                ->where('status', 3)
                ->where('patient_read', 0)
                ->update(['patient_read' => 1]);
        }
        return back();
    }

    public function profile()
    {
        return view('');
    }

    public function doctors(Request $request)
    {
        // Lấy danh sách chuyên khoa & thành phố cho dropdown filter
        $specializations = Specialization::orderBy('name')->get();
        $cities          = City::orderBy('name')->get();

        // Build query với eager loading
        $query = Doctor::with('specialization', 'city', 'user');

        // Lọc theo chuyên khoa
        if ($request->filled('specialization_id')) {
            $query->where('specialization_id', $request->specialization_id);
        }

        // Lọc theo thành phố
        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        // Lọc theo tên (bonus tìm kiếm nhanh)
        if ($request->filled('keyword')) {
            $query->where('full_name', 'like', '%' . $request->keyword . '%');
        }

        $doctors = $query->get();

        return view('patient.doctors', compact('doctors', 'specializations', 'cities'));
    }

    public function appointments()
    {
        $patient = auth()->user()->patient;

        $bookings = collect();

        if ($patient) {
            $bookings = Booking::with([
                'timeSlot.doctorSchedule.doctor.specialization',
                'timeSlot.doctorSchedule.doctor.city',
            ])
            ->where('patient_id', $patient->id)
            ->orderByDesc('created_at')
            ->get();
        }

        return view('patient.appointments', compact('bookings'));
    }

    public function booking($doctor_id)
    {
        // 1. Lấy thông tin bác sĩ
        $doctor = Doctor::with(['user'])->findOrFail($doctor_id);

        // 2. Lấy lịch làm việc và các Slot còn trống (status = 1)
        // Chỉ lấy từ ngày hôm nay trở đi
        $schedules = DoctorSchedule::with(['timeSlots' => function ($query) {
            $query->where('status', 1) // Chỉ lấy slot đang mở
            ->whereColumn('current_patient', '<', 'max_patient'); // Chỉ lấy slot chưa đầy
        }])
            ->where('doctor_id', $doctor_id)
            ->where('work_date', '>=', now()->toDateString())
            ->orderBy('work_date', 'asc')
            ->get();

        return view('patient.booking', compact('doctor', 'schedules'));
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'slot_id' => 'required|exists:time_slots,id',
        ]);

        // Tự động tạo hồ sơ patient nếu user chưa có
        $patient = auth()->user()->patient
            ?? Patient::create(['user_id' => auth()->id()]);

        // Tạo bản ghi Booking
        $booking = Booking::create([
            'slot_id' => $request->slot_id,
            'patient_id' => $patient->id,
            'status' => 0, // 0 = Chờ xác nhận (pending)
            'created_by' => auth()->id()
        ]);

        // Cập nhật số người đã đặt vào TimeSlot
        $slot = TimeSlot::with('doctorSchedule.doctor.user')->find($request->slot_id);
        $slot->increment('current_patient');

        // Nếu ca đã đầy thì tự động khóa slot đó lại
        if ($slot->current_patient >= $slot->max_patient) {
            $slot->update(['status' => 0]);
        }

        // TẠO THÔNG BÁO CHO BÁC SĨ
        $doctor = $slot->doctorSchedule->doctor ?? null;
        if ($doctor && $doctor->user_id) {
            Notification::create([
                'user_id' => $doctor->user_id,
                'type' => 'new_booking',
                'data' => [
                    'patient_name' => auth()->user()->name,
                    'patient_email' => auth()->user()->email,
                    'work_date' => $slot->doctorSchedule->work_date ?? null,
                    'time_slot' => substr($slot->start_time, 0, 5) . ' - ' . substr($slot->end_time, 0, 5),
                ],
                'booking_id' => $booking->id,
            ]);
        }

        // TẠO THÔNG BÁO CHO ADMIN
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'new_booking',
                'data' => [
                    'patient_name' => auth()->user()->name,
                    'patient_email' => auth()->user()->email,
                    'doctor_name' => $doctor?->full_name ?? 'N/A',
                    'work_date' => $slot->doctorSchedule->work_date ?? null,
                    'time_slot' => substr($slot->start_time, 0, 5) . ' - ' . substr($slot->end_time, 0, 5),
                ],
                'booking_id' => $booking->id,
            ]);
        }

        return redirect()->route('patient.dashboard_patient')->with('success', 'Đặt lịch thành công! Vui lòng chờ bác sĩ xác nhận.');
    }
}
