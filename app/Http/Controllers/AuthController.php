<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function handleAuth(Request $request)
    {
        // phân biệt login hay register
        if ($request->type === 'register') {

            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6'
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return back()->with('success', 'Đăng ký thành công');
        }

        if ($request->type === 'login') {

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
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
