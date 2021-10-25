<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Admin; 
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        // return var_dump(auth()->user()->email);
        return view('admin');
    }
}
