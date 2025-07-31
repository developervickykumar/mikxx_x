<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IconKeyword;
use App\Models\Category;
use Illuminate\Support\Str;

class IconKeywordController extends Controller
{
    /**
     * Show the icon keyword mapping UI
     */
    public function index()
    {
        $iconJson = json_decode(file_get_contents(public_path('json/materialdesign-icons.json')), true);
        $iconMappings = IconKeyword::all()->keyBy('icon_class');

        return view('backend.icon_keywords.index', compact('iconJson', 'iconMappings'));
    }

    /**
     * Store or update keywords for a specific icon
     */
public function store(Request $request)
{
    $request->validate([
        'icon_class' => 'required|string',
        'keywords' => 'required|string',
    ]);

    $iconClass = $request->icon_class;
    $keywords = array_map('trim', explode(',', $request->keywords));

    // Save mapping
    $map = IconKeyword::updateOrCreate(
        ['icon_class' => $iconClass],
        ['keywords' => $request->keywords]
    );

    $updatedCategories = [];

    // Fetch ALL categories (whether icon is set or not, to test matching)
    Category::chunk(300, function ($categories) use ($keywords, $iconClass, &$updatedCategories) {
        foreach ($categories as $category) {
            $catName = strtolower($category->name);
            $matches = false;

            foreach ($keywords as $keyword) {
                if (Str::contains($catName, strtolower($keyword))) {
                    $matches = true;
                    break;
                }
            }

            if ($matches && (empty($category->icon) || $category->icon !== $iconClass)) {
                $category->icon = $iconClass;
                $category->save();
                $updatedCategories[] = $category->name;
            }
        }
    });

    return response()->json([
        'status' => 'success',
        'message' => 'Mapping saved and categories updated.',
        'updated_categories' => $updatedCategories
    ]);
}



    /**
     * Auto assign icons to categories based on keyword matches
     */
    public function bulkAssign()
    {
        $mappings = IconKeyword::all();
        $updated = 0;

        Category::whereNull('icon')->orWhere('icon', '')->chunk(500, function ($categories) use ($mappings, &$updated) {
            foreach ($categories as $category) {
                $catName = strtolower($category->name);

                foreach ($mappings as $map) {
                    foreach ($map->getKeywordsArray() as $keyword) {
                        if (Str::contains($catName, strtolower(trim($keyword)))) {
                            $category->icon = $map->icon_class;
                            $category->save();
                            $updated++;
                            break 2;
                        }
                    }
                }
            }
        });

        return back()->with('success', "$updated categories updated based on keyword mappings.");
    }

    /**
     * Optional: Get all icon-keyword mappings (for API usage)
     */
    public function apiMappings()
    {
        return response()->json(IconKeyword::all());
    }
    
    
    public function assignIconsToCategories()
    {
        $mappings = IconKeyword::all();
        $updated = 0;
    
        Category::where(function ($q) {
            $q->whereNull('icon')->orWhere('icon', '');
        })->chunk(200, function ($categories) use ($mappings, &$updated) {
            foreach ($categories as $category) {
                $catName = strtolower($category->name);
    
                foreach ($mappings as $map) {
                    foreach ($map->getKeywordsArray() as $keyword) {
                        if (Str::contains($catName, strtolower($keyword))) {
                            $category->icon = $map->icon_class;
                            $category->save();
                            $updated++;
                            break 2;
                        }
                    }
                }
            }
        });
    
        return response()->json([
            'status' => 'success',
            'updated' => $updated
        ]);
    }

}
