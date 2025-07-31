<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessAnalytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'page_views',
        'unique_visitors',
        'bounce_rate',
        'average_session_duration',
        'conversion_rate',
        'revenue',
        'top_referrers',
        'popular_pages',
        'user_demographics',
        'date',
    ];

    protected $casts = [
        'top_referrers' => 'array',
        'popular_pages' => 'array',
        'user_demographics' => 'array',
        'date' => 'date',
        'bounce_rate' => 'float',
        'conversion_rate' => 'float',
        'revenue' => 'decimal:2',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function scopeForPeriod($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    public function scopeForBusiness($query, $businessId)
    {
        return $query->where('business_id', $businessId);
    }
} 