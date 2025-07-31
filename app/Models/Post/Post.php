<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post\PostLike;
use App\Models\Post\PostComment;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'user_id', 'post_type', 'content', 'visibility'
    ];
    
    
    public function user() {
     return $this->belongsTo(User::class);
    }
    
    public function video() {
        return $this->hasOne(PostVideo::class);
    }
    
    public function image() {
        return $this->hasOne(PostImage::class);
    }
    
    public function poll() {
        return $this->hasOne(PostPoll::class);
    }
    
    public function tags() {
        return $this->hasMany(PostTag::class);
    }
    

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function isLikedBy($user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    
    // Post.php
public function comments()
{
    return $this->hasMany(PostComment::class)
        ->whereNull('parent_id')
        ->withCount('replies')
        ->with(['replies.user', 'user']);
}


    
}