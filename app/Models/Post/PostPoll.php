<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class PostPoll extends Model
{
    protected $table = 'post_polls';

    protected $fillable = [
        'post_id', 'question', 'expires_at'
    ];
}
