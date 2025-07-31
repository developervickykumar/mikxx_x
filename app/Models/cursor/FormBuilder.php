<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormBuilder extends Model
{
    protected $fillable = [
        'title', 'tab_id', 'sub_tab_id', 'for_type', 'data_mode',
        'cta_action', 'cta_success_message', 'cta_redirect_url', 'publish_status'
    ];

    public function fields()
    {
        return $this->hasMany(FormBuilderField::class);
    }
}
 