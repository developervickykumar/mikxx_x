<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessRole;
use App\Models\BusinessPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessRoleController extends Controller
{
    public function index(Business $business)
    {
        $this->authorize('manageRoles', $business);
        
        $roles = $business->roles()->with('permissions')->get();
        return view('business.roles.index', compact('business', 'roles'));
    }

    public function create(Business $business)
    {
        $this->authorize('manageRoles', $business);
        
        $permissions = $business->permissions()->get()->groupBy('module');
        return view('business.roles.create', compact('business', 'permissions'));
    }

    public function store(Request $request, Business $business)
    {
        $this->authorize('manageRoles', $business);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:business_permissions,id'
        ]);

        $role = $business->roles()->create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description']
        ]);

        $role->permissions()->attach($validated['permissions']);

        return redirect()->route('business.roles.index', $business)
            ->with('success', 'Role created successfully.');
    }

    public function edit(Business $business, BusinessRole $role)
    {
        $this->authorize('manageRoles', $business);
        
        $permissions = $business->permissions()->get()->groupBy('module');
        return view('business.roles.edit', compact('business', 'role', 'permissions'));
    }

    public function update(Request $request, Business $business, BusinessRole $role)
    {
        $this->authorize('manageRoles', $business);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:business_permissions,id'
        ]);

        $role->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description']
        ]);

        $role->permissions()->sync($validated['permissions']);

        return redirect()->route('business.roles.index', $business)
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(Business $business, BusinessRole $role)
    {
        $this->authorize('manageRoles', $business);
        
        if ($role->is_default) {
            return redirect()->route('business.roles.index', $business)
                ->with('error', 'Cannot delete default role.');
        }

        $role->delete();

        return redirect()->route('business.roles.index', $business)
            ->with('success', 'Role deleted successfully.');
    }
} 