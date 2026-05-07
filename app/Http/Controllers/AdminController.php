<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\City;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Doctor;
class AdminController extends Controller{
    public function manageAccount(){
        $users = User::all();
        return view('admin.accounts', compact('users'));
    }
    public function manageDoctors(){
        $doctors = Doctor::with(['user', 'specialization', 'city'])->get();
        $specializations = Specialization::all();
        $cities = City::all();
        return view('admin.doctors', compact('doctors', 'specializations', 'cities'));
    }
    public function managePatients(){
        $patients = User::where('role','patient')->get();
        return view('admin.patients', compact('patients'));
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

        return redirect()->route('admin.accounts')->with('success', 'Cập nhật thành công!');
    }

    // --- XÓA TÀI KHOẢN ---
    public function deleteAccount($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'Đã xóa tài khoản!');
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
            return redirect()->route('admin.doctors')->with('success', 'Thêm Bác sĩ thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Lỗi: ' . $e->getMessage()])->withInput();
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
            return redirect()->route('admin.doctors')->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Lỗi: ' . $e->getMessage()])->withInput();
        }
    }
    public function deleteDoctor($id) {
        $doctor = Doctor::findOrFail($id);
        User::destroy($doctor->user_id);
        return view('admin.doctors_edit', compact('doctor'));
    }
}
