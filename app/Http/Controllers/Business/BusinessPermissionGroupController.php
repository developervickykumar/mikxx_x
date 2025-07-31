<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessPermissionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessPermissionGroupController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(BusinessPermissionGroup::class, 'permission-group');
    }

    /**
     * Display a listing of the permission groups.
     */
    public function index(Business $business)
    {
        $groups = $business->permissionGroups()
            ->with('permissions')
            ->orderBy('name')
            ->get();

        return view('business.permission-groups.index', compact('business', 'groups'));
    }

    /**
     * Show the form for creating a new permission group.
     */
    public function create(Business $business)
    {
        $permissions = $business->permissions()
            ->orderBy('module')
            ->orderBy('name')
            ->get()
            ->groupBy('module');

        return view('business.permission-groups.create', compact('business', 'permissions'));
    }

    /**
     * Store a newly created permission group in storage.
     */
    public function store(Request $request, Business $business)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:business_permissions,id'
        ]);

        $group = $business->permissionGroups()->create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description']
        ]);

        $group->permissions()->attach($validated['permissions']);

        return redirect()
            ->route('business.permission-groups.index', $business)
            ->with('success', 'Permission group created successfully.');
    }

    /**
     * Show the form for editing the specified permission group.
     */
    public function edit(Business $business, BusinessPermissionGroup $permissionGroup)
    {
        $permissions = $business->permissions()
            ->orderBy('module')
            ->orderBy('name')
            ->get()
            ->groupBy('module');

        return view('business.permission-groups.edit', compact('business', 'permissionGroup', 'permissions'));
    }

    /**
     * Update the specified permission group in storage.
     */
    public function update(Request $request, Business $business, BusinessPermissionGroup $permissionGroup)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:business_permissions,id'
        ]);

        $permissionGroup->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description']
        ]);

        $permissionGroup->permissions()->sync($validated['permissions']);

        return redirect()
            ->route('business.permission-groups.index', $business)
            ->with('success', 'Permission group updated successfully.');
    }

    /**
     * Remove the specified permission group from storage.
     */
    public function destroy(Business $business, BusinessPermissionGroup $permissionGroup)
    {
        if ($permissionGroup->is_system) {
            return redirect()
                ->route('business.permission-groups.index', $business)
                ->with('error', 'Cannot delete system permission group.');
        }

        $permissionGroup->delete();

        return redirect()
            ->route('business.permission-groups.index', $business)
            ->with('success', 'Permission group deleted successfully.');
    }
} 