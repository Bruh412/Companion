<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminHome(){
        return view("admin.adminHome");
    }
    public function logout(){
        Auth::logout();
        return redirect()->to(route('login'));
    }

    public function newUI(){
        return view("admin.test");
    }
}
