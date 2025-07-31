<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
 
use App\Models\LoginHistory; 

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
public function create(): View
{
    if(Auth::check())
    {
        return redirect('/admin/post');
    }
      return view('auth.login');
    
    
}

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{

  
    $request->authenticate();
    $request->session()->regenerate();

    $user = Auth::user();
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

    // Basic detection logic
    $deviceType = 'Desktop';
    if (preg_match('/Mobile|Android|iPhone|iPad/i', $userAgent)) {
        $deviceType = 'Mobile';
    } elseif (preg_match('/Tablet|iPad/i', $userAgent)) {
        $deviceType = 'Tablet';
    }

    $browser = 'Unknown';
    if (strpos($userAgent, 'Chrome') !== false) $browser = 'Chrome';
    elseif (strpos($userAgent, 'Firefox') !== false) $browser = 'Firefox';
    elseif (strpos($userAgent, 'Safari') !== false) $browser = 'Safari';
    elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) $browser = 'Internet Explorer';
    elseif (strpos($userAgent, 'Edge') !== false) $browser = 'Edge';

    $os = 'Unknown';
    if (preg_match('/Windows NT 10.0/i', $userAgent)) $os = 'Windows 10';
    elseif (preg_match('/Windows NT 6.3/i', $userAgent)) $os = 'Windows 8.1';
    elseif (preg_match('/Windows NT 6.1/i', $userAgent)) $os = 'Windows 7';
    elseif (preg_match('/Mac OS X/i', $userAgent)) $os = 'Mac OS X';
    elseif (preg_match('/Android/i', $userAgent)) $os = 'Android';
    elseif (preg_match('/iPhone|iPad/i', $userAgent)) $os = 'iOS';
    elseif (preg_match('/Linux/i', $userAgent)) $os = 'Linux';
    
    
    $ip = $request->ip(); //  use '127.0.0.1' for local testing

    $location = 'Unknown';
    try {
        $geo = @json_decode(file_get_contents("https://ipinfo.io/{$ip}/json"));
        if (isset($geo->city) || isset($geo->region) || isset($geo->country)) {
            $location = trim("{$geo->city}, {$geo->region}, {$geo->country}", ', ');
        }
    } catch (\Exception $e) {
        $location = 'Unknown';
    }


    LoginHistory::create([
        'user_id'       => $user->id,
        'login_time'    => now(),
        'ip_address'    => $request->ip(),
        'location'      => $location,
        'device_type'   => $deviceType,
        'device_model'  => 'Unknown', // Detecting model precisely needs JS or advanced UA parsing
        'browser'       => $browser,
        'os'            => $os,
        'status'        => 'success',
        'is_suspicious' => false,
    ]);

    return redirect()->intended(route('post.index', absolute: false));

}


    /**
     * Destroy an authenticated session.
     */
    
    
    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            LoginHistory::where('user_id', Auth::id())
                ->whereNull('logout_time')
                ->latest()
                ->first()?->update(['logout_time' => now()]);
        }
    
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
    

}
