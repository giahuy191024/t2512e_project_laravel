<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
class HomeController
{
    public function index()
    {
        /*$featuredDoctor = Doctor::where('featured', 1)->first();

        $northDoctors = Doctor::where('region', 'north')->get();

        $centralDoctors = Doctor::where('region', 'central')->get();

        $southDoctors = Doctor::where('region', 'south')->get();

        return view('home', compact(
            'featuredDoctor',
            'northDoctors',
            'centralDoctors',
            'southDoctors'
        ));
        */
    }
    public function index2(){
        return 'hello work';
    }
    public function index3(){
        return 'hello angel';
    }
}
