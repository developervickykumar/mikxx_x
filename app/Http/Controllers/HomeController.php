<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Candidate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (view()->exists($request->path())) {
            $events = Event::where('date', '>=', now())->orderBy('date')->get();
            // return view('events', compact('events'));
            return view($request->path(), compact('events'));
        }
        return abort(404);
    }

    public function switchToCandidate($candidateId = 2) 
    {
        $candidate = User::findOrFail($candidateId);
        if ($candidate->isCandidate()) {
            session(['original_admin_id' => Auth::id()]);

            Auth::login($candidate);
            
            return redirect()->route('admin'); 
        }

        return redirect()->back()->withErrors('You can only switch to candidates.');
    }

    public function switchToTeam($TeamId = 15) 
    {
        $candidate = User::findOrFail($TeamId);
        if ($candidate->isTeam()) {
            session(['original_admin_id' => Auth::id()]);

            Auth::login($candidate);
            
            return redirect()->route('admin'); 
        }

        return redirect()->back()->withErrors('You can only switch to candidates.');
    }

    public function revertToAdmin()
    {
        $originalAdminId = session('original_admin_id');

        if ($originalAdminId) {
            $originalAdmin = User::findOrFail($originalAdminId);
            Auth::login($originalAdmin);
            session()->forget('original_admin_id');

            return redirect()->route('admin'); 
        }

        return redirect()->route('admin')->withErrors('No original admin session found.');
    }

    
    public function root()
    {
        $events = Event::where('date', '>=', now())->orderBy('date')->get();
        return view('index', compact('events'));
    }

    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }


    public function editProfile(Request $request, $id)
    {
        $currentUser = auth()->user(); 
        $user = User::find($currentUser->id);
        $candidate = $user->candidate;  
        $socialLinks = $candidate->social_links ?? [];

        $states = [];
        return view('edit-profile', compact('user', 'candidate', 'states', 'socialLinks'));
    }

    
    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $id,
            'email' => 'nullable|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:10',
            'fathers_name' => 'nullable|string|max:255',
            'age' => 'nullable|integer',
            'dob' => 'nullable|date',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'profile_pic' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'cover_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
        ]);
    
        $user = User::findOrFail($id);
        $candidate = $user->candidate;
    
        $user->update($request->only([
            'first_name',
            'last_name',
            'username',
            'email',
            'phone',
            'gender'
        ]));
    
        if ($candidate) {
            if ($request->hasFile('profile_pic')) {
                // Remove the previous profile picture if it exists
                if ($candidate->profile_pic) {
                    $oldProfilePicPath = storage_path('app/public/build/images/candidates/' . $candidate->profile_pic);
                    if (file_exists($oldProfilePicPath)) {
                        unlink($oldProfilePicPath);
                    }
                }
    
                // Store new profile picture
                $profilePicName = $user->first_name . '_' . $user->id . '_profile.' . $request->file('profile_pic')->extension();
                $request->file('profile_pic')->storeAs('public/build/images/candidates', $profilePicName);
                $candidate->profile_pic = $profilePicName;
            }
    
            if ($request->hasFile('cover_photo')) {
                // Remove the previous cover photo if it exists
                if ($candidate->cover_photo) {
                    $oldCoverPhotoPath = storage_path('app/public/build/images/candidates/' . $candidate->cover_photo);
                    if (file_exists($oldCoverPhotoPath)) {
                        unlink($oldCoverPhotoPath);
                    }
                }
    
                $coverPhotoName = $user->first_name . '_' . $user->id . '_cover.' . $request->file('cover_photo')->extension();
                $request->file('cover_photo')->storeAs('public/build/images/candidates', $coverPhotoName);
                $candidate->cover_photo = $coverPhotoName;
            }
           
            $socialLinks = [];

            if ($request->has('social_links')) {
                $socialLinksInput = $request->input('social_links');
                $platforms = [];
                $urls = [];
            
                foreach ($socialLinksInput as $item) {
                    if (isset($item['platform'])) {
                        $platforms[] = $item['platform']; 
                    }
                    if (isset($item['url'])) {
                        $urls[] = $item['url']; 
                    }
                }
            
                for ($i = 0; $i < count($platforms); $i++) {
                    $socialLinks[$platforms[$i]] = [
                        'platform' => $platforms[$i],
                        'url' => isset($urls[$i]) ? $urls[$i] : null
                    ];
                }
            }

            $candidate->update($request->only([
                'fathers_name',
                'age',
                'dob',
                'city',
                'state',
                'country',
                'portfolio_url'
            ]));
    
            $candidate->social_links = $socialLinks;
            $candidate->save();
        }
    
        return response()->json(['isSuccess' => true, 'Message' => 'Profile updated successfully.']);
    }
    
    public function updatePassword(Request $request)
    {

        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
       
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Your Current password does not matches with the password you provided. Please try again."
            ], 200);  
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Something went wrong!"
                ], 200); // Status code here
            }
        }
    }

    public function updateAdminPassword(Request $request)
    {
        $validated = $request->validate([
            'currentPassword' => ['required', 'current_password'], 
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
 
        $user = Auth::user(); 
        $user->password = Hash::make($request->password); 
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }
}