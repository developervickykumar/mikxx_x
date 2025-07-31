<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class ClassifiedPost extends Model
{
    use HasFactory;

    // Status Constants
    const STATUS_DRAFT = 'draft';
    const STATUS_ACTIVE = 'active';
    const STATUS_SOLD = 'sold';
    const STATUS_EXPIRED = 'expired';
    const STATUS_REPORTED = 'reported';
    const STATUS_REMOVED = 'removed';

    // Metric Types
    const METRIC_VIEW = 'classified_view';
    const METRIC_INQUIRY = 'classified_inquiry';
    const METRIC_FAVORITE = 'classified_favorite';
    const METRIC_SHARE = 'classified_share';
    const METRIC_STATUS_CHANGE = 'classified_status_change';

    protected $fillable = [
        'title',
        'description',
        'price',
        'category',
        'condition',
        'location',
        'images',
        'contact_info',
        'status',
        'expires_at',
        'user_id',
        'last_viewed_at',
        'view_count',
        'inquiry_count',
        'metadata'
    ];

    protected $casts = [
        'images' => 'array',
        'contact_info' => 'array',
        'price' => 'decimal:2',
        'expires_at' => 'datetime',
        'last_viewed_at' => 'datetime',
        'metadata' => 'array'
    ];

    protected $appends = [
        'is_expired',
        'time_left',
        'formatted_price'
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ClassifiedCategory::class, 'category', 'slug');
    }

    public function assistant(): HasOne
    {
        return $this->hasOne(Assistant::class, 'user_id', 'user_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('location', 'like', "%{$location}%");
    }

    // Accessors
    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getTimeLeftAttribute(): ?string
    {
        if (!$this->expires_at) {
            return null;
        }

        return $this->expires_at->diffForHumans();
    }

    public function getFormattedPriceAttribute(): string
    {
        return $this->price ? '$' . number_format($this->price, 2) : 'Free';
    }
} 