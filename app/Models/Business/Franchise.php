<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Franchise extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'name',
        'description',
        'location',
        'contact_email',
        'contact_phone',
        'status',
        'opening_date',
        'manager_id',
        'territory',
        'investment_required',
        'royalty_fee',
        'contract_duration',
    ];

    protected $casts = [
        'opening_date' => 'date',
        'investment_required' => 'decimal:2',
        'royalty_fee' => 'decimal:2',
        'contract_duration' => 'integer',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'manager_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    public function analytics(): HasMany
    {
        return $this->hasMany(BusinessAnalytics::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByTerritory($query, $territory)
    {
        return $query->where('territory', $territory);
    }
} 