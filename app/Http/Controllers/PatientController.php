<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use App\Models\Doctor;
// use App\Models\Appointment;

class PatientController extends Controller
{
    public function dashboard()
    {
        return view('patient.dashboardpatient');
    }

    public function profile()
    {
        return view('');
    }

    public function doctors(Request $request)
    {
        // Sau này sẽ code logic tìm kiếm theo tên, chuyên khoa ở đây
        $doctors = Doctor::with('specialization', 'city')->get();
        return view('patient.doctors', compact('doctors'));
    }

    public function appointments()
    {
        return view('patient.booking');
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

        // Lấy ID của Bệnh nhân từ User đang đăng nhập (Lưu ý: patient_id trong bảng bookings)
        $patient = auth()->user()->patient;

        if (!$patient) {
            return back()->with('error', 'Ông chưa có hồ sơ bệnh nhân. Vui lòng cập nhật hồ sơ trước!');
        }

        // Tạo bản ghi Booking
        $booking = Booking::create([
            'slot_id' => $request->slot_id,
            'patient_id' => $patient->id,
            'status' => 0, // 0 = Chờ xác nhận (pending)
            'created_by' => auth()->id()
        ]);

        // Cập nhật số người đã đặt vào TimeSlot
        $slot = TimeSlot::find($request->slot_id);
        $slot->increment('current_patient');

        // Nếu ca đã đầy thì tự động khóa slot đó lại
        if ($slot->current_patient >= $slot->max_patient) {
            $slot->update(['status' => 0]);
        }

        return redirect()->route('patient.dashboard')->with('success', 'Đặt lịch thành công! Vui lòng chờ bác sĩ xác nhận.');
        // ... các hàm khác tương tự
    }
}
