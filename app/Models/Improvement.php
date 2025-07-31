<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Improvement extends Model
{
    protected $fillable = [
        'category_id', 'type', 'description', 'priority', 'status', 'developer'
    ];
}
