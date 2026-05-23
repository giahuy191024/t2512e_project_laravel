<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Booking;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Specialty;
use App\Models\City;

class AdminController extends Controller
{
    // Map giữa tên role trong form (string) và role trong DB (int)
    // Form vẫn dùng 'admin'/'doctor'/'patient' cho dễ đọc, DB lưu 0/1/2
    private array $roleMap = [
        'patient' => User::ROLE_PATIENT,  // 0
        'doctor'  => User::ROLE_DOCTOR,   // 1
        'admin'   => User::ROLE_ADMIN,    // 2
    ];

    // ===== TRANG DANH SÁCH =====

    public function manageAccount(Request $request){
        $query = User::query();

        // Filter search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        // Filter role
        if ($role = $request->input('role')) {
            $query->where('role', $this->roleMap[$role] ?? -1);
        }

        $users = $query->orderByDesc('created_at')->get();

        $stats = [
            'total'   => User::count(),
            'admin'   => User::where('role', User::ROLE_ADMIN)->count(),
            'doctor'  => User::where('role', User::ROLE_DOCTOR)->count(),
            'patient' => User::where('role', User::ROLE_PATIENT)->count(),
        ];

        return view('admin.accounts', compact('users', 'stats'));
    }

    public function manageDoctors(){
        $doctors = Doctor::with(['user', 'specialty', 'city'])->get();
        $specialties = Specialty::active()->orderBy('sort_order')->get();
        $cities      = City::active()->orderBy('sort_order')->get();
        return view('admin.doctors', compact('doctors', 'specialties', 'cities'));
    }

    public function managePatients(){
        // Đổi: role 'patient' → 0, và đổi tên relationship cho khớp model mới
        $patients = User::where('role', User::ROLE_PATIENT)
            ->with(['patient.bookings.slot.schedule.doctor.user'])
            ->orderByDesc('created_at')
            ->get();
        $totalBookings = Booking::count();
        return view('admin.patients', compact('patients', 'totalBookings'));
    }

    public function manageContents(){
        return view('admin.contents');
    }

    // ===== CRUD TÀI KHOẢN =====

    public function createAccount(){
        return view('admin.accounts_create');
    }

    public function storeAccount(Request $request){
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:admin,doctor,patient',
        ]);
        User::create([
            'full_name' => $request->name,                       // đổi từ 'name' → 'full_name'
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $this->roleMap[$request->role],       // map string → int
            'status'    => 'active',
        ]);
        return redirect()->route('admin.accounts')->with('success', 'Tạo tài khoản thành công!');
    }

    public function editAccount($id){
        $userEdit = User::findOrFail($id);
        return view('admin.accounts_edit', compact('userEdit'));
    }

    public function updateAccount(Request $request, $id) {
        $userEdit = User::findOrFail($id);
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userEdit->id,
            'role'  => 'required|in:admin,doctor,patient',
        ]);
        $userEdit->full_name = $request->name;                   // đổi
        $userEdit->email     = $request->email;
        $userEdit->role      = $this->roleMap[$request->role];   // map
        if ($request->filled('password')) {
            $userEdit->password = Hash::make($request->password);
        }
        $userEdit->save();
        return redirect()->route('admin.accounts')->with('success', 'Cập nhật thành công!');
    }

    public function deleteAccount($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'Đã xóa tài khoản!');
    }

    // ===== CRUD BÁC SĨ =====

    public function storeDoctor(Request $request)
    {
        $request->validate([
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|min:6',
            'full_name'        => 'required|string|max:255',
            'specialty_id'     => 'required|exists:specialties,id',
            'city_id'          => 'required|exists:cities,id',
            'experience_years' => 'nullable|integer|min:0',
            'bio'              => 'nullable|string',
            'status'           => 'nullable|in:0,1',
            'avatar'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',           // 2MB
            'certificate'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',         // 5MB
        ]);

        DB::beginTransaction();
        try {
            // 1. Chuẩn bị data User
            $userData = [
                'full_name' => $request->full_name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'role'      => User::ROLE_DOCTOR,
                'status'    => 'active',
            ];
            // Upload avatar nếu admin có chọn
            if ($request->hasFile('avatar')) {
                $userData['avatar_url'] = $request->file('avatar')->store('avatars', 'public');
            }
            $user = User::create($userData);
            // 2. Chuẩn bị data Doctor
            $doctorData = [
                'user_id'          => $user->id,
                'specialty_id'     => $request->specialty_id,
                'city_id'          => $request->city_id,
                'experience_years' => $request->experience_years,
                'bio'              => $request->bio,
                'status'           => $request->status ?? Doctor::STATUS_ACTIVE,
                'created_by'       => auth()->id(),
            ];
            // Upload certificate nếu admin có chọn
            if ($request->hasFile('certificate')) {
                $doctorData['certificate_url'] = $request->file('certificate')->store('certificates', 'public');
            }

            Doctor::create($doctorData);

            DB::commit();
            return redirect()->route('admin.doctors')->with('success', 'Thêm bác sĩ thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Lỗi: ' . $e->getMessage()])->withInput();
        }
    }

    public function editDoctor($id) {
        $doctorEdit = Doctor::with(['user', 'specialty', 'city'])->findOrFail($id);
        $specialties = Specialty::active()->orderBy('sort_order')->get();
        $cities      = City::active()->orderBy('sort_order')->get();
        return view('admin.doctors_edit', compact('doctorEdit', 'specialties', 'cities'));
    }

    public function updateDoctor(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $user   = User::findOrFail($doctor->user_id);

        $request->validate([
            'email'            => 'required|email|unique:users,email,' . $user->id,
            'full_name'        => 'required|string|max:255',
            'specialty_id'     => 'required|exists:specialties,id',
            'city_id'          => 'required|exists:cities,id',
            'experience_years' => 'nullable|integer|min:0',
            'bio'              => 'nullable|string',
            'status'           => 'nullable|in:0,1',
            'password'         => 'nullable|min:6|confirmed',
            'avatar'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'certificate'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update User
            $user->full_name = $request->full_name;
            $user->email     = $request->email;
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

            // 2. Update Doctor
            $doctorData = [
                'specialty_id'     => $request->specialty_id,
                'city_id'          => $request->city_id,
                'specialty'        => $request->specialty,
                'city'             => $request->city,
                'experience_years' => $request->experience_years,
                'bio'              => $request->bio,
                'status'           => $request->status ?? Doctor::STATUS_ACTIVE,
                'updated_by'       => auth()->id(),
            ];

            if ($request->hasFile('certificate')) {
                if ($doctor->certificate_url && \Storage::disk('public')->exists($doctor->certificate_url)) {
                    \Storage::disk('public')->delete($doctor->certificate_url);
                }
                $doctorData['certificate_url'] = $request->file('certificate')->store('certificates', 'public');
            }

            $doctor->update($doctorData);

            DB::commit();
            return redirect()->route('admin.doctors')->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Lỗi: ' . $e->getMessage()])->withInput();
        }
    }

    public function deleteDoctor($id) {
        $doctor = Doctor::findOrFail($id);
        // Xóa user → CSDL có cascade delete sẽ tự xóa doctor luôn
        User::destroy($doctor->user_id);
        return redirect()->route('admin.doctors')->with('success', 'Đã xóa bác sĩ!');
    }
}
