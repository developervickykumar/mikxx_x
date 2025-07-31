<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSocialite extends Model
{
    protected $table = "user_socialites";
    protected $fillable=[
        'name',
        'email',
        'picture',
        'password',
    ];
}
