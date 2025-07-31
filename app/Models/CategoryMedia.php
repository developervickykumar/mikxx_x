<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryMedia extends Model
{
    protected $table = 'category_media'; // explicitly define the table name

    protected $fillable = [
        'category_id',
        'file_name',
        'file_path',
        'file_type',
        'mime_type',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
