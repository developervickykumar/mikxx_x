<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

class UserProfileField extends Model
{
    protected $fillable = ['user_id', 'field_id', 'value'];

    public function field()
    {
        return $this->belongsTo(Category::class, 'field_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    
}

