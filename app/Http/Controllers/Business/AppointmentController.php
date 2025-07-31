<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Business $business)
    {
        $appointments = $business->appointments()
            ->with(['user', 'service'])
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        return view('appointments.index', compact('business', 'appointments'));
    }

    public function create(Business $business, Service $service)
    {
        return view('appointments.create', compact('business', 'service'));
    }

    public function store(Request $request, Business $business, Service $service)
    {
        $validated = $request->validate([
            'start_time' => 'required|date|after:now',
            'notes' => 'nullable|string'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['end_time'] = $validated['start_time']->addMinutes($service->duration ?? 60);
        $validated['status'] = 'pending';

        $appointment = $business->appointments()->create($validated);

        return redirect()->route('businesses.appointments.show', [$business, $appointment])
            ->with('success', 'Appointment booked successfully.');
    }

    public function show(Business $business, Appointment $appointment)
    {
        return view('appointments.show', compact('business', 'appointment'));
    }

    public function update(Request $request, Business $business, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string'
        ]);

        $appointment->update($validated);

        return redirect()->route('businesses.appointments.show', [$business, $appointment])
            ->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Business $business, Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('businesses.appointments.index', $business)
            ->with('success', 'Appointment cancelled successfully.');
    }
} 