<?php

namespace App\Http\Controllers;

use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\TimeSlot;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
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

        // Lấy danh sách đặt lịch của bệnh nhân liên quan đến bác sĩ này
        $bookings = Booking::with(['patient.user', 'timeSlot.doctorSchedule'])
            ->whereHas('timeSlot.doctorSchedule', function($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('doctor.bookings', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]); // 1: Duyệt, 2: Hủy...

        return back()->with('success', 'Cập nhật trạng thái lịch hẹn thành công!');
    }

    // ==========================================
    // 3. ĐĂNG KÝ GIỜ LÀM (Doctor Schedules)
    // ==========================================
    public function indexSchedules()
    {
        $doctorId = Auth::user()->doctor->id;

        // Gom nhóm theo giờ bắt đầu, giờ kết thúc và ngày tạo (created_at)
        // để xác định các ngày thuộc cùng một đợt đăng ký.
        $schedules = DoctorSchedule::with('timeSlots')
            ->where('doctor_id', $doctorId)
            ->select('*')
            ->orderBy('work_date', 'asc')
            ->get()
            ->groupBy(function($item) {
                // Gom nhóm những bản ghi được tạo cùng lúc (cùng phút) và cùng khung giờ
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
            'week_days' => 'required|array',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $doctorId = auth()->user()->doctor->id;
        $weekDays = $request->week_days; // Mảng chứa [1, 3, 5] chẳng hạn

        // Tạo một chu kỳ ngày từ Start đến End
        $period = CarbonPeriod::create($request->start_date, $request->end_date);

        foreach ($period as $date) {
            // Kiểm tra xem thứ của ngày hiện tại có nằm trong mảng bác sĩ chọn không
            // Carbon: 0 (Chủ nhật) -> 6 (Thứ 7)
            if (in_array($date->dayOfWeek, $weekDays)) {

                // 1. Lưu vào bảng doctor_schedules
                $schedule = DoctorSchedule::create([
                    'doctor_id' => $doctorId,
                    'work_date' => $date->toDateString(),
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                ]);

                // 2. Chia ca khám (TimeSlots) - Gọi hàm phụ để code gọn hơn
                $this->generateTimeSlots($schedule, $request->slot_duration);
            }
        }

        return redirect()->route('doctor.schedules.index')->with('success', 'Đã thiết lập lịch làm việc định kỳ thành công!');
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
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required',
            'description' => 'nullable',
        ]);

        $doctor->update($request->only(['full_name', 'phone_number', 'description', 'qualifications']));

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
}
