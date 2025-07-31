<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormCondition extends Model
{
    protected $fillable = [
        'form_field_id',
        'source_field',
        'condition_type',
        'target_field',
        'operator',
        'value',
        'additional_settings',
        'is_active'
    ];

    protected $casts = [
        'additional_settings' => 'array',
        'is_active' => 'boolean'
    ];

    public function formField(): BelongsTo
    {
        return $this->belongsTo(FormField::class, 'form_field_id');
    }

    public function sourceField(): BelongsTo
    {
        return $this->belongsTo(FormField::class, 'source_field');
    }

    public function targetField(): BelongsTo
    {
        return $this->belongsTo(FormField::class, 'target_field');
    }

    public function evaluate($inputValue)
    {
        switch ($this->operator) {
            case 'equals':
                return $inputValue == $this->value;
            case 'not_equals':
                return $inputValue != $this->value;
            case 'contains':
                return str_contains($inputValue, $this->value);
            case 'greater_than':
                return $inputValue > $this->value;
            case 'less_than':
                return $inputValue < $this->value;
            case 'in':
                return in_array($inputValue, explode(',', $this->value));
            case 'not_in':
                return !in_array($inputValue, explode(',', $this->value));
            default:
                return false;
        }
    }
}
