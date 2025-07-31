<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

use App\Models\LoginHistory; 

class UserController extends Controller
{
   
    public function index(Request $request)
    {
        $search = $request->get('search');
    
        $users = User::with(['role', 'profileFields'])
            ->when($search, function($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            })
            ->paginate(20); // Paginate instead of get()
    
        $roles = Role::all();
    
        return view('users.index', compact('users', 'roles'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'contact' => 'nullable|string|max:20',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'user_type' => 'nullable|string',
            'is_admin' => 'nullable|boolean',
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'dob' => $request->dob,
            'gender' => $request->gender,
            'contact' => $request->contact,
            'state' => $request->state,
            'country' => $request->country,
            'user_type' => $request->user_type,
            'is_admin' => $request->is_admin ?? 0,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

public function update(Request $request, User $user)
{
    $data = $request->validate([
        'first_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
        'email' => 'required|email|unique:users,email,' . $user->id,
        'gender' => 'nullable|in:Male,Female,Other',
    ]);

    $user->update($data);

    return back()->with('success', 'User updated successfully.');
}


    public function assignRole(Request $request, User $user)
    {
        $request->validate(['role_id' => 'required|exists:roles,id']);
        $user->role_id = $request->role_id;
        $user->save();
        return redirect()->route('users.index')->with('success', 'Role assigned successfully.');
    }
    
// UserController.php

public function updatePicture(Request $request, User $user)
{
    $request->validate([
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/profile_pics'), $filename);

        // Delete old image if exists
        if ($user->profile_picture && file_exists(public_path('uploads/profile_pics/' . $user->profile_picture))) {
            unlink(public_path('uploads/profile_pics/' . $user->profile_picture));
        }

        $user->update(['profile_picture' => $filename]);
    }

    return back()->with('success', 'Profile picture updated successfully.');
}

   public function details($id)
    {
        $user = User::with([
            'role',
            'profileFields', 
        ])->findOrFail($id);

        // Login History
        $loginHistory = LoginHistory::where('user_id', $user->id)
            ->orderByDesc('login_time')
            ->limit(50)
            ->get();

        // Audit Logs (assumes you have an AuditLog model)
        // $auditLogs = AuditLog::where('user_id', $user->id)
        //     ->orderByDesc('created_at')
        //     ->limit(50)
        //     ->get();

        // Subscription Plan (assumes a subscription relation)
        // $subscription = Subscription::where('user_id', $user->id)
        //     ->orderByDesc('created_at')
        //     ->first();

        // Wallet (if applicable)
        // $wallet = Wallet::where('user_id', $user->id)->first();
        
        $walletBalance ='200';
        $audits =[];

        // Stats (Example Counts)
        $stats = [
            'total_logins' => $loginHistory->count(),
            'failed_logins' => $loginHistory->where('status', 'failed')->count(),
            // 'posts_count' => $user->posts()->count() ?? 0,
            // 'business_owned' => $user->businesses->count(),
        ];

        return view('users.details', compact(
            'user',
            'loginHistory',
            'walletBalance',
            'audits',
            'stats'
        ));
    }

    public function userBusiness($slug)
    {
        
         return view('users.business-page');
        
        
        
    }

}
