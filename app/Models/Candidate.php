<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',  
        'role_id', 
        'dob',
        'fathers_name',
        'age',
        'profile_pic',
        'cover_photo',
        'city',
        'state',
        'country',
        'social_links',
        'portfolio_url',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    public function setSocialLinksAttribute($value)
    {
        $this->attributes['social_links'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getSocialLinksAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }
            
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function candidateProfile()
    {
        return $this->hasOne(CandidateProfile::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }
}

    