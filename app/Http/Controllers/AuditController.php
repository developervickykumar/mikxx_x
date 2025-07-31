<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\LoginHistory; 


class AuditController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $users = User::with(['role', 'profileFields'])
            ->when($search, fn($q) =>
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
            )->get();

        $roles = Role::all();
        
        $logs = LoginHistory::with('user.role')
        ->orderByDesc('login_time')
        ->get();

         $summary = [
            'total_logins'     => $logs->count(),
            'active_users'     => $logs->where('login_time', '>=', now()->subDay())->unique('user_id')->count(),
            'failed_attempts'  => $logs->where('status', 'failed')->count(),
            'blocked_ips'      => $logs->where('status', 'blocked')->unique('ip_address')->count(),
        ];
         

        
        return view('backend.audit.index', compact('users', 'roles', 'logs', 'summary'));
    }

 
}
