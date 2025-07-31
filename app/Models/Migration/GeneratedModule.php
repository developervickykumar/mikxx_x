<?php

namespace App\Models\Migration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneratedModule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'status',
        'files',
        'prompt',
        'author'
    ];

    protected $casts = [
        'files' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Get the module's status badge class
     *
     * @return string
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'draft' => 'bg-gray-100 text-gray-800',
            'review' => 'bg-yellow-100 text-yellow-800',
            'published' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get the module's file count
     *
     * @return int
     */
    public function getFileCountAttribute()
    {
        return count($this->files);
    }

    /**
     * Get the module's file types
     *
     * @return array
     */
    public function getFileTypesAttribute()
    {
        return collect($this->files)
            ->pluck('type')
            ->unique()
            ->values()
            ->toArray();
    }
} 