<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BusinessRole extends Model
{
    protected $fillable = [
        'business_id',
        'name',
        'slug',
        'description',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean'
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(BusinessPermission::class, 'business_role_permission');
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('slug', $permission)->exists();
    }

    public function getAccessiblePages(): array
    {
        return $this->permissions()
            ->whereNotNull('page')
            ->pluck('page')
            ->unique()
            ->toArray();
    }

    public function getAccessibleModules(): array
    {
        return $this->permissions()
            ->whereNotNull('module')
            ->pluck('module')
            ->unique()
            ->toArray();
    }
} 