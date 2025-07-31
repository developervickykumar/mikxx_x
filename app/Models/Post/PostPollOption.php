<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class PostPollOption extends Model
{
    protected $table = 'post_poll_options';

    protected $fillable = [
        'poll_id', 'option_text', 'vote_count'
    ];
}
