<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessRole;
use App\Models\BusinessPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessRoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(BusinessRole::class, 'role');
    }

    /**
     * Display a listing of the roles.
     */
    public function index(Business $business)
    {
        $roles = $business->roles()->with('permissions')->get();
        return view('business.roles.index', compact('business', 'roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(Business $business)
    {
        $permissions = $business->permissions()->get()->groupBy('module');
        return view('business.roles.create', compact('business', 'permissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request, Business $business)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:business_permissions,id'
        ]);

        $role = $business->roles()->create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'is_default' => false
        ]);

        $role->permissions()->attach($validated['permissions']);

        return redirect()
            ->route('business.roles.index', $business)
            ->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Business $business, BusinessRole $role)
    {
        $permissions = $business->permissions()->get()->groupBy('module');
        return view('business.roles.edit', compact('business', 'role', 'permissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Business $business, BusinessRole $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:business_permissions,id'
        ]);

        $role->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description']
        ]);

        $role->permissions()->sync($validated['permissions']);

        return redirect()
            ->route('business.roles.index', $business)
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Business $business, BusinessRole $role)
    {
        if ($role->is_default) {
            return redirect()
                ->route('business.roles.index', $business)
                ->with('error', 'Cannot delete default role.');
        }

        $role->delete();

        return redirect()
            ->route('business.roles.index', $business)
            ->with('success', 'Role deleted successfully.');
    }
} 