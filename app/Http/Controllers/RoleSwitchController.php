<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RoleSwitchController extends Controller
{
    public function switch($role)
    {
        $user = Auth::user();

        // Optional: verify the user actually has access to the role
        if (!in_array($role, ['user', 'admin', 'business']) || ($role === 'admin' && !$user->is_admin)) {
            abort(403, 'Unauthorized role switch');
        }

        Session::put('active_role', $role);

        return redirect()->route($role . '.dashboard');
    }
}
