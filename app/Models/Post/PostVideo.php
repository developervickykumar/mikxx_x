<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class PostVideo extends Model
{
    protected $table = 'post_videos';

    protected $fillable = [
        'post_id', 'video_url', 'thumbnail_url', 'duration'
    ];
}
