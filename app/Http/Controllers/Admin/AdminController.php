<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //admin dashboard
    public function dashboard(){
        return view('admin.dashboard.mainDashboard');
    }
}
