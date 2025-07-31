<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IconKeyword extends Model
{
    protected $fillable = ['keywords', 'icon_class'];


    
    public function getKeywordsArray()
    {
        return explode(',', $this->keywords);
    }

}
