<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Phân luồng view theo Role
        switch ($user->role) {
            case 'admin':
                return view('layouts.admin', compact('user'));
            case 'doctor':
                return view('layouts.doctordashboard',compact('user'));
            case 'patient':
                return view('layouts.patient', compact('user'));
            default:
                return view('welcome');
        }
    }
}
