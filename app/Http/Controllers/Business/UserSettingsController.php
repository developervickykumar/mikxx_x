<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business\BusinessSettings;
use App\Models\User;

class UserSettingsController extends Controller
{
    public function index()
    {
        return view('business.user.settings.index');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'preferences' => 'nullable|array',
        ]);

        $user->update($validated);

        return back()->with('success', 'Settings updated successfully');
    }

    public function updateNotificationPreferences(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
        ]);

        $user->update([
            'notification_preferences' => $validated
        ]);

        return back()->with('success', 'Notification preferences updated successfully');
    }

    public function updatePrivacySettings(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'profile_visibility' => 'required|in:public,private,connections',
            'show_email' => 'boolean',
            'show_phone' => 'boolean',
        ]);

        $user->update([
            'privacy_settings' => $validated
        ]);

        return back()->with('success', 'Privacy settings updated successfully');
    }
} 