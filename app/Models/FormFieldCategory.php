<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormFieldCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'display_order'
    ];

    public function fieldTypes(): HasMany
    {
        return $this->hasMany(FormFieldType::class, 'category_id');
    }
} 