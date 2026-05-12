<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function showBookingForm(Request $request)
    {
        return view('appointment-book', [
            'doctorId' => $request->query('doctor_id'),
            'doctorName' => $request->query('doctor_name'),
            'doctorImage' => $request->query('doctor_image'),
            'clinicName' => $request->query('clinic_name', 'Nha Khoa Trẻ'),
            'doctorAddress' => $request->query('doctor_address'),
        ]);
    }

    public function storeBookingForm(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'nullable|integer|min:1',
            'doctor_name' => 'required|string|max:255',
            'patient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'birth_year' => 'required|integer|min:1900|max:' . date('Y'),
            'appointment_date' => 'required|date|after_or_equal:today',
            'reason' => 'nullable|string|max:1000',
            'source' => 'nullable|in:Google,Facebook,TikTok,Other',
        ]);

        $doctor = $validated['doctor_name'];
        $reason = $validated['reason'] ?? '';
        $source = $validated['source'] ?? 'Khác';

        $noteParts = [];
        if ($reason !== '') {
            $noteParts[] = 'Lý do: ' . $reason;
        }
        $noteParts[] = 'Năm sinh: ' . $validated['birth_year'];
        $noteParts[] = 'Nguồn biết đến: ' . $source;

        Appointment::create([
            'full_name' => $validated['patient_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'department' => 'nha_khoa',
            'service_type' => $validated['doctor_id'] ? 'specialist' : 'regular',
            'appointment_date' => $validated['appointment_date'],
            'time_slot' => '08:00',
            'doctor_name' => $doctor,
            'status' => 'confirmed',
            'note' => implode(' | ', $noteParts),
        ]);

        return back()->with('success', 'Đặt khám thành công. Chúng tôi sẽ liên hệ với bạn sớm nhất.');
    }

    public function index()
    {
        $appointments = Appointment::orderByDesc('created_at')->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create(){
        $user = Auth::user();
        return view('appointment',compact('user'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'service_type' => 'required|in:regular,specialist',
            'doctor_name' => 'nullable|string|max:255',
            'department' => 'required|string|max:100',
            'appointment_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string|max:20',
            'note' => 'nullable|string|max:1000',
        ]);

        if ($validated['service_type'] === 'specialist' && empty($validated['doctor_name'])) {
            return back()
                ->withErrors(['doctor_name' => 'Vui lòng chọn bác sĩ khi đăng ký khám chuyên gia.'])
                ->withInput();
        }

        // kiểm tra slot đã có người đặt chưa
        $exists = Appointment::where('appointment_date', $validated['appointment_date'])
            ->where('time_slot', $validated['time_slot'])
            ->where('department', $validated['department'])
            ->count();

        if ($exists >= 5) {
            return back()->with('error', 'Khung giờ này đã hết slot trống');
        }

        // phân bổ bác sĩ
        $doctor = null;

        if ($validated['service_type'] === 'regular') {
            // khám thường → tự phân bổ
            $doctor = 'BS Nguyễn Văn A';
        }

        if ($validated['service_type'] === 'specialist') {
            // khám chuyên gia → user tự chọn
            $doctor = $validated['doctor_name'];
        }

        Appointment::create([
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'department' => $validated['department'],
            'service_type' => $validated['service_type'],
            'appointment_date' => $validated['appointment_date'],
            'time_slot' => $validated['time_slot'],
            'doctor_name' => $doctor,
            'status' => 'confirmed',
            'note' => $validated['note'] ?? null,
        ]);

        return back()->with(
            'success',
            'Đăng ký lịch khám thành công. Bác sĩ phụ trách: ' . $doctor
        );
    }
}
