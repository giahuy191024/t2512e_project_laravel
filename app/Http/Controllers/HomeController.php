<?php

namespace App\Http\Controllers;
class HomeController
{
    public function index()
    {
        return view('welcome');
    }
    public function index2(){
        return 'hello work';
    }
    public function index3(){
        return 'hello angel';
    }
}
