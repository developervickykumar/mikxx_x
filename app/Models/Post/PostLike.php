<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    protected $fillable = ['post_id', 'user_id'];

    // Relationship to Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
