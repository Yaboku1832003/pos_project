<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //user dashboard
    public function dashboard(){
        $products = Product::get();
        return view('user.home.userHomePage',compact('products'));
    }
}
