<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
class AdminController extends Controller{
    public function manageAccount(){
        $users = User::all();
        return view('admin.account', compact('users'));
    }
    public function manageDoctors(){
        $doctors = User::where('role', 'doctor')->get();
        return view('admin.doctors', compact('doctors'));
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
}
