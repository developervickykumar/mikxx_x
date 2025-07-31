<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasFeatureAccess;
use App\Traits\HasCachedPermissions;
use App\Traits\HasPermissionAuditLogs;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use App\Models\UserProfileField;
// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasFeatureAccess, HasCachedPermissions, HasPermissionAuditLogs;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
protected $fillable = [
    'first_name',
    'last_name',
    'username',
    'email',
    'password',
    'dob',
    'gender',
    'contact',
    'state',
    'country',
    'country_code',
    'country_name',
    'currency',
    'language',
    'timezone',
    'phone_number',
    'phone_verified',
    'is_verified',
    'is_business',
    'settings',
    'last_login_at',
    'last_login_ip',
    'last_activity_at',
    'role_id',
    'status',
    'user_type',
    'business_id',
    'is_admin',
    'profile_picture',
     'additional_info',
     'google_id',
];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'settings' => 'array',
        'phone_verified' => 'boolean',
        'is_verified' => 'boolean',
        'is_business' => 'boolean',
        'is_admin' => 'boolean',
        'status' => 'boolean',
        'last_login_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'dob' => 'date',
        'additional_info' => 'array', 
    ];
    public static function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'user_type' => 'required|in:admin,candidate,team,client',
            'status' => 'boolean'
        ];
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    // public function isAdmin()
    // {
    //     return $this->role === 'admin'; // or $this->is_admin if it's a boolean
    // }

    public function isBusiness()
    {
        return $this->role === 'business'; // optional
    }


    public function isCandidate(): bool
    {
        return $this->user_type === 'candidate';
    }
    public function isTeam(): bool
    {
        return $this->user_type === 'team';
    }

    public function isClient(): bool
    {
        return $this->user_type === 'client';
    }

    public function isActive(): bool
    {
        return $this->status === true;
    }

    /**
     * Check if user has access to business module
     *
     * @return bool
     */
    public function hasBusinessAccess(): bool
    {
        // Admin always has access
        if ($this->isAdmin()) {
            return true;
        }
        
        // Check if user is a business user
        return $this->is_business === true;
    }
    
    /**
     * Get the businesses owned by the user
     */
    public function businesses()
    {
        return $this->hasMany(\App\Models\Business\Business::class, 'owner_id');
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(BusinessRole::class, 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission(string $permission, array $context = []): bool
    {
        $hasPermission = parent::hasPermission($permission, $context);
        $this->logPermissionCheck($permission, $hasPermission, $context);
        return $hasPermission;
    }

    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    public function hasAllPermissions(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }
        return true;
    }

    public function getAllPermissions(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->role?->permissions ?? collect();
    }

    public function clearPermissionCache(): void
    {
        Cache::forget("user.{$this->id}.permissions");
        Cache::forget("user.{$this->id}.all_permissions");
    }

    /**
     * Check if the user has a specific permission for a business.
     */
    public function hasBusinessPermission(Business $business, string $permission): bool
    {
        // Get the user's role for this business
        $role = $this->businessRoles()
            ->where('business_id', $business->id)
            ->first();

        if (!$role) {
            return false;
        }

        // Check if the role has the permission
        return $role->permissions()
            ->where('slug', $permission)
            ->exists();
    }

    /**
     * Check if the user has any of the given permissions for a business.
     */
    public function hasAnyBusinessPermission(Business $business, array $permissions): bool
    {
        // Get the user's role for this business
        $role = $this->businessRoles()
            ->where('business_id', $business->id)
            ->first();

        if (!$role) {
            return false;
        }

        // Check if the role has any of the permissions
        return $role->permissions()
            ->whereIn('slug', $permissions)
            ->exists();
    }

    /**
     * Check if the user has all of the given permissions for a business.
     */
    public function hasAllBusinessPermissions(Business $business, array $permissions): bool
    {
        // Get the user's role for this business
        $role = $this->businessRoles()
            ->where('business_id', $business->id)
            ->first();

        if (!$role) {
            return false;
        }

        // Check if the role has all of the permissions
        $rolePermissions = $role->permissions()
            ->whereIn('slug', $permissions)
            ->pluck('slug')
            ->toArray();

        return count(array_intersect($permissions, $rolePermissions)) === count($permissions);
    }

    /**
     * Get all permissions for a business.
     */
    public function getBusinessPermissions(Business $business): Collection
    {
        // Get the user's role for this business
        $role = $this->businessRoles()
            ->where('business_id', $business->id)
            ->first();

        if (!$role) {
            return collect();
        }

        return $role->permissions;
    }

    /**
     * Get all accessible pages for a business.
     */
    public function getAccessibleBusinessPages(Business $business): Collection
    {
        // Get the user's role for this business
        $role = $this->businessRoles()
            ->where('business_id', $business->id)
            ->first();

        if (!$role) {
            return collect();
        }

        return $role->permissions()
            ->whereNotNull('page')
            ->pluck('page')
            ->unique();
    }

    /**
     * Get all accessible modules for a business.
     */
    public function getAccessibleBusinessModules(Business $business): Collection
    {
        // Get the user's role for this business
        $role = $this->businessRoles()
            ->where('business_id', $business->id)
            ->first();

        if (!$role) {
            return collect();
        }

        return $role->permissions()
            ->whereNotNull('module')
            ->pluck('module')
            ->unique();
    }

    public function assignRole(BusinessRole $role): void
    {
        $this->role()->associate($role);
        $this->save();
        $this->clearPermissionCache();
        $this->logRoleAssignment($role->id, $this->id);
    }

    public function removeRole(): void
    {
        if ($this->role) {
            $this->logRoleRemoval($this->role->id, $this->id);
            $this->role()->dissociate();
            $this->save();
            $this->clearPermissionCache();
        }
    }

    protected static function booted(): void
    {
        static::updated(function ($user) {
            if ($user->isDirty('role_id')) {
                $user->clearPermissionCache();
            }
        });
    }

    public function profileFields()
    {
        return $this->hasMany(UserProfileField::class);
    }
    
    // app/Models/User.php

public function profile()
{
    return $this->hasOne(UserProfileField::class);
}

public function settings()
{
    return $this->hasMany(UserSetting::class);
}

public function interests()
{
    return $this->hasMany(UserInterest::class);
}

public function media()
{
    return $this->hasMany(UserMedia::class);
}

public function likedPosts()
{
    return $this->belongsToMany(Post::class, 'post_likes');
}

 public function comments()
{
    return $this->hasMany(\App\Models\Post\PostComment::class);
}



}