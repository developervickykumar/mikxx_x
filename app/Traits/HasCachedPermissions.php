<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

trait HasCachedPermissions
{
    protected function getCacheKey(): string
    {
        return "user_permissions:{$this->id}";
    }

    protected function getCacheTags(): array
    {
        return ["user:{$this->id}", "business:{$this->business_id}"];
    }

    public function getCachedPermissions(): array
    {
        return Cache::tags($this->getCacheTags())->remember(
            $this->getCacheKey(),
            now()->addHours(24),
            fn () => $this->getAllPermissions()->toArray()
        );
    }

    public function clearPermissionCache(): void
    {
        Cache::tags($this->getCacheTags())->forget($this->getCacheKey());
    }

    public function hasPermission(string $permission, array $context = []): bool
    {
        $permissions = $this->getCachedPermissions();
        
        foreach ($permissions as $perm) {
            if ($perm['slug'] === $permission) {
                if (empty($perm['conditions'])) {
                    return true;
                }
                
                return $this->checkPermissionConditions($perm, $context);
            }
        }
        
        return false;
    }

    public function hasAnyPermission(array $permissions, array $context = []): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission, $context)) {
                return true;
            }
        }
        
        return false;
    }

    public function hasAllPermissions(array $permissions, array $context = []): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission, $context)) {
                return false;
            }
        }
        
        return true;
    }

    protected function checkPermissionConditions(array $permission, array $context): bool
    {
        if (empty($permission['conditions'])) {
            return true;
        }

        foreach ($permission['conditions'] as $condition) {
            if (!$this->evaluateCondition($condition, $context)) {
                return false;
            }
        }

        return true;
    }

    protected function evaluateCondition(array $condition, array $context): bool
    {
        $operator = $condition['operator'] ?? '=';
        $value = $condition['value'] ?? null;
        $contextValue = $context[$condition['field']] ?? null;

        return match ($operator) {
            '=' => $contextValue === $value,
            '!=' => $contextValue !== $value,
            '>' => $contextValue > $value,
            '>=' => $contextValue >= $value,
            '<' => $contextValue < $value,
            '<=' => $contextValue <= $value,
            'in' => in_array($contextValue, (array)$value),
            'not_in' => !in_array($contextValue, (array)$value),
            'contains' => str_contains($contextValue, $value),
            'starts_with' => str_starts_with($contextValue, $value),
            'ends_with' => str_ends_with($contextValue, $value),
            default => false,
        };
    }

    public function getAccessiblePages(): array
    {
        $permissions = $this->getCachedPermissions();
        $pages = [];

        foreach ($permissions as $permission) {
            if (!empty($permission['page'])) {
                $pages[] = $permission['page'];
            }
        }

        return array_unique($pages);
    }

    public function getAccessibleModules(): array
    {
        $permissions = $this->getCachedPermissions();
        $modules = [];

        foreach ($permissions as $permission) {
            if (!empty($permission['module'])) {
                $modules[] = $permission['module'];
            }
        }

        return array_unique($modules);
    }
} 