<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomRoute extends Model
{
    protected $fillable = [
        'path', 'method', 'controller', 'controller_method', 'view_file',
        'custom_logic', 'middleware', 'active'
    ];

    protected $casts = [
        'middleware' => 'array'
    ];
}
