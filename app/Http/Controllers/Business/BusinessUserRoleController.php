<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessRole;
use App\Models\User;
use Illuminate\Http\Request;

class BusinessUserRoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(BusinessRole::class, 'role');
    }

    /**
     * Display a listing of the users with their roles.
     */
    public function index(Business $business)
    {
        $users = $business->users()
            ->with('businessRoles')
            ->orderBy('name')
            ->paginate(10);

        $roles = $business->roles()
            ->orderBy('name')
            ->get();

        return view('business.user-roles.index', compact('business', 'users', 'roles'));
    }

    /**
     * Show the form for assigning roles to a user.
     */
    public function edit(Business $business, User $user)
    {
        $user->load('businessRoles');
        $roles = $business->roles()
            ->orderBy('name')
            ->get();

        return view('business.user-roles.edit', compact('business', 'user', 'roles'));
    }

    /**
     * Update the roles assigned to a user.
     */
    public function update(Request $request, Business $business, User $user)
    {
        $validated = $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:business_roles,id'
        ]);

        $user->businessRoles()->sync($validated['roles']);

        return redirect()
            ->route('business.user-roles.index', $business)
            ->with('success', 'User roles updated successfully.');
    }

    /**
     * Remove all roles from a user.
     */
    public function destroy(Business $business, User $user)
    {
        $user->businessRoles()->detach();

        return redirect()
            ->route('business.user-roles.index', $business)
            ->with('success', 'User roles removed successfully.');
    }
} 