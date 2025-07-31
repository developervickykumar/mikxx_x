<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'schema',
        'settings',
        'user_id',
    ];

    protected $casts = [
        'schema' => 'array',
        'settings' => 'array',
    ];
}
