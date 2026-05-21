<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
class HomeController
{
    public function index()
    {
        $doctors = Doctor::all();

        return view('auth', compact('doctors'));
    }
    public function index2(){
        return 'hello work';
    }
    public function index3(){
        return 'hello angel';
    }
}
