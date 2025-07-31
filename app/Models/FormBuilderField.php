<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormBuilderField extends Model
{
    protected $fillable = [
        'form_builder_id',
        'field_id',
        'field_order',
        'column_width',
        'settings'
    ];

    protected $casts = [
        'settings' => 'array',
    ];
}
