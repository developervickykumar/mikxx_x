<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftTransaction extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'post_id',
        'gift_category_id',
        'price',
        'message',
    ];

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function gift() {
        return $this->belongsTo(Category::class, 'gift_category_id');
    }
}
