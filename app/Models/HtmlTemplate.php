<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HtmlTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'html_code',
        'blade_code',
        'migration_code',
        'improvement_notes',
        'tags',
        'is_processed',
        'is_duplicate',
        'usable_in_user',
        'usable_in_business',
        'usable_in_mikxx',
        'usable_in_modules',
        'usable_in_admin',
        'created_by'
    ];

    protected $casts = [
        'is_processed' => 'boolean',
        'is_duplicate' => 'boolean',
        'usable_in_user' => 'boolean',
        'usable_in_business' => 'boolean',
        'usable_in_mikxx' => 'boolean',
        'usable_in_modules' => 'boolean',
        'usable_in_admin' => 'boolean',
    ];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Optional: Creator (if you're tracking who created the template)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
