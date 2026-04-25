<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        // kiểm tra slot đã có người đặt chưa
        $exists = Appointment::where('appointment_date', $request->appointment_date)
            ->where('time_slot', $request->time_slot)
            ->where('department', $request->department)
            ->count();

        if ($exists >= 5) {
            return back()->with('error', 'Khung giờ này đã hết slot trống');
        }

        // phân bổ bác sĩ
        $doctor = null;

        if ($request->service_type === 'regular') {
            // khám thường → tự phân bổ
            $doctor = 'BS Nguyễn Văn A';
        }

        if ($request->service_type === 'specialist') {
            // khám chuyên gia → user tự chọn
            $doctor = $request->doctor_name;
        }

        Appointment::create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'department' => $request->department,
            'service_type' => $request->service_type,
            'appointment_date' => $request->appointment_date,
            'time_slot' => $request->time_slot,
            'doctor_name' => $doctor,
            'status' => 'confirmed',
            'note' => $request->note,
        ]);

        return back()->with(
            'success',
            'Đăng ký lịch khám thành công. Bác sĩ phụ trách: ' . $doctor
        );
    }
}
