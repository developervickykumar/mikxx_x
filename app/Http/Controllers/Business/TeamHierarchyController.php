<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Location;
use App\Models\Role;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TeamHierarchyController extends Controller
{
    public function index(Business $business)
    {
        $locations = Cache::remember("business.{$business->id}.locations", 300, function () use ($business) {
            return $business->locations()
                ->with(['children', 'teamMembers.user', 'teamMembers.role'])
                ->whereNull('parent_id')
                ->get();
        });

        $roles = Cache::remember("business.{$business->id}.roles", 300, function () use ($business) {
            return $business->roles()->active()->get();
        });

        return view('business.team_hierarchy.index', compact('business', 'locations', 'roles'));
    }

    public function createLocation(Business $business)
    {
        $parentLocations = $business->locations()
            ->whereNull('parent_id')
            ->get();

        return view('business.team_hierarchy.location_form', compact('business', 'parentLocations'));
    }

    public function storeLocation(Request $request, Business $business)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:country,state,district,area,branch',
            'parent_id' => 'nullable|exists:locations,id',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'working_hours' => 'nullable|array',
            'contact_info' => 'nullable|array',
            'is_active' => 'boolean'
        ]);

        DB::transaction(function () use ($business, $validated) {
            $location = $business->locations()->create($validated);
            Cache::forget("business.{$business->id}.locations");
        });

        return redirect()->route('businesses.team_hierarchy.index', $business)
            ->with('success', 'Location created successfully.');
    }

    public function createRole(Business $business)
    {
        return view('business.team_hierarchy.role_form', compact('business'));
    }

    public function storeRole(Request $request, Business $business)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'permissions.*' => 'string',
            'is_active' => 'boolean'
        ]);

        DB::transaction(function () use ($business, $validated) {
            $role = $business->roles()->create($validated);
            Cache::forget("business.{$business->id}.roles");
        });

        return redirect()->route('businesses.team_hierarchy.index', $business)
            ->with('success', 'Role created successfully.');
    }

    public function assignTeamMember(Request $request, Business $business)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
            'location_id' => 'required|exists:locations,id',
            'manager_id' => 'nullable|exists:team_members,id',
            'additional_permissions' => 'nullable|array',
            'additional_permissions.*' => 'string',
            'is_active' => 'boolean'
        ]);

        DB::transaction(function () use ($business, $validated) {
            $teamMember = $business->teamMembers()->create($validated);
            Cache::forget("business.{$business->id}.locations");
        });

        return redirect()->route('businesses.team_hierarchy.index', $business)
            ->with('success', 'Team member assigned successfully.');
    }

    public function updateTeamMember(Request $request, Business $business, TeamMember $teamMember)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'location_id' => 'required|exists:locations,id',
            'manager_id' => 'nullable|exists:team_members,id',
            'additional_permissions' => 'nullable|array',
            'additional_permissions.*' => 'string',
            'is_active' => 'boolean'
        ]);

        DB::transaction(function () use ($teamMember, $validated, $business) {
            $teamMember->update($validated);
            Cache::forget("business.{$business->id}.locations");
        });

        return redirect()->route('businesses.team_hierarchy.index', $business)
            ->with('success', 'Team member updated successfully.');
    }

    public function removeTeamMember(Business $business, TeamMember $teamMember)
    {
        DB::transaction(function () use ($teamMember, $business) {
            $teamMember->delete();
            Cache::forget("business.{$business->id}.locations");
        });

        return redirect()->route('businesses.team_hierarchy.index', $business)
            ->with('success', 'Team member removed successfully.');
    }
} 