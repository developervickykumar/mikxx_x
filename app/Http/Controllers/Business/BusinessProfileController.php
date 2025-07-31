<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BusinessProfileController extends Controller
{
    public function index()
    {
        dd('fff');
        $business = Auth::user()->businesses()->first();
        
        if (!$business) {
            return redirect()->route('business.create')
                ->with('warning', 'Please create a business first.');
        }

        return view('business.profile.index', compact('business'));
    }

    public function edit()
    {
        $business = Auth::user()->businesses()->first();
        
        if (!$business) {
            return redirect()->route('business.create')
                ->with('warning', 'Please create a business first.');
        }

        return view('business.profile.edit', compact('business'));
    }

    public function update(Request $request)
    {
        $business = Auth::user()->businesses()->first();
        
        if (!$business) {
            return redirect()->route('business.create')
                ->with('warning', 'Please create a business first.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'gst_number' => 'nullable|string|max:20',
            'working_hours' => 'required|array',
            'social_media' => 'nullable|array',
            'logo' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            if ($business->logo) {
                Storage::disk('public')->delete($business->logo);
            }
            $validated['logo'] = $request->file('logo')->store('businesses/logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            if ($business->cover_image) {
                Storage::disk('public')->delete($business->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('businesses/cover_images', 'public');
        }

        $business->update($validated);

        return redirect()->route('business.profile')
            ->with('success', 'Business profile updated successfully.');

    }
    public function profiles()
    {
        dd("1233");
        
    }
} 