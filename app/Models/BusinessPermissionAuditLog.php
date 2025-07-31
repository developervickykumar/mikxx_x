<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessPermissionAuditLog extends Model
{
    protected $fillable = [
        'business_id',
        'user_id',
        'action',
        'details'
    ];

    protected $casts = [
        'details' => 'array'
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForBusiness($query, $businessId)
    {
        return $query->where('business_id', $businessId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function getFormattedDetailsAttribute(): array
    {
        $details = $this->details;
        
        // Format IP address
        if (isset($details['ip_address'])) {
            $details['ip_address'] = long2ip($details['ip_address']);
        }
        
        // Format dates if present
        foreach ($details as $key => $value) {
            if (is_string($value) && strtotime($value)) {
                $details[$key] = date('Y-m-d H:i:s', strtotime($value));
            }
        }
        
        return $details;
    }

    public function getActionLabelAttribute(): string
    {
        return match ($this->action) {
            'permission_check' => 'Permission Check',
            'role_assigned' => 'Role Assigned',
            'role_removed' => 'Role Removed',
            'permission_assigned' => 'Permission Assigned',
            'permission_removed' => 'Permission Removed',
            'role_created' => 'Role Created',
            'role_updated' => 'Role Updated',
            'role_deleted' => 'Role Deleted',
            default => ucwords(str_replace('_', ' ', $this->action))
        };
    }
} 