<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Patient;

class AuthController extends Controller
{
    public function handleAuth(Request $request)
    {
        // phân biệt login hay register
        if ($request->type === 'register') {

            $request->validate([
                'full_name' => 'required',                     // đổi từ "name" → "full_name"
                'email'     => 'required|email|unique:users',
                'password'  => 'required|min:6',
            ]);

            $user = User::create([
                'full_name' => $request->full_name,            // đổi từ "name" → "full_name"
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'role'      => User::ROLE_PATIENT,             // mặc định đăng ký là bệnh nhân
                'status'    => 'active',
            ]);

            // Tự động tạo record Patient gắn với User vừa tạo
            // (vì trong schema mới, thông tin bệnh nhân ở bảng riêng)
            Patient::create([
                'user_id'       => $user->id,
                'email_contact' => $user->email,
            ]);

            return back()->with('success', 'Đăng ký thành công');
        }

        if ($request->type === 'login') {

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect('/dashboard');
            }

            return back()->with('error', 'Sai tài khoản hoặc mật khẩu');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
