<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  
use App\Models\LoginHistory;
use App\Models\Category;

class UserSettingsController extends Controller
{
    public function index(Request $request)
    {
 
        $user = Auth::user();
        
        $settingsData = Category::where('parent_id', '76027')->get(); 
        
        // dd($settingsData);

        return view('users.settings', compact('user', 'settingsData'));
    }
}
