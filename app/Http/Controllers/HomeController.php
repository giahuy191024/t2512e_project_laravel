<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
class HomeController
{
    public function index()
    {
        return view('home');
    }
    public function index2(){
        return 'hello work';
    }
    public function index3(){
        return 'hello angel';
    }
}
