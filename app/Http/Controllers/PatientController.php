<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Booking;
use App\Models\Patient;
use App\Models\TimeSlot;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Specialty;
use App\Models\City;

class PatientController extends Controller
{
    // ===== DASHBOARD =====
    public function dashboard()
    {
        $patient = auth()->user()->patient;

        $upcomingCount  = 0;
        $pastCount      = 0;
        $cancelledUnread = collect();

        if ($patient) {
            $upcomingCount = Booking::where('patient_id', $patient->id)
                ->whereIn('status', [Booking::STATUS_PENDING, Booking::STATUS_CONFIRMED])
                ->whereHas('slot.schedule', function ($q) {
                    $q->where('work_date', '>=', now()->toDateString());
                })->count();

            $pastCount = Booking::where('patient_id', $patient->id)
                ->whereHas('slot.schedule', function ($q) {
                    $q->where('work_date', '<', now()->toDateString());
                })->count();

            // Lịch bị huỷ trong 7 ngày gần đây (vì schema mới bỏ patient_read,
            // ta lọc theo thời gian thay vì cờ đã đọc)
            $cancelledUnread = Booking::with(['slot.schedule.doctor.user'])
                ->where('patient_id', $patient->id)
                ->where('status', Booking::STATUS_CANCELLED)
                ->where('updated_at', '>=', now()->subDays(7))
                ->orderByDesc('updated_at')
                ->take(10)
                ->get();
        }

        return view('patient.dashboardpatient', compact('upcomingCount', 'pastCount', 'cancelledUnread'));
    }

    // ===== NOTIFICATIONS =====
    public function markNotificationRead($id)
    {
        Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();
        return back();
    }

    public function markAllNotificationsRead()
    {
        Notification::where('user_id', auth()->id())->delete();
        return back();
    }

    public function notifications()
    {
        $patient = auth()->user()->patient;
        $notifications = collect();

        if ($patient) {
            // Lấy bookings đã huỷ làm notifications (giống dashboard)
            $notifications = Booking::with(['slot.schedule.doctor.user'])
                ->where('patient_id', $patient->id)
                ->where('status', Booking::STATUS_CANCELLED)
                ->orderByDesc('updated_at')
                ->get();
        }

        return view('patient.notifications', compact('notifications'));
    }

    // ===== PROFILE =====
    public function profile()
    {
        $user = auth()->user();
        $patient = $user->patient;
        return view('patient.profile', compact('user', 'patient'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'full_name'    => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address_line' => 'nullable|string',
            'city'         => 'nullable|string|max:100',
            'district'     => 'nullable|string|max:100',
            'ward'         => 'nullable|string|max:100',
            'avatar'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB
        ]);

        $user = auth()->user();
        $user->full_name = $request->full_name;

        // Xử lý upload avatar
        if ($request->hasFile('avatar')) {
            // Xóa avatar cũ nếu có
            if ($user->avatar_url && \Storage::disk('public')->exists($user->avatar_url)) {
                \Storage::disk('public')->delete($user->avatar_url);
            }
            // Lưu file mới vào storage/app/public/avatars
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_url = $path;
        }

        $user->save();

        $patient = $user->patient ?? Patient::create(['user_id' => $user->id]);
        $patient->update([
            'phone_number' => $request->phone_number,
            'address_line' => $request->address_line,
            'city'         => $request->city,
            'district'     => $request->district,
            'ward'         => $request->ward,
        ]);

        return back()->with('success', 'Cập nhật hồ sơ thành công!');
    }

    // ===== TÌM BÁC SĨ =====
    public function doctors(Request $request)
    {
        $query = Doctor::with(['user', 'specialty', 'city'])->where('status', 1);

        // Lọc theo chuyên khoa (FK với fallback text legacy)
        if ($request->filled('specialty_id')) {
            $specialty = Specialty::find($request->specialty_id);
            $query->where(function($q) use ($request, $specialty) {
                $q->where('specialty_id', $request->specialty_id);
                if ($specialty) {
                    $q->orWhere(function($qq) use ($specialty) {
                        $qq->whereNull('specialty_id')->where('specialty', $specialty->name);
                    });
                }
            });
        }

        // Lọc theo thành phố
        if ($request->filled('city_id')) {
            $city = City::find($request->city_id);
            $query->where(function($q) use ($request, $city) {
                $q->where('city_id', $request->city_id);
                if ($city) {
                    $q->orWhere(function($qq) use ($city) {
                        $qq->whereNull('city_id')->where('city', $city->name);
                    });
                }
            });
        }

        // Lọc theo tên
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->whereHas('user', function ($q) use ($keyword) {
                $q->where('full_name', 'like', "%{$keyword}%");
            });
        }

        $doctors     = $query->get();
        $specialties = Specialty::active()->orderBy('sort_order')->get();
        $cities      = City::active()->orderBy('sort_order')->get();

        return view('patient.doctors', compact('doctors', 'specialties', 'cities'));
    }

    public function doctorDetail($id)
    {
        $doctor = Doctor::with('user')->findOrFail($id);
        return view('patient.doctor_detail', compact('doctor'));
    }

    // ===== ĐẶT LỊCH =====
    public function booking($doctor_id = null)
    {
        if (!$doctor_id) {
            return redirect()->route('patient.doctors');
        }

        $doctor = Doctor::with(['user', 'specialty', 'city'])->findOrFail($doctor_id);

        $schedules = DoctorSchedule::with(['timeSlots' => function ($query) {
            $query->where('status', TimeSlot::STATUS_AVAILABLE)
                ->whereColumn('current_patient', '<', 'max_patient');
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

        $patient = auth()->user()->patient
            ?? Patient::create(['user_id' => auth()->id()]);

        Booking::create([
            'slot_id'    => $request->slot_id,
            'patient_id' => $patient->id,
            'status'     => Booking::STATUS_PENDING,
            'created_by' => auth()->id(),
        ]);

        // Tăng số người đặt slot, full thì khoá
        $slot = TimeSlot::find($request->slot_id);
        $slot->increment('current_patient');

        if ($slot->current_patient >= $slot->max_patient) {
            $slot->update(['status' => TimeSlot::STATUS_FULL]);
        }

        return redirect()->route('patient.dashboard_patient')
            ->with('success', 'Đặt lịch thành công! Vui lòng chờ bác sĩ xác nhận.');
    }

    // ===== APPOINTMENTS =====
    public function appointments()
    {
        $patient = auth()->user()->patient;
        $bookings = collect();

        if ($patient) {
            $bookings = Booking::with(['slot.schedule.doctor.user'])
                ->where('patient_id', $patient->id)
                ->orderByDesc('created_at')
                ->get();
        }

        return view('patient.appointments', compact('bookings'));
    }

    // ===== NEWS (placeholder) =====
    public function news()
    {
        return view('patient.medical-news');
    }
    // ===== HỦY LỊCH HẸN =====
    public function cancelBooking($id)
    {
        $booking = Booking::findOrFail($id);

        // Check ownership
        $patient = auth()->user()->patient;
        if (!$patient || $booking->patient_id !== $patient->id) {
            return back()->with('error', '❌ Bạn không có quyền hủy lịch này');
        }

        // Không cho hủy nếu đã hủy rồi
        if ($booking->status === Booking::STATUS_CANCELLED) {
            return back()->with('error', '⚠️ Lịch này đã được hủy trước đó');
        }

        // Cập nhật status
        $booking->status = Booking::STATUS_CANCELLED;
        $booking->save();

        // Giảm current_patient của slot và mở lại nếu slot đang FULL
        if ($booking->slot) {
            $booking->slot->decrement('current_patient');
            if ($booking->slot->status === TimeSlot::STATUS_FULL) {
                $booking->slot->update(['status' => TimeSlot::STATUS_AVAILABLE]);
            }
        }

        return back()->with('success', '✅ Đã hủy lịch hẹn thành công');
    }
}
