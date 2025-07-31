<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PostComment extends Model
{
    protected $fillable = ['post_id', 'user_id', 'comment', 'parent_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function replies()
    {
        return $this->hasMany(PostComment::class, 'parent_id')->with('user')->orderBy('created_at');
    }

    public function parent()
    {
        return $this->belongsTo(PostComment::class, 'parent_id');
    }
}