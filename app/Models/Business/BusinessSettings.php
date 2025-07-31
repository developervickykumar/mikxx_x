<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'theme',
        'notification_preferences',
        'privacy_settings',
        'social_media_links',
        'business_hours',
        'contact_info',
        'payment_settings',
        'seo_settings',
        'analytics_settings',
        'custom_domain',
        'language',
        'timezone',
    ];

    protected $casts = [
        'notification_preferences' => 'array',
        'privacy_settings' => 'array',
        'social_media_links' => 'array',
        'business_hours' => 'array',
        'contact_info' => 'array',
        'payment_settings' => 'array',
        'seo_settings' => 'array',
        'analytics_settings' => 'array',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function getNotificationSettingAttribute($key)
    {
        $preferences = $this->notification_preferences;
        return $preferences[$key] ?? false;
    }

    public function getPrivacySettingAttribute($key)
    {
        $settings = $this->privacy_settings;
        return $settings[$key] ?? false;
    }

    public function getSocialMediaLinkAttribute($platform)
    {
        $links = $this->social_media_links;
        return $links[$platform] ?? null;
    }

    public function getBusinessHoursForDayAttribute($day)
    {
        $hours = $this->business_hours;
        return $hours[$day] ?? null;
    }
} 