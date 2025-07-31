<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialInteraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'content',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    public function interactable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes for different types of interactions
    public function scopeLikes($query)
    {
        return $query->where('type', 'like');
    }

    public function scopeComments($query)
    {
        return $query->where('type', 'comment');
    }

    public function scopeShares($query)
    {
        return $query->where('type', 'share');
    }

    // Helper methods for common interactions
    public static function like($interactable, $user)
    {
        return static::create([
            'interactable_type' => get_class($interactable),
            'interactable_id' => $interactable->id,
            'user_id' => $user->id,
            'type' => 'like'
        ]);
    }

    public static function comment($interactable, $user, $content)
    {
        return static::create([
            'interactable_type' => get_class($interactable),
            'interactable_id' => $interactable->id,
            'user_id' => $user->id,
            'type' => 'comment',
            'content' => $content
        ]);
    }

    public static function share($interactable, $user, $platform = null)
    {
        return static::create([
            'interactable_type' => get_class($interactable),
            'interactable_id' => $interactable->id,
            'user_id' => $user->id,
            'type' => 'share',
            'metadata' => ['platform' => $platform]
        ]);
    }
} 