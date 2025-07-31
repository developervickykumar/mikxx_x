<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMedia extends Model
{
    protected $table = 'user_media';
    protected $fillable = ['user_id', 'media_type', 'file_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
