<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HtmlTemplate extends Model
{
    protected $fillable = [
        'category_id',
        'route',
        'method',
        'controller',
        'controller_method',
        'view_file',
        'custom_logic',
        'active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
