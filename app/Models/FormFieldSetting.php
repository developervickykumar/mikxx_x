<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormFieldSetting extends Model
{
    protected $fillable = [
        'form_id',
        'category_id',
        'input_type',
        'label',
        'placeholder',
        'tooltip',
        'default_value',
        'is_required',
        'validation_rules',
        'is_visible',
        'is_readonly',
        'is_disabled',
        'column_span',
        'custom_css_class',
        'position',
        'group_name',
        'help_text',
        'icon',
        'has_child',
        'child_display_type',
        'condition_on',
        'condition_value',
        'extra_settings'
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_visible' => 'boolean',
        'is_readonly' => 'boolean',
        'is_disabled' => 'boolean',
        'has_child' => 'boolean',
        'extra_settings' => 'array',
    ];
}
