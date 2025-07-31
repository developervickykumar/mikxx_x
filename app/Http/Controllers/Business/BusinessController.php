<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Business\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BusinessController extends Controller
{
    public function index()
    {
        $businesses = Business::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

          

        return view('business.businesses.index', compact('businesses'));
    }

    public function create()
    {
        return view('business.businesses.create');
    }

    public function store(Request $request)
    {
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

        $validated['slug'] = Str::slug($validated['name']);
        $validated['user_id'] = Auth::id();
        $validated['is_verified'] = false;
        $validated['is_active'] = true;

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('businesses/logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('businesses/cover_images', 'public');
        }

        $business = Business::create($validated);

        return redirect()->route('business.businesses.show', $business)
            ->with('success', 'Business created successfully.');
    }

    public function show(Business $business)
    {
        return view('business.businesses.show', compact('business'));
    }

    public function edit(Business $business)
    {
        return view('business.businesses.edit', compact('business'));
    }

    public function update(Request $request, Business $business)
    {
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
            $validated['logo'] = $request->file('logo')->store('businesses/logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('businesses/cover_images', 'public');
        }

        $business->update($validated);

        return redirect()->route('business.businesses.show', $business)
            ->with('success', 'Business updated successfully.');
    }

    public function destroy(Business $business)
    {
        $business->delete();

        return redirect()->route('business.businesses.index')
            ->with('success', 'Business deleted successfully.');
    }
} 