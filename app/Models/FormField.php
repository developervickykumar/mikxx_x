<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormField extends Model
{
    protected $fillable = [
        'form_id',
        'field_type_id',
        'name',
        'label',
        'description',
        'placeholder',
        'options',
        'validation',
        'attributes',
        'config',
        'required',
        'default_value',
        'help_text',
        'order',
        'width',
        'wrapper_class',
        'input_class',
        'section',
        'section_order',
        'is_visible',
        'is_enabled',
        'parent_field_id'
    ];

    protected $casts = [
        'options' => 'array',
        'validation' => 'array',
        'attributes' => 'array',
        'config' => 'array',
        'required' => 'boolean',
        'is_visible' => 'boolean',
        'is_enabled' => 'boolean'
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function fieldType(): BelongsTo
    {
        return $this->belongsTo(FormFieldType::class, 'field_type_id');
    }

    public function conditions(): HasMany
    {
        return $this->hasMany(FormCondition::class, 'form_field_id');
    }

    public function targetConditions(): HasMany
    {
        return $this->hasMany(FormCondition::class, 'target_field', 'name');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(FormField::class, 'parent_field_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(FormField::class, 'parent_field_id');
    }

    public function getConditionsAttribute()
    {
        return $this->conditions()->get();
    }

    public function getComponentNameAttribute()
    {
        return $this->fieldType->component_name;
    }

    public function getValidationRulesAttribute()
    {
        $rules = [];
        
        if ($this->required) {
            $rules[] = 'required';
        } else {
            $rules[] = 'nullable';
        }
        
        if (!empty($this->validation)) {
            $rules = array_merge($rules, $this->validation);
        }
        
        return $rules;
    }


    // FormFieldController.php

    public function saveFieldSettings(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:form_fields,id',
            'settings' => 'required|array',
        ]);

        $field = FormField::findOrFail($request->field_id);

        $existingConfig = $field->config ?? [];

        // Merge new settings into existing config
        $updatedConfig = array_merge($existingConfig, $request->settings);

        $field->update([
            'config' => $updatedConfig
        ]);

        return response()->json(['success' => true, 'config' => $updatedConfig]);
    }


} 