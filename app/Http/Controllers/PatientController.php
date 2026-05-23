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

    // ===== BỆNH NHÂN HUỶ LỊCH HẸN =====
    public function cancelBooking(Request $request, $id)
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            return back()->with('error', 'Bạn chưa có hồ sơ bệnh nhân!');
        }

        $request->validate([
            'cancel_reason' => 'required|string|max:500',
        ]);

        $booking = Booking::with(['timeSlot.doctorSchedule.doctor'])
            ->where('id', $id)
            ->where('patient_id', $patient->id)
            ->whereIn('status', [0, 1]) // chỉ huỷ lịch đang chờ hoặc đã xác nhận
            ->first();

        if (!$booking) {
            return back()->with('error', 'Không tìm thấy lịch hẹn hoặc lịch không thể huỷ!');
        }

        // Cập nhật trạng thái
        $booking->update([
            'status' => 3,
            'cancel_reason' => $request->cancel_reason,
            'patient_read' => 1,
            'admin_handled' => 0,
        ]);

        // Thông báo cho bác sĩ
        $doctorUser = $booking->timeSlot?->doctorSchedule?->doctor?->user;
        if ($doctorUser) {
            Notification::create([
                'user_id' => $doctorUser->id,
                'type' => 'booking_cancelled',
                'data' => [
                    'patient_name' => auth()->user()->name,
                    'cancel_reason' => $request->cancel_reason,
                    'work_date' => $booking->timeSlot?->doctorSchedule?->work_date,
                    'time_slot' => optional($booking->timeSlot)->start_time . ' - ' . optional($booking->timeSlot)->end_time,
                ],
                'booking_id' => $booking->id,
            ]);
        }

        // Thông báo cho admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'booking_cancelled',
                'data' => [
                    'patient_name' => auth()->user()->name,
                    'doctor_name' => $booking->timeSlot?->doctorSchedule?->doctor?->full_name ?? 'Bác sĩ',
                    'cancel_reason' => $request->cancel_reason,
                    'work_date' => $booking->timeSlot?->doctorSchedule?->work_date,
                    'time_slot' => optional($booking->timeSlot)->start_time . ' - ' . optional($booking->timeSlot)->end_time,
                ],
                'booking_id' => $booking->id,
            ]);
        }

        return back()->with('success', 'Đã huỷ lịch hẹn thành công!');
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

        // 2. Xây dựng lịch có thể đặt từ DoctorWeekSchedule (trong 14 ngày tới)
        $slotDefinitions = [
            'morning' => ['start' => '08:00', 'end' => '11:30'],
            'afternoon' => ['start' => '13:00', 'end' => '16:30'],
        ];

        $days = [];
        $startDate = \Carbon\Carbon::today();
        $endDate = $startDate->copy()->addDays(13); // 14 days window

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            // Lấy ngày đầu tuần (thứ 2) cho ngày hiện tại
            $weekStart = $date->copy()->startOfWeek(1); // 1 = Monday
            $dayOfWeek = $date->copy()->dayOfWeekIso; // 1..7 (Mon..Sun)

            $weeklyEntries = \App\Models\DoctorWeekSchedule::where('doctor_id', $doctor_id)
                ->where('week_start', $weekStart->toDateString())
                ->where('day_of_week', $dayOfWeek)
                ->get();

            if ($weeklyEntries->isEmpty()) {
                continue; // no slots that week for this day
            }

            $slotItems = [];
            foreach ($weeklyEntries as $entry) {
                $code = $entry->slot_code;
                if (!isset($slotDefinitions[$code])) continue;
                $start = $slotDefinitions[$code]['start'];
                $end = $slotDefinitions[$code]['end'];

                // Chia nhỏ thành các ca 30 phút
                $startTime = \Carbon\Carbon::createFromFormat('H:i', $start);
                $endTime = \Carbon\Carbon::createFromFormat('H:i', $end);
                while ($startTime->lt($endTime)) {
                    $slotStart = $startTime->format('H:i');
                    $slotEnd = $startTime->copy()->addMinutes(30);
                    if ($slotEnd->gt($endTime)) {
                        $slotEnd = $endTime->copy();
                    }

                    // Try to find existing DoctorSchedule + TimeSlot for this 30-min slot
                    $existingSchedule = DoctorSchedule::where('doctor_id', $doctor_id)
                        ->where('work_date', $date->toDateString())
                        ->where('start_time', $slotStart)
                        ->where('end_time', $slotEnd->format('H:i'))
                        ->first();

                    $available = 1; // default capacity if no timeslot exists
                    $current = 0;
                    $timeSlotId = null;

                    if ($existingSchedule) {
                        $ts = \App\Models\TimeSlot::where('schedule_id', $existingSchedule->id)
                            ->where('start_time', $slotStart)
                            ->where('end_time', $slotEnd->format('H:i'))
                            ->first();
                        if ($ts) {
                            $available = max(0, $ts->max_patient - $ts->current_patient);
                            $current = $ts->current_patient;
                            $timeSlotId = $ts->id;
                        }
                    }

                    $slotItems[] = (object)[
                        'code' => $code,
                        'start_time' => $slotStart,
                        'end_time' => $slotEnd->format('H:i'),
                        'available' => $available,
                        'current' => $current,
                        'timeslot_id' => $timeSlotId,
                    ];

                    $startTime->addMinutes(30);
                }
            }

            if (!empty($slotItems)) {
                $days[] = (object)[
                    'date' => $date->toDateString(),
                    'label' => $date->translatedFormat('l, d/m/Y'),
                    'slots' => $slotItems,
                ];
            }
        }

        return view('patient.booking', ['doctor' => $doctor, 'days' => $days]);
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'slot_code' => 'required|string',
        ]);

        $doctorId = $request->doctor_id;


        // slot_code format: code_start_end (e.g. morning_08:00_08:30)
        $parts = explode('_', $request->slot_code);
        if (count($parts) !== 3) {
            return back()->with('error', 'Ca không hợp lệ');
        }
        list($code, $start, $end) = $parts;
        $date = \Carbon\Carbon::parse($request->date)->toDateString();

        // Tự động tạo hồ sơ patient nếu user chưa có
        $patient = auth()->user()->patient
            ?? Patient::create(['user_id' => auth()->id()]);

        // Tìm hoặc tạo DoctorSchedule cho ngày này và khung giờ
        $schedule = DoctorSchedule::firstOrCreate([
            'doctor_id' => $doctorId,
            'work_date' => $date,
            'start_time' => $start,
            'end_time' => $end,
        ]);

        // Tìm hoặc tạo TimeSlot cho schedule
        $slot = TimeSlot::firstOrCreate([
            'schedule_id' => $schedule->id,
            'start_time' => $start,
            'end_time' => $end,
        ], [
            'max_patient' => 1,
            'current_patient' => 0,
            'status' => 1,
        ]);

        // Kiểm tra còn chỗ
        if ($slot->current_patient >= $slot->max_patient) {
            return back()->with('error', 'Ca này đã đầy. Vui lòng chọn ca khác.');
        }

        // Tạo bản ghi Booking
        $booking = Booking::create([
            'slot_id' => $slot->id,
            'patient_id' => $patient->id,
            'status' => 0,
            'created_by' => auth()->id(),
        ]);

        // Cập nhật số người đã đặt vào TimeSlot
        $slot->increment('current_patient');

        if ($slot->current_patient >= $slot->max_patient) {
            $slot->update(['status' => 0]);
        }

        // Tạo thông báo như cũ
        $doctor = $schedule->doctor ?? Doctor::find($doctorId);
        if ($doctor && $doctor->user_id) {
            Notification::create([
                'user_id' => $doctor->user_id,
                'type' => 'new_booking',
                'data' => [
                    'patient_name' => auth()->user()->name,
                    'patient_email' => auth()->user()->email,
                    'work_date' => $schedule->work_date ?? null,
                    'time_slot' => $start . ' - ' . $end,
                ],
                'booking_id' => $booking->id,
            ]);
        }

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'new_booking',
                'data' => [
                    'patient_name' => auth()->user()->name,
                    'patient_email' => auth()->user()->email,
                    'doctor_name' => $doctor?->full_name ?? 'N/A',
                    'work_date' => $schedule->work_date ?? null,
                    'time_slot' => $start . ' - ' . $end,
                ],
                'booking_id' => $booking->id,
            ]);
        }

        // Redirect to PayPal to complete deposit/payment before confirming the booking
        return redirect()->route('payment.paypal.create', $booking->id);
    }
}
