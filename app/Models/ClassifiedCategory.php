<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kalnoy\Nestedset\NodeTrait;

class ClassifiedCategory extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'parent_id'
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(ClassifiedPost::class, 'category', 'slug');
    }

    public function activePosts(): HasMany
    {
        return $this->posts()->active();
    }

    public static function getDefaultCategories(): array
    {
        return [
            [
                'name' => 'Vehicles',
                'slug' => 'vehicles',
                'icon' => 'car',
                'children' => [
                    ['name' => 'Cars', 'slug' => 'cars', 'icon' => 'car'],
                    ['name' => 'Motorcycles', 'slug' => 'motorcycles', 'icon' => 'motorcycle'],
                    ['name' => 'Boats', 'slug' => 'boats', 'icon' => 'ship'],
                    ['name' => 'RVs', 'slug' => 'rvs', 'icon' => 'caravan']
                ]
            ],
            [
                'name' => 'Real Estate',
                'slug' => 'real-estate',
                'icon' => 'home',
                'children' => [
                    ['name' => 'Houses for Sale', 'slug' => 'houses-for-sale', 'icon' => 'house'],
                    ['name' => 'Apartments for Rent', 'slug' => 'apartments-for-rent', 'icon' => 'building'],
                    ['name' => 'Commercial', 'slug' => 'commercial', 'icon' => 'store'],
                    ['name' => 'Land', 'slug' => 'land', 'icon' => 'map']
                ]
            ],
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'icon' => 'laptop',
                'children' => [
                    ['name' => 'Computers', 'slug' => 'computers', 'icon' => 'desktop'],
                    ['name' => 'Phones', 'slug' => 'phones', 'icon' => 'mobile'],
                    ['name' => 'TVs', 'slug' => 'tvs', 'icon' => 'tv'],
                    ['name' => 'Audio', 'slug' => 'audio', 'icon' => 'headphones']
                ]
            ],
            [
                'name' => 'Furniture',
                'slug' => 'furniture',
                'icon' => 'couch',
                'children' => [
                    ['name' => 'Living Room', 'slug' => 'living-room', 'icon' => 'sofa'],
                    ['name' => 'Bedroom', 'slug' => 'bedroom', 'icon' => 'bed'],
                    ['name' => 'Kitchen', 'slug' => 'kitchen', 'icon' => 'utensils'],
                    ['name' => 'Office', 'slug' => 'office', 'icon' => 'briefcase']
                ]
            ],
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'icon' => 'tshirt',
                'children' => [
                    ['name' => 'Men', 'slug' => 'men', 'icon' => 'male'],
                    ['name' => 'Women', 'slug' => 'women', 'icon' => 'female'],
                    ['name' => 'Kids', 'slug' => 'kids', 'icon' => 'child'],
                    ['name' => 'Accessories', 'slug' => 'accessories', 'icon' => 'glasses']
                ]
            ],
            [
                'name' => 'Jobs',
                'slug' => 'jobs',
                'icon' => 'briefcase',
                'children' => [
                    ['name' => 'Full-time', 'slug' => 'full-time', 'icon' => 'clock'],
                    ['name' => 'Part-time', 'slug' => 'part-time', 'icon' => 'hourglass-half'],
                    ['name' => 'Remote', 'slug' => 'remote', 'icon' => 'laptop-house'],
                    ['name' => 'Freelance', 'slug' => 'freelance', 'icon' => 'user-tie']
                ]
            ],
            [
                'name' => 'Services',
                'slug' => 'services',
                'icon' => 'tools',
                'children' => [
                    ['name' => 'Professional', 'slug' => 'professional', 'icon' => 'user-tie'],
                    ['name' => 'Home', 'slug' => 'home', 'icon' => 'home'],
                    ['name' => 'Education', 'slug' => 'education', 'icon' => 'graduation-cap'],
                    ['name' => 'Health', 'slug' => 'health', 'icon' => 'heartbeat']
                ]
            ]
        ];
    }
} 