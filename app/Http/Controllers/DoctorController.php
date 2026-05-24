<?php

namespace App\Http\Controllers;

use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\TimeSlot;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    // ==========================================
    // 1. DASHBOARD
    // ==========================================
    public function dashboard()
    {
        $doctorId = Auth::user()->doctor->id;
        $today    = Carbon::today();

        // Helper tránh lặp code
        $baseQuery = fn() => Booking::whereHas('slot.schedule', fn($q) => $q->where('doctor_id', $doctorId));

        $stats = [
            'total'     => $baseQuery()->count(),
            'pending'   => $baseQuery()->where('status', Booking::STATUS_PENDING)->count(),
            'completed' => $baseQuery()->where('status', Booking::STATUS_COMPLETED)->count(),
            'today'     => Booking::whereHas('slot.schedule', fn($q) =>
            $q->where('doctor_id', $doctorId)->whereDate('work_date', $today)
            )->count(),
        ];

        $todayBookings = Booking::with(['patient.user', 'slot.schedule'])
            ->whereHas('slot.schedule', fn($q) =>
            $q->where('doctor_id', $doctorId)->whereDate('work_date', $today)
            )
            ->get();

        return view('doctor.dashboard', compact('stats', 'todayBookings'));
    }
    // ==========================================
    // 2. QUẢN LÝ LỊCH KHÁM (Bệnh nhân đã đặt)
    // ==========================================
    public function indexBookings()
    {
        $doctorId = Auth::user()->doctor->id;

        // Đổi tên relationship cho khớp Model mới
        $bookings = Booking::with(['patient.user', 'slot.schedule'])
            ->whereHas('slot.schedule', function($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId);
            })
            ->orderByDesc('created_at')
            ->get();

        // Thống kê - dùng constants từ Booking model cho dễ đọc
        $stats = [
            'total'     => $bookings->count(),
            'pending'   => $bookings->where('status', Booking::STATUS_PENDING)->count(),
            'confirmed' => $bookings->where('status', Booking::STATUS_CONFIRMED)->count(),
            'done'      => $bookings->where('status', Booking::STATUS_COMPLETED)->count(),
            'cancelled' => $bookings->where('status', Booking::STATUS_CANCELLED)->count(),
        ];

        return view('doctor.bookings', compact('bookings', 'stats'));
    }

    public function showBooking($id)
    {
        $booking = Booking::with(['patient.user', 'slot.schedule.doctor.user'])
            ->findOrFail($id);
        return view('doctor.booking_detail', compact('booking'));
    }

    public function updateBookingStatus(Request $request, $id)
    {
        // Schema mới hỗ trợ status từ 1-5
        $request->validate(['status' => 'required|in:1,2,3,4,5']);
        $booking = Booking::findOrFail($id);

        $data = ['status' => $request->status];

        // Bỏ 'patient_read' (cột không tồn tại trong schema mới)
        if ($request->status == Booking::STATUS_CANCELLED) {
            $data['cancel_reason'] = $request->cancel_reason ?? 'Bác sĩ đã huỷ lịch hẹn.';
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

        $schedules = DoctorSchedule::with('timeSlots')
            ->where('doctor_id', $doctorId)
            ->orderBy('work_date', 'asc')
            ->get()
            ->groupBy(function($item) {
                // Gom các lịch tạo cùng phút + cùng khung giờ thành 1 "đợt đăng ký"
                return $item->created_at->format('Y-m-d H:i') . '-' . $item->start_time . '-' . $item->end_time;
            });

        return view('doctor.schedules', compact('schedules'));
    }

    public function createSchedule()
    {
        return view('doctor.schedulescreate');
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'week_days'     => 'required|array',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after:start_date',
            'start_time'    => 'required',
            'end_time'      => 'required|after:start_time',
            'slot_duration' => 'required|integer|min:5|max:120',
        ]);

        $doctorId = Auth::user()->doctor->id;
        $weekDays = $request->week_days;
        $period   = CarbonPeriod::create($request->start_date, $request->end_date);

        foreach ($period as $date) {
            if (in_array($date->dayOfWeek, $weekDays)) {
                $schedule = DoctorSchedule::create([
                    'doctor_id'  => $doctorId,
                    'work_date'  => $date->toDateString(),
                    'start_time' => $request->start_time,
                    'end_time'   => $request->end_time,
                ]);
                $this->generateTimeSlots($schedule, $request->slot_duration);
            }
        }

        return redirect()->route('doctor.schedules.index')
            ->with('success', 'Đã thiết lập lịch làm việc định kỳ thành công!');
    }

    private function generateTimeSlots($schedule, $duration)
    {
        $duration = (int)$duration;
        $start = Carbon::parse($schedule->start_time);
        $end   = Carbon::parse($schedule->end_time);

        while ($start->copy()->addMinutes($duration) <= $end) {
            $slotEnd = $start->copy()->addMinutes($duration);

            TimeSlot::create([
                'schedule_id'     => $schedule->id,
                'start_time'      => $start->format('H:i'),
                'end_time'        => $slotEnd->format('H:i'),
                'max_patient'     => 1,
                'current_patient' => 0,
                'status'          => TimeSlot::STATUS_AVAILABLE,
            ]);
            $start->addMinutes($duration);
        }
    }

    // ==========================================
    // 4. PROFILE
    // ==========================================
    public function profile()
    {
        $doctor = Doctor::with('user')
            ->where('user_id', Auth::id())
            ->firstOrFail();
        return view('doctor.profile', compact('doctor'));
    }

    public function updateProfile(Request $request)
    {
        $user   = Auth::user();
        $doctor = $user->doctor;

        $request->validate([
            'full_name'        => 'required|string|max:255',
            'specialty'        => 'nullable|string|max:100',
            'experience_years' => 'nullable|integer|min:0',
            'bio'              => 'nullable|string',
            'password'         => 'nullable|string|min:6|confirmed',
            'avatar'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',     // 2MB
            'certificate'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',   // 5MB
        ]);

        // 1. Cập nhật User (full_name + password + avatar)
        $user->full_name = $request->full_name;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar_url && \Storage::disk('public')->exists($user->avatar_url)) {
                \Storage::disk('public')->delete($user->avatar_url);
            }
            $user->avatar_url = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        // 2. Cập nhật Doctor (specialty + experience_years + bio + certificate)
        $doctor->specialty        = $request->specialty;
        $doctor->experience_years = $request->experience_years;
        $doctor->bio              = $request->bio;

        if ($request->hasFile('certificate')) {
            if ($doctor->certificate_url && \Storage::disk('public')->exists($doctor->certificate_url)) {
                \Storage::disk('public')->delete($doctor->certificate_url);
            }
            $doctor->certificate_url = $request->file('certificate')->store('certificates', 'public');
        }

        $doctor->save();

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
    // ==========================================
    // 5. SLOT - chỉnh sửa từng ca khám
    // ==========================================
    public function updateSlot(Request $request)
    {
        $slot = TimeSlot::findOrFail($request->slot_id);

        if ($slot->current_patient > 0) {
            return back()->with('error', 'Không thể sửa ca đã có người đặt!');
        }

        $slot->update([
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
        ]);

        return back()->with('success', 'Đã cập nhật giờ khám mới!');
    }

    public function destroySlot($id)
    {
        $slot = TimeSlot::findOrFail($id);

        if ($slot->current_patient > 0) {
            return response()->json(['message' => 'Không thể xóa ca đã có người đặt!'], 400);
        }

        $slot->delete();
        return response()->json(['success' => true]);
    }

    public function destroyGroup(Request $request)
    {
        $ids = $request->input('ids');

        if (empty($ids)) {
            return back()->with('error', 'Không tìm thấy dữ liệu để xóa.');
        }

        $hasBooking = TimeSlot::whereIn('schedule_id', $ids)
            ->where('current_patient', '>', 0)
            ->exists();

        if ($hasBooking) {
            return back()->with('error', 'Không thể xóa đợt này vì đã có bệnh nhân đặt lịch!');
        }

        TimeSlot::whereIn('schedule_id', $ids)->delete();
        DoctorSchedule::whereIn('id', $ids)->delete();

        return back()->with('success', 'Đã xóa toàn bộ đợt lịch làm việc!');
    }
}
