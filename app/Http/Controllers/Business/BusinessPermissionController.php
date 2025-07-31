<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessPermissionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(BusinessPermission::class, 'permission');
    }

    /**
     * Display a listing of the permissions.
     */
    public function index(Business $business)
    {
        $permissions = $business->permissions()
            ->with('groups')
            ->orderBy('module')
            ->orderBy('name')
            ->get()
            ->groupBy('module');

        return view('business.permissions.index', compact('business', 'permissions'));
    }

    /**
     * Show the form for creating a new permission.
     */
    public function create(Business $business)
    {
        $groups = $business->permissionGroups()->get();
        return view('business.permissions.create', compact('business', 'groups'));
    }

    /**
     * Store a newly created permission in storage.
     */
    public function store(Request $request, Business $business)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'action' => 'required|string|max:50',
            'resource_type' => 'required|string|max:50',
            'module' => 'required|string|max:50',
            'page' => 'nullable|string|max:100',
            'groups' => 'nullable|array',
            'groups.*' => 'exists:business_permission_groups,id'
        ]);

        $permission = $business->permissions()->create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'action' => $validated['action'],
            'resource_type' => $validated['resource_type'],
            'module' => $validated['module'],
            'page' => $validated['page']
        ]);

        if (!empty($validated['groups'])) {
            $permission->groups()->attach($validated['groups']);
        }

        return redirect()
            ->route('business.permissions.index', $business)
            ->with('success', 'Permission created successfully.');
    }

    /**
     * Show the form for editing the specified permission.
     */
    public function edit(Business $business, BusinessPermission $permission)
    {
        $groups = $business->permissionGroups()->get();
        return view('business.permissions.edit', compact('business', 'permission', 'groups'));
    }

    /**
     * Update the specified permission in storage.
     */
    public function update(Request $request, Business $business, BusinessPermission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'action' => 'required|string|max:50',
            'resource_type' => 'required|string|max:50',
            'module' => 'required|string|max:50',
            'page' => 'nullable|string|max:100',
            'groups' => 'nullable|array',
            'groups.*' => 'exists:business_permission_groups,id'
        ]);

        $permission->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'action' => $validated['action'],
            'resource_type' => $validated['resource_type'],
            'module' => $validated['module'],
            'page' => $validated['page']
        ]);

        if (isset($validated['groups'])) {
            $permission->groups()->sync($validated['groups']);
        }

        return redirect()
            ->route('business.permissions.index', $business)
            ->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroy(Business $business, BusinessPermission $permission)
    {
        if ($permission->is_system) {
            return redirect()
                ->route('business.permissions.index', $business)
                ->with('error', 'Cannot delete system permission.');
        }

        $permission->delete();

        return redirect()
            ->route('business.permissions.index', $business)
            ->with('success', 'Permission deleted successfully.');
    }
} 