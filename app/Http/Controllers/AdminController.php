<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\City;
use App\Models\Specialization;
use App\Models\User;
use App\Models\Booking;
use App\Models\Patient;
use App\Models\Notification;
use App\Models\TimeSlot;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller{
    public function adminDashboard(){
        $totalUsers    = User::count();
        $totalDoctors  = Doctor::count();
        $totalPatients = User::where('role','patient')->count();
        $totalBookings = Booking::count();
        $pendingBookings   = Booking::where('status', 0)->count();
        $confirmedBookings = Booking::where('status', 1)->count();
        $doneBookings      = Booking::where('status', 2)->count();
        $cancelledBookings = Booking::where('status', 3)->count();

        $recentBookings = Booking::with(['patient.user','timeSlot.doctorSchedule.doctor'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalUsers','totalDoctors','totalPatients','totalBookings',
            'pendingBookings','confirmedBookings','doneBookings','cancelledBookings',
            'recentBookings'
        ));
    }
    public function manageAccount(Request $request){
        // Calculate stats first (before filtering)
        $stats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'doctor' => User::where('role', 'doctor')->count(),
            'patient' => User::where('role', 'patient')->count(),
        ];

        // Build filtered query
        $query = User::query();

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by search (name or email)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        return view('admin.accounts', compact('users', 'stats'));
    }
    public function manageDoctors(Request $request){
        // Get all specializations and cities for dropdowns
        $specializations = Specialization::all();
        $cities = City::all();

        // Calculate stats (total before filtering)
        $stats = [
            'total' => Doctor::count(),
        ];

        // Build filtered query
        $query = Doctor::with(['user', 'specialization', 'city']);

        // Filter by specialization
        if ($request->filled('specialization_id')) {
            $query->where('specialization_id', $request->specialization_id);
        }

        // Filter by city
        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        // Filter by search (name, email, or phone)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('full_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('phone_number', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function($subQ) use ($searchTerm) {
                      $subQ->where('email', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        $doctors = $query->get();

        return view('admin.doctors', compact('doctors', 'specializations', 'cities', 'stats'));
    }
    public function managePatients(Request $request){
        // Build filtered query
        $query = User::where('role','patient')
            ->with(['patient.bookings.timeSlot.doctorSchedule.doctor']);

        // Filter by search (name or email)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        $patients = $query->orderByDesc('created_at')->get();
        $totalBookings = Booking::count();

        return view('admin.patients', compact('patients', 'totalBookings'));
    }
    public function manageCities(){
        return view('admin.cities');
    }
    public function manageContents(){
        return view('admin.contents');
    }
    //Crud
    public function createAccount(){
        return view('admin.accounts_create');
    }
    public function storeAccount(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,doctor,patient',
        ]);
        User::create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => Hash::make($request->password),
           'role' => $request->role,
        ]);
        return redirect()->route('admin.accounts')->with('success', 'Account Created Successfully');
    }
    public function editAccount($id){
        $userEdit = User::findOrFail($id);
        return view('admin.accounts_edit', compact('userEdit'));
    }
    public function updateAccount(Request $request, $id) {
        $userEdit = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userEdit->id,
            'role' => 'required|in:admin,doctor,patient'
        ]);

        $userEdit->name = $request->name;
        $userEdit->email = $request->email;
        $userEdit->role = $request->role;

        // Chỉ cập nhật mật khẩu nếu người dùng nhập mật khẩu mới
        if ($request->filled('password')) {
            $userEdit->password = Hash::make($request->password);
        }
        $userEdit->save();

        return redirect()->route('admin.accounts')->with('success', 'Updated successfully!');
    }

    // --- XÓA TÀI KHOẢN ---
    public function deleteAccount($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'Deleted successfully!');
    }

    //---Quan ly bac si---
    public function storeDoctor(Request $request){
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'full_name' => 'required|string|max:255',
            'specialization_id' => 'required|exists:specializations,id',
            'city_id' => 'required|exists:cities,id',
        ]);

        DB::beginTransaction();
        try {
            // Lưu vào bảng users trước
            $user = User::create([
                'name' => $request->full_name,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'role' => 'doctor',
            ]);

            // Lấy ID user vừa tạo lưu tiếp vào bảng doctors
            Doctor::create([
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'specialization_id' => $request->specialization_id,
                'city_id' => $request->city_id,
                'qualifications' => $request->qualifications,
                'phone_number' => $request->phone_number,
                'description' => $request->description,
            ]);

            DB::commit();
            return redirect()->route('admin.doctors')->with('success', 'Added Doctor successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()])->withInput();
        }
    }
    public function editDoctor($id)
    {
        $doctorEdit = Doctor::with('user')->findOrFail($id);
        $specializations = Specialization::all();
        $cities = City::all();
        return view('admin.doctors_edit',compact('doctorEdit', 'specializations', 'cities'));
    }
    public function updateDoctor(Request $request, $id) {
        $doctor = Doctor::findOrFail($id);
        $user = User::findOrFail($doctor->user_id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'full_name' => 'required|string|max:255',
            'specialization_id' => 'required|exists:specializations,id',
            'city_id' => 'required|exists:cities,id',
        ]);

        DB::beginTransaction();
        try {
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            }
            $user->save();

            $doctor->update([
                'full_name' => $request->full_name,
                'specialization_id' => $request->specialization_id,
                'city_id' => $request->city_id,
                'qualifications' => $request->qualifications,
                'phone_number' => $request->phone_number,
                'description' => $request->description,
            ]);

            DB::commit();
            return redirect()->route('admin.doctors')->with('success', 'Updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()])->withInput();
        }
    }
    public function deleteDoctor($id) {
        $doctor = Doctor::findOrFail($id);
        User::destroy($doctor->user_id);
        return view('admin.doctors_edit', compact('doctor'));
    }

    // ==========================================
    // QUẢN LÝ HỦY LỊCH (Lễ tân xử lý)
    // ==========================================
    public function manageCancellations(Request $request)
    {
        $query = Booking::with(['patient.user', 'timeSlot.doctorSchedule.doctor'])
            ->where('status', 3) // chỉ lịch đã hủy
            ->orderByDesc('updated_at');

        // Filter: tất cả / chưa xử lý / đã xử lý
        if ($request->filled('filter')) {
            if ($request->filter === 'unhandled') {
                $query->where('admin_handled', 0);
            } elseif ($request->filter === 'handled') {
                $query->where('admin_handled', 1);
            }
        } // mặc định: hiện tất cả

        $cancellations = $query->get();

        // Thống kê
        $stats = [
            'total' => Booking::where('status', 3)->count(),
            'unhandled' => Booking::where('status', 3)->where('admin_handled', 0)->count(),
            'handled' => Booking::where('status', 3)->where('admin_handled', 1)->count(),
        ];

        // Danh sách bác sĩ để chuyển
        $doctors = Doctor::with('user', 'specialization', 'city')->get();

        return view('admin.cancellations', compact('cancellations', 'stats', 'doctors'));
    }

    // Chuyển booking sang bác sĩ khác (giữ nguyên slot thời gian)
    public function transferBooking(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'new_doctor_id' => 'required|exists:doctors,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $oldBooking = Booking::with(['timeSlot.doctorSchedule', 'patient'])->findOrFail($request->booking_id);

        if ($oldBooking->status != 3 || $oldBooking->admin_handled) {
            return back()->with('error', 'Lịch này đã được xử lý hoặc không phải trạng thái hủy!');
        }

        DB::beginTransaction();
        try {
            $oldSlot = $oldBooking->timeSlot;
            $oldSchedule = $oldSlot?->doctorSchedule;

            // Tìm hoặc tạo DoctorSchedule cho bác sĩ mới vào cùng ngày + giờ
            $newSchedule = DoctorSchedule::firstOrCreate([
                'doctor_id' => $request->new_doctor_id,
                'work_date' => $oldSchedule?->work_date ?? now()->toDateString(),
                'start_time' => $oldSlot?->start_time ?? '08:00',
                'end_time' => $oldSlot?->end_time ?? '08:30',
            ]);

            // Tìm hoặc tạo TimeSlot mới
            $newSlot = TimeSlot::firstOrCreate([
                'schedule_id' => $newSchedule->id,
                'start_time' => $oldSlot?->start_time ?? '08:00',
                'end_time' => $oldSlot?->end_time ?? '08:30',
            ], [
                'max_patient' => 1,
                'current_patient' => 0,
                'status' => 1,
            ]);

            if ($newSlot->current_patient >= $newSlot->max_patient) {
                DB::rollBack();
                return back()->with('error', 'Ca này của bác sĩ mới đã đầy. Vui lòng chọn bác sĩ khác!');
            }

            // Tạo booking mới cho bác sĩ mới
            $newBooking = Booking::create([
                'slot_id' => $newSlot->id,
                'patient_id' => $oldBooking->patient_id,
                'status' => 1, // tự động xác nhận (admin đã sắp xếp)
                'created_by' => auth()->id(),
                'cancel_reason' => null,
                'patient_read' => 1,
            ]);

            $newSlot->increment('current_patient');
            if ($newSlot->current_patient >= $newSlot->max_patient) {
                $newSlot->update(['status' => 0]);
            }

            // Cập nhật booking cũ: đánh dấu đã xử lý + ghi chú + link sang booking mới
            $oldBooking->update([
                'admin_handled' => 1,
                'handled_note' => 'Đã chuyển sang bác sĩ khác. ' . ($request->notes ?? ''),
                'transferred_to_id' => $newBooking->id,
            ]);

            // Thông báo cho bệnh nhân về lịch mới
            $patientUser = $oldBooking->patient?->user;
            $doctorName = Doctor::find($request->new_doctor_id)?->full_name ?? 'Bác sĩ mới';
            if ($patientUser) {
                Notification::create([
                    'user_id' => $patientUser->id,
                    'type' => 'booking_transferred',
                    'data' => [
                        'new_doctor_name' => $doctorName,
                        'work_date' => $newSchedule->work_date,
                        'time_slot' => ($newSlot->start_time ?? '') . ' - ' . ($newSlot->end_time ?? ''),
                        'note' => $request->notes ?? 'Lịch khám của bạn đã được sắp xếp lại.',
                    ],
                    'booking_id' => $newBooking->id,
                ]);
            }

            DB::commit();
            return back()->with('success', 'Đã chuyển lịch sang bác sĩ ' . $doctorName . ' thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // Đánh dấu đã xử lý hủy lịch (sau khi gọi khách, không chuyển)
    public function handleCancellation(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'handled_note' => 'nullable|string|max:500',
            'action' => 'required|in:handled,rescheduled',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        if ($booking->status != 3 || $booking->admin_handled) {
            return back()->with('error', 'Lịch này đã được xử lý hoặc không phải trạng thái hủy!');
        }

        $notes = $request->handled_note ?? '';
        if ($request->action === 'rescheduled') {
            $notes = 'Bệnh nhân đã được sắp xếp lịch mới. ' . $notes;
        } else {
            $notes = 'Đã gọi khách - xác nhận đồng ý hủy. ' . $notes;
        }

        $booking->update([
            'admin_handled' => 1,
            'handled_note' => $notes,
        ]);

        return back()->with('success', 'Đã cập nhật trạng thái xử lý!');
    }
}
