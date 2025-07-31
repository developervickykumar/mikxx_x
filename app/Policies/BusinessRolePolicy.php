<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\BusinessRole;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessRolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any roles.
     */
    public function viewAny(User $user, Business $business): bool
    {
        return $user->businesses->contains($business) && 
               $user->hasBusinessPermission($business, 'manage_roles');
    }

    /**
     * Determine whether the user can view the role.
     */
    public function view(User $user, Business $business, BusinessRole $role): bool
    {
        return $user->businesses->contains($business) && 
               $user->hasBusinessPermission($business, 'manage_roles');
    }

    /**
     * Determine whether the user can create roles.
     */
    public function create(User $user, Business $business): bool
    {
        return $user->businesses->contains($business) && 
               $user->hasBusinessPermission($business, 'manage_roles');
    }

    /**
     * Determine whether the user can update the role.
     */
    public function update(User $user, Business $business, BusinessRole $role): bool
    {
        return $user->businesses->contains($business) && 
               $user->hasBusinessPermission($business, 'manage_roles');
    }

    /**
     * Determine whether the user can delete the role.
     */
    public function delete(User $user, Business $business, BusinessRole $role): bool
    {
        return $user->businesses->contains($business) && 
               $user->hasBusinessPermission($business, 'manage_roles') &&
               !$role->is_default;
    }
} 