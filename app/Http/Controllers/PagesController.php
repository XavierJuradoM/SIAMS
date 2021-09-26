<?php

namespace App\Http\Controllers;
use App\TrayectoriaDet;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {  
        return view('nuevo');
    }

    public function prediction(){
        return view('prediction');
    }
}
