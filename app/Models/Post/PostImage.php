<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $table = 'post_images';

    protected $fillable = [
        'post_id', 'image_url', 'caption'
    ];
}
