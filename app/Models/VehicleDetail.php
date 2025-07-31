<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleDetail extends Model
{
    protected $fillable = ['user_id','level1','level2','level3','data'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
