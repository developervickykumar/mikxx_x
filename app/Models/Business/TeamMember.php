<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'user_id',
        'department_id',
        'role',
        'position',
        'employee_id',
        'permissions',
        'schedule',
        'contact_info',
        'is_active',
        'joined_at',
        'last_active_at'
    ];

    protected $casts = [
        'permissions' => 'json',
        'schedule' => 'json',
        'contact_info' => 'json',
        'is_active' => 'boolean',
        'joined_at' => 'datetime',
        'last_active_at' => 'datetime'
    ];

    /**
     * Get the business that owns the team member.
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Get the user associated with the team member.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the department that the team member belongs to.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the team members managed by this team member.
     */
    public function subordinates(): HasMany
    {
        return $this->hasMany(TeamMember::class, 'manager_id');
    }

    /**
     * Get the team member's manager.
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'manager_id');
    }

    /**
     * Get the team member's attendance records.
     */
    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    /**
     * Get the team member's tasks.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Check if the team member has a specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions ?? []);
    }

    /**
     * Check if the team member has any of the given permissions.
     */
    public function hasAnyPermission(array $permissions): bool
    {
        return !empty(array_intersect($permissions, $this->permissions ?? []));
    }

    /**
     * Check if the team member has all of the given permissions.
     */
    public function hasAllPermissions(array $permissions): bool
    {
        return empty(array_diff($permissions, $this->permissions ?? []));
    }

    /**
     * Get the team member's schedule for a specific day.
     */
    public function getScheduleForDay(string $day): ?array
    {
        return $this->schedule[$day] ?? null;
    }

    /**
     * Update the team member's schedule.
     */
    public function updateSchedule(string $day, array $schedule): void
    {
        $this->schedule = array_merge($this->schedule ?? [], [$day => $schedule]);
        $this->save();
    }

    /**
     * Update the team member's last active timestamp.
     */
    public function updateLastActive(): void
    {
        $this->last_active_at = now();
        $this->save();
    }

    /**
     * Scope a query to only include active team members.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include team members with a specific role.
     */
    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Get the team member's full name.
     */
    public function getFullNameAttribute(): string
    {
        return $this->user->name;
    }

    /**
     * Get the team member's email.
     */
    public function getEmailAttribute(): string
    {
        return $this->user->email;
    }
} 