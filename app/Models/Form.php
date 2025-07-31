<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'fields',
        'template_id',
        'user_id',
        'is_active'
    ];

    protected $casts = [
        'fields' => 'array',
        'is_active' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(TableTemplate::class, 'template_id');
    }

    public function getFieldsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setFieldsAttribute($value)
    {
        $this->attributes['fields'] = json_encode($value);
    }

    public function fields(): HasMany
    {
        return $this->hasMany(FormField::class)->orderBy('order');
    }

    public function getFieldsBySection()
    {
        $fields = $this->fields()->get();
        $sections = $fields->pluck('section')->unique()->filter()->values();
        
        $result = [];
        
        // Add fields without section first
        $result['default'] = $fields->filter(function($field) {
            return empty($field->section);
        })->sortBy('order')->values();
        
        // Group fields by section
        foreach ($sections as $section) {
            $result[$section] = $fields->filter(function($field) use ($section) {
                return $field->section === $section;
            })->sortBy('section_order')->values();
        }
        
        return $result;
    }

    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->first();
    }
} 