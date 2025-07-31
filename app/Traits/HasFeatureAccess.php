<?php

namespace App\Traits;

trait HasFeatureAccess
{
    /**
     * Check if the user has access to a specific feature.
     *
     * @param string $feature
     * @return bool
     */
    public function hasFeatureAccess(string $feature): bool
    {
        // Get user's role and permissions
        $role = $this->role;
        $permissions = $this->permissions;

        // Check if user has direct permission for the feature
        if ($permissions->contains('name', $feature)) {
            return true;
        }

        // Check if user's role has access to the feature
        if ($role && $role->hasFeatureAccess($feature)) {
            return true;
        }

        return false;
    }

    /**
     * Get all features the user has access to.
     *
     * @return array
     */
    public function getAccessibleFeatures(): array
    {
        $features = [];

        // Get features from direct permissions
        $features = array_merge($features, $this->permissions->pluck('name')->toArray());

        // Get features from role
        if ($this->role) {
            $features = array_merge($features, $this->role->getAccessibleFeatures());
        }

        return array_unique($features);
    }
} 