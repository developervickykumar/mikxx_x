<?php

namespace App\Models\Business;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'cover_image',
        'description',
        'address',
        'phone',
        'email',
        'website',
        'gst_number',
        'working_hours',
        'social_media',
        'is_verified',
        'is_active',
        'contact_methods',
        'timezone',
        'latitude',
        'longitude',
        'follower_count',
        'verification_details',
        'visitor_count',
        'engagement_metrics',
        'conversion_metrics',
        'seo_settings',
        'custom_fields',
        'branding_settings',
        'translations',
        'default_currency',
        'supported_currencies',
        'compliance_settings',
        'tax_settings',
        'post_types',
        'post_settings',
        'chat_enabled',
        'chat_settings',
        'shop_enabled',
        'shop_settings',
        'service_categories',
        'service_settings',
        'appointments_enabled',
        'appointment_settings',
        'contact_settings',
        'team_settings',
        'gallery_categories',
        'gallery_settings',
        'review_settings',
        'quotations_enabled',
        'quotation_settings',
        'helpdesk_enabled',
        'helpdesk_settings',
        'jobs_enabled',
        'jobs_settings',
        'attendance_enabled',
        'attendance_settings',
        'public_analytics_settings'
    ];

    protected $casts = [
        'working_hours' => 'json',
        'social_media' => 'json',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'contact_methods' => 'json',
        'verification_details' => 'json',
        'engagement_metrics' => 'json',
        'conversion_metrics' => 'json',
        'seo_settings' => 'json',
        'custom_fields' => 'json',
        'branding_settings' => 'json',
        'translations' => 'json',
        'supported_currencies' => 'json',
        'compliance_settings' => 'json',
        'tax_settings' => 'json',
        'post_types' => 'json',
        'post_settings' => 'json',
        'chat_enabled' => 'boolean',
        'chat_settings' => 'json',
        'shop_enabled' => 'boolean',
        'shop_settings' => 'json',
        'service_categories' => 'json',
        'service_settings' => 'json',
        'appointments_enabled' => 'boolean',
        'appointment_settings' => 'json',
        'contact_settings' => 'json',
        'team_settings' => 'json',
        'gallery_categories' => 'json',
        'gallery_settings' => 'json',
        'review_settings' => 'json',
        'quotations_enabled' => 'boolean',
        'quotation_settings' => 'json',
        'helpdesk_enabled' => 'boolean',
        'helpdesk_settings' => 'json',
        'jobs_enabled' => 'boolean',
        'jobs_settings' => 'json',
        'attendance_enabled' => 'boolean',
        'attendance_settings' => 'json',
        'public_analytics_settings' => 'json'
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'business_employees')
            ->withPivot('role', 'department', 'is_active')
            ->withTimestamps();
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'business_followers')
            ->withTimestamps();
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the stories for the business.
     */
    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function teamMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }

    public function helpdeskTickets(): HasMany
    {
        return $this->hasMany(HelpdeskTicket::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function chatRooms(): HasMany
    {
        return $this->hasMany(ChatRoom::class);
    }

    public function analytics(): HasOne
    {
        return $this->hasOne(BusinessAnalytics::class);
    }

    /**
     * Get the logo URL.
     */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? Storage::url($this->logo) : null;
    }

    /**
     * Get the cover image URL.
     */
    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->cover_image ? Storage::url($this->cover_image) : null;
    }

    /**
     * Get the active stories.
     */
    public function activeStories()
    {
        return $this->stories()->active();
    }

    /**
     * Get the pinned posts.
     */
    public function pinnedPosts()
    {
        return $this->posts()->where('is_pinned', true);
    }

    /**
     * Get the active services.
     */
    public function activeServices()
    {
        return $this->services()->where('is_active', true);
    }

    /**
     * Get the active products.
     */
    public function activeProducts()
    {
        return $this->products()->where('is_active', true);
    }

    /**
     * Get the active team members.
     */
    public function activeTeamMembers()
    {
        return $this->teamMembers()->where('is_active', true);
    }

    /**
     * Get the active jobs.
     */
    public function activeJobs()
    {
        return $this->jobs()->where('is_active', true);
    }

    /**
     * Get the active helpdesk tickets.
     */
    public function activeHelpdeskTickets()
    {
        return $this->helpdeskTickets()->where('status', '!=', 'closed');
    }

    /**
     * Get the active chat rooms.
     */
    public function activeChatRooms()
    {
        return $this->chatRooms()->where('is_active', true);
    }

    /**
     * Get the active quotations.
     */
    public function activeQuotations()
    {
        return $this->quotations()->where('status', '!=', 'closed');
    }

    /**
     * Get the active attendance records.
     */
    public function activeAttendanceRecords()
    {
        return $this->attendanceRecords()->where('status', '!=', 'closed');
    }

    /**
     * Get the active gallery items.
     */
    public function activeGallery()
    {
        return $this->gallery()->where('is_active', true);
    }
} 