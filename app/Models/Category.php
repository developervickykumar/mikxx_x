<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;


class Category extends Model
{
    use HasFactory;
protected $fillable = [
    'name',
    'position',
    'parent_id',
    'level',
    'status',
    'image',
    'icon',
    'is_protected',
    'label',
    'label_json',
    'meta',
    'display',
    'messages',
    'notifications',
    'group_view',
    'price_list',
    'code',
    'seo',
    'advanced',
    'subscription_plans',
    'is_excluded',
    'is_published'
];

protected $casts = [
    'label_json' => 'array',
    'meta' => 'array',
    'display' => 'array',
    'messages' => 'array',
    'notifications' => 'array',
    'group_view' => 'array',
    'seo' => 'array',
    'advanced' => 'array',
    'subscription_plans' => 'array',
    'price_list' => 'array',
    'is_protected' => 'array',
    'is_excluded' => 'boolean',
    'is_published' => 'boolean'
];

      /*protected $fillable = [
            'name',
            'position',
            'parent_id',
            'level',
            'status',
            'image',
            'icon',
            'is_protected',
            'label',
            'label_json',
            'meta',
            'display',
            'messages',
            'notifications',
            'group_view',
            'price_list',
            'code',
            'seo',
            'advanced',
            'subscription_plans',
        ];
    
        protected $casts = [
            'label_json' => 'array',
            'meta' => 'array',
            'display' => 'array',
            'messages' => 'array',
            'notifications' => 'array',
            'group_view' => 'array',
            'seo' => 'array',
            'advanced' => 'array',
            'subscription_plans' => 'array',
            'is_excluded' => 'boolean',
            'is_published' => 'boolean'
        ];*/

    public static function getCategoryTreeByName($name)
    {
        return self::where('name', $name)
          
            ->first();
    }

    public static function getCategoryTreeByParentId($id)
    {
        return self::where('parent_id', $id)->orderBy('position')->get();
    }
    


    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('position');
    }
    
    public function getFullCategoryName()
    {
        $categoryName = $this->name;
        if ($this->parent) {
            $categoryName = $this->parent->getFullCategoryName() . ' > ' . $categoryName;
        }
        return $categoryName;
    }



    public function childrenRecursive()
    {
        return $this->hasMany(Category::class, 'parent_id')
                    ->orderBy('position')
                    ->with('childrenRecursive');
    }
    
    public function mediaFiles()
    {
        return $this->hasMany(CategoryMedia::class);
    }

    public function getAllDescendantIds()
{
    $ids = [];

    foreach ($this->children as $child) {
        $ids[] = $child->id;
        $ids = array_merge($ids, $child->getAllDescendantIds());
    }

    return $ids;
}

    // In Category model
protected static function booted()
{
    static::saved(fn () => Cache::forget('excluded_category_ids'));
    static::deleted(fn () => Cache::forget('excluded_category_ids'));
}

public function htmlTemplates()
{
    return $this->hasMany(HtmlTemplate::class);
}

 public function child()
{
    return $this->hasMany(Category::class, 'parent_id');
}

}
