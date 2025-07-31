<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Business $business)
    {
        $services = $business->services()->where('is_available', true)->paginate(10);
        return view('services.index', compact('business', 'services'));
    }

    public function show(Business $business, Service $service)
    {
        return view('services.show', compact('business', 'service'));
    }

    public function create(Business $business)
    {
        return view('services.create', compact('business'));
    }

    public function store(Request $request, Business $business)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
            'availability' => 'nullable|json'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $business->services()->create($validated);

        return redirect()->route('businesses.services.index', $business)
            ->with('success', 'Service created successfully.');
    }

    public function edit(Business $business, Service $service)
    {
        return view('services.edit', compact('business', 'service'));
    }

    public function update(Request $request, Business $business, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
            'availability' => 'nullable|json'
        ]);

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($validated);

        return redirect()->route('businesses.services.show', [$business, $service])
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Business $business, Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('businesses.services.index', $business)
            ->with('success', 'Service deleted successfully.');
    }
} 