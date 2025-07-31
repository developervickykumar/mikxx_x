<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormFieldType extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'component_name',
        'description',
        'default_config',
        'validation_rules',
        'supported_attributes',
        'is_active'
    ];
 
    protected $casts = [
        'default_config' => 'array',
        'validation_rules' => 'array',
        'supported_attributes' => 'array',
        'is_active' => 'boolean'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(FormFieldCategory::class, 'category_id');
    }

    public function fields(): HasMany
    {
        return $this->hasMany(FormField::class, 'field_type_id');
    }
} 