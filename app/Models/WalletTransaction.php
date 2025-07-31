<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $fillable = ['user_id', 'type', 'purpose', 'amount', 'related_user_id', 'reference_id', 'note'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function relatedUser() {
        return $this->belongsTo(User::class, 'related_user_id');
    }
}

