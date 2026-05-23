<?php

namespace App\Http\Controllers;

use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\TimeSlot;
use App\Models\DoctorWeekSchedule;
use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DoctorController extends Controller
{
    // ==========================================
    // 1. DASHBOARD
    // ==========================================
    public function dashboard()
    {
        $doctorId = Auth::user()->doctor->id;

        // Thống kê nhanh
        $countBookings = Booking::whereHas('timeSlot.doctorSchedule', function($q) use ($doctorId) {
            $q->where('doctor_id', $doctorId);
        })->count();

        return view('layouts.doctordashboard', compact('countBookings'));
    }

    // ==========================================
    // 2. QUẢN LÝ LỊCH KHÁM (Bệnh nhân đã đặt)
    // ==========================================
    public function indexBookings()
    {
        $doctorId = Auth::user()->doctor->id;

        $bookings = Booking::with(['patient.user', 'timeSlot.doctorSchedule'])
            ->whereHas('timeSlot.doctorSchedule', function($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId);
            })
            ->orderByDesc('created_at')
            ->get();

        // Stats
        $stats = [
            'total'     => $bookings->count(),
            'pending'   => $bookings->where('status', 0)->count(),
            'confirmed' => $bookings->where('status', 1)->count(),
            'done'      => $bookings->where('status', 2)->count(),
            'cancelled' => $bookings->where('status', 3)->count(),
        ];

        return view('doctor.bookings', compact('bookings', 'stats'));
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:1,2,3']);
        $booking = Booking::with('timeSlot')->findOrFail($id);

        $data = ['status' => $request->status];

        // Nếu bác sĩ huỷ → giảm current_patient và đặt patient_read = 0
        if ($request->status == 3) {
            // Giảm số người đã đặt
            if ($booking->timeSlot) {
                $slot = $booking->timeSlot;
                $slot->decrement('current_patient');
                $slot->refresh();
                
                // Nếu slot vừa có chỗ trống, đổi status lại thành available
                if ($slot->current_patient < $slot->max_patient && $slot->status == 0) {
                    $slot->update(['status' => 1]);
                }
            }
            
            $data['patient_read'] = 0;
            $data['admin_handled'] = 0;
            $data['cancel_reason'] = $request->cancel_reason ?? 'Bác sĩ đã huỷ lịch hẹn.';

            $doctorName = Auth::user()->doctor->full_name ?? 'Bác sĩ';
            $workDate = $booking->timeSlot?->doctorSchedule?->work_date;
            $timeSlotStr = optional($booking->timeSlot)->start_time . ' - ' . optional($booking->timeSlot)->end_time;

            // Tạo thông báo cho bệnh nhân
            $patientUser = $booking->patient?->user;
            if ($patientUser) {
                Notification::create([
                    'user_id' => $patientUser->id,
                    'type' => 'booking_cancelled',
                    'data' => [
                        'doctor_name' => $doctorName,
                        'cancel_reason' => $data['cancel_reason'],
                        'work_date' => $workDate,
                        'time_slot' => $timeSlotStr,
                    ],
                    'booking_id' => $booking->id,
                ]);
            }

            // Tạo thông báo cho tất cả admin
            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'type' => 'booking_cancelled',
                    'data' => [
                        'doctor_name' => $doctorName,
                        'patient_name' => optional($booking->patient?->user)->name ?? 'Bệnh nhân',
                        'cancel_reason' => $data['cancel_reason'],
                        'work_date' => $workDate,
                        'time_slot' => $timeSlotStr,
                    ],
                    'booking_id' => $booking->id,
                ]);
            }
        }

        $booking->update($data);
        return back()->with('success', 'Cập nhật trạng thái lịch hẹn thành công!');
    }

    // ==========================================
    // 3. ĐĂNG KÝ GIỜ LÀM (Doctor Schedules)
    // ==========================================
    public function indexSchedules()
    {
        $doctorId = Auth::user()->doctor->id;
        // Tự động thêm tuần mới nếu chưa có
        $latestWeek = DoctorWeekSchedule::where('doctor_id', $doctorId)
            ->orderBy('week_start', 'desc')
            ->value('week_start');

        $nextMonday = \Carbon\Carbon::now()->startOfWeek(1)->addWeek();
        if ($latestWeek === null || $latestWeek < $nextMonday->toDateString()) {
            // Tạo tuần mới
            $weekdays = range(1, 6); // Thứ 2 đến Thứ 7
            $defaultSlots = \App\Models\DoctorWeekSchedule::defaultSlots();
            foreach ($weekdays as $dow) {
                foreach (array_keys($defaultSlots) as $slot) {
                    \App\Models\DoctorWeekSchedule::create([
                        'doctor_id' => $doctorId,
                        'week_start' => $nextMonday->toDateString(),
                        'day_of_week' => $dow,
                        'slot_code' => $slot,
                    ]);
                }
            }
            // Xóa tất cả các tuần cũ hơn tuần mới
            DoctorWeekSchedule::where('doctor_id', $doctorId)
                ->where('week_start', '<', $nextMonday->toDateString())
                ->delete();
        }

        // Sử dụng DoctorWeekSchedule: nhóm theo tuần (week_start = Monday of the week)
        $schedules = DoctorWeekSchedule::where('doctor_id', $doctorId)
            ->orderBy('week_start', 'desc')
            ->get()
            ->groupBy('week_start');

        return view('doctor.schedules', compact('schedules'));
    }

    public function createSchedule()
    {
        // Prepare default next Monday as week_start
        $nextMonday = \Carbon\Carbon::now()->startOfWeek()->addWeek();
        return view('doctor.schedulescreate', ['defaultWeekStart' => $nextMonday->toDateString()]);
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'week_start' => 'required|date',
            'week_days' => 'required|array',
            'slots' => 'required|array',
        ]);

        $doctorId = auth()->user()->doctor->id;

        $weekStartInput = \Carbon\Carbon::parse($request->week_start);
        // Normalize to Monday as week_start
        $weekStart = $weekStartInput->copy()->startOfWeek();

        // Delete existing entries for this doctor and week to force re-registration each week
        DoctorWeekSchedule::where('doctor_id', $doctorId)
            ->where('week_start', $weekStart->toDateString())
            ->delete();

        $weekDays = $request->week_days; // values 1..7 (1=Monday)
        $slots = $request->slots; // array of slot_codes

        $toInsert = [];
        foreach ($weekDays as $day) {
            foreach ($slots as $slot) {
                $toInsert[] = [
                    'doctor_id' => $doctorId,
                    'week_start' => $weekStart->toDateString(),
                    'day_of_week' => (int)$day,
                    'slot_code' => $slot,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Bulk insert (unique constraint prevents duplicates)
        if (!empty($toInsert)) {
            DoctorWeekSchedule::insert($toInsert);
        }

        return redirect()->route('doctor.schedules.index')->with('success', 'Đã đăng ký lịch tuần thành công!');
    }
    private function generateTimeSlots($schedule, $duration)
    {
        $duration = (int)$duration;
        $start = Carbon::parse($schedule->start_time);
        $end = Carbon::parse($schedule->end_time);

        while ($start->copy()->addMinutes($duration) <= $end) {
            $slotEnd = $start->copy()->addMinutes($duration);

            \App\Models\TimeSlot::create([
                'schedule_id' => $schedule->id,
                'start_time' => $start->format('H:i'),
                'end_time' => $slotEnd->format('H:i'),
                'max_patient' => 1,
                'current_patient' => 0,
                'status' => 1
            ]);

            $start->addMinutes($duration);
        }
    }

    //===========================================
    // 4. THÔNG TIN CÁ NHÂN (Profile)
    // ==========================================
    public function profile()
    {
        $doctor = Doctor::with('user')->where('user_id', Auth::id())->firstOrFail();
        return view('doctor.profile', compact('doctor'));
    }

    public function updateProfile(Request $request)
    {
        $doctor = Auth::user()->doctor;

        $request->validate([
            'full_name'      => 'required|string|max:255',
            'phone_number'   => 'required|string|max:20',
            'description'    => 'nullable|string',
            'qualifications' => 'nullable|string|max:255',
            'password'       => 'nullable|string|min:8|confirmed',
            'certificates.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'delete_cert'    => 'nullable|array',
        ]);

        $doctor->update($request->only(['full_name', 'phone_number', 'description', 'qualifications']));

        // Xử lý xoá chứng chỉ cũ
        $existing = $doctor->certificates ?? [];
        if ($request->has('delete_cert')) {
            foreach ($request->delete_cert as $path) {
                \Storage::disk('public')->delete($path);
                $existing = array_filter($existing, fn($p) => $p !== $path);
            }
        }

        // Upload chứng chỉ mới
        if ($request->hasFile('certificates')) {
            foreach ($request->file('certificates') as $file) {
                $path = $file->store('certificates', 'public');
                $existing[] = $path;
            }
        }

        $doctor->certificates = array_values($existing);
        $doctor->save();

        // Đổi mật khẩu nếu người dùng nhập
        if ($request->filled('password')) {
            Auth::user()->update([
                'password' => bcrypt($request->password),
            ]);
        }

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
    //tung slot chinh sua thong tin
    // Cập nhật trạng thái (Khóa/Mở)
    // Cập nhật giờ của ca khám
    public function updateSlot(Request $request)
    {
        $slot = \App\Models\TimeSlot::findOrFail($request->slot_id);

        if ($slot->current_patient > 0) {
            return redirect()->back()->with('error', 'Không thể sửa ca đã có người đặt!');
        }

        $slot->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->back()->with('success', 'Đã cập nhật giờ khám mới!');
    }

// Xóa ca khám
    public function destroySlot($id)
    {
        $slot = \App\Models\TimeSlot::findOrFail($id);

        if ($slot->current_patient > 0) {
            return response()->json(['message' => 'Không thể xóa ca đã có người đặt!'], 400);
        }

        $slot->delete();

        // Trả về thành công mà không cần load lại trang
        return response()->json(['success' => true]);
    }
    //xoa dot lich
    public function destroyGroup(Request $request)
    {
        $ids = $request->input('ids'); // Nhận mảng ID từ form

        if (!empty($ids)) {
            // Kiểm tra xem có ca nào trong đợt này đã có khách đặt chưa
            $hasBooking = \App\Models\TimeSlot::whereIn('schedule_id', $ids)
                ->where('current_patient', '>', 0)
                ->exists();

            if ($hasBooking) {
                return redirect()->back()->with('error', 'Không thể xóa đợt này vì đã có ca khám có bệnh nhân đặt lịch!');
            }

            // Xóa các TimeSlots trước (nếu ông không dùng cascade delete trong DB)
            \App\Models\TimeSlot::whereIn('schedule_id', $ids)->delete();

            // Xóa các DoctorSchedules
            \App\Models\DoctorSchedule::whereIn('id', $ids)->delete();

            return redirect()->back()->with('success', 'Đã xóa toàn bộ đợt lịch làm việc!');
        }

        return redirect()->back()->with('error', 'Không tìm thấy dữ liệu để xóa.');
    }

    // Xóa cả tuần (week_start)
    public function destroyWeek(Request $request)
    {
        $doctorId = Auth::user()->doctor->id;
        $weekStart = $request->input('week_start');

        if (!$weekStart) {
            return redirect()->back()->with('error', 'Thiếu thông tin tuần cần xóa');
        }

        DoctorWeekSchedule::where('doctor_id', $doctorId)
            ->where('week_start', $weekStart)
            ->delete();

        return redirect()->back()->with('success', 'Đã xóa lịch tuần thành công');
    }

    // Toggle a week slot on/off for the doctor (AJAX)
    public function toggleWeekSlot(Request $request)
    {
        $request->validate([
            'week_start' => 'required|date',
            'day_of_week' => 'required|integer|min:1|max:7',
            'slot_code' => 'required|string',
            'enabled' => 'required|boolean',
        ]);

        $doctorId = Auth::user()->doctor->id;
        $weekStart = \Carbon\Carbon::parse($request->week_start)->startOfWeek()->toDateString();

        if ($request->enabled) {
            // insert if not exists
            DoctorWeekSchedule::firstOrCreate([
                'doctor_id' => $doctorId,
                'week_start' => $weekStart,
                'day_of_week' => (int)$request->day_of_week,
                'slot_code' => $request->slot_code,
            ]);
            return response()->json(['success' => true, 'message' => 'Enabled']);
        } else {
            // delete if exists
            DoctorWeekSchedule::where('doctor_id', $doctorId)
                ->where('week_start', $weekStart)
                ->where('day_of_week', (int)$request->day_of_week)
                ->where('slot_code', $request->slot_code)
                ->delete();
            return response()->json(['success' => true, 'message' => 'Disabled']);
        }
    }
}
