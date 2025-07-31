<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;

    protected $fillable = [
        'sheet_id',
        'type',
        'name',
        'config',
        'data',
        'order',
        'is_active',
    ];

    protected $casts = [
        'config' => 'array',
        'data' => 'array',
        'is_active' => 'boolean',
    ];

    public function sheet()
    {
        return $this->belongsTo(Sheet::class);
    }
}
