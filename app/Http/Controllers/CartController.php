<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  
use App\Models\LoginHistory;
use App\Models\Category;

class CartController extends Controller
{
    public function index(Request $request)
    {


        return view('cart');
    }
}
