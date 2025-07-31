<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  
use App\Models\LoginHistory;
use App\Models\Category;

class ShoppingController extends Controller
{
    public function index(Request $request)
    {

        return view('shopping.index');
    }
}
