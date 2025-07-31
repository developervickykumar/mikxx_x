<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class BusinessProController extends Controller
{
    public function index()
    {
      $details = Category::where('parent_id','710')->get();
        return view('backend.business_profile.profile',compact('details'));
    }
}
