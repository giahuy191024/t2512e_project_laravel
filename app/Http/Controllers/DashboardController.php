<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Lấy thông tin user đang đăng nhập
        $user = Auth::user();

        // Ông có thể truyền thêm dữ liệu riêng biệt cho từng role nếu cần
        $data = [];

        if ($user->role === 'admin') {
            // Ví dụ: Admin thì lấy thêm tổng số bác sĩ, bệnh nhân
            // $data['totalDoctors'] = User::where('role', 'doctor')->count();
        }

        // Trả về đúng 1 view chung duy nhất
        return view('dashboard', compact('user', 'data'));
    }
}
