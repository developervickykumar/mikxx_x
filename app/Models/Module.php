<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $table = 'modules';

    protected $fillable = [
        'category',
        'subcategory',
        'name',
        'tag_line',
        'image',
        'logo',
        'short_desc',
        'long_desc',
        'feature',
        'feature_desc',
        'status',
    ];

    protected $dates = ['created_at', 'updated_at'];

}

