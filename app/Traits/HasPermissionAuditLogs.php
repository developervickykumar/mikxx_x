<?php

namespace App\Traits;

use App\Models\BusinessPermissionAuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait HasPermissionAuditLogs
{
    public function logPermissionAction(string $action, array $details = []): void
    {
        BusinessPermissionAuditLog::create([
            'business_id' => $this->business_id,
            'user_id' => Auth::id(),
            'action' => $action,
            'details' => array_merge($details, [
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
                'url' => Request::fullUrl(),
                'method' => Request::method(),
            ])
        ]);
    }

    public function logPermissionCheck(string $permission, bool $granted, array $context = []): void
    {
        $this->logPermissionAction('permission_check', [
            'permission' => $permission,
            'granted' => $granted,
            'context' => $context
        ]);
    }

    public function logRoleAssignment(int $roleId, int $userId): void
    {
        $this->logPermissionAction('role_assigned', [
            'role_id' => $roleId,
            'user_id' => $userId
        ]);
    }

    public function logRoleRemoval(int $roleId, int $userId): void
    {
        $this->logPermissionAction('role_removed', [
            'role_id' => $roleId,
            'user_id' => $userId
        ]);
    }

    public function logPermissionAssignment(int $permissionId, int $roleId): void
    {
        $this->logPermissionAction('permission_assigned', [
            'permission_id' => $permissionId,
            'role_id' => $roleId
        ]);
    }

    public function logPermissionRemoval(int $permissionId, int $roleId): void
    {
        $this->logPermissionAction('permission_removed', [
            'permission_id' => $permissionId,
            'role_id' => $roleId
        ]);
    }

    public function logRoleCreation(array $roleData): void
    {
        $this->logPermissionAction('role_created', [
            'role_data' => $roleData
        ]);
    }

    public function logRoleUpdate(int $roleId, array $oldData, array $newData): void
    {
        $this->logPermissionAction('role_updated', [
            'role_id' => $roleId,
            'old_data' => $oldData,
            'new_data' => $newData
        ]);
    }

    public function logRoleDeletion(int $roleId, array $roleData): void
    {
        $this->logPermissionAction('role_deleted', [
            'role_id' => $roleId,
            'role_data' => $roleData
        ]);
    }

    public function getAuditLogs(array $filters = [], int $limit = 50): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = BusinessPermissionAuditLog::where('business_id', $this->business_id);

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        if (!empty($filters['start_date'])) {
            $query->where('created_at', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->where('created_at', '<=', $filters['end_date']);
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate($limit);
    }
} 