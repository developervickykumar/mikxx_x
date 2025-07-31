<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModuleCategoryController extends Controller
{
    /**
     * Store a newly created category in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function index() {
        $categories = Category::orderBy('created_at', 'desc')->get(); 
        return view('backend.modules-category.index', compact('categories'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'add_category' => 'required|string|max:255',
    //         'userPageFunctionality' => 'required|string|max:255',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    //         'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
    //     ]);

    //     $imagePath = null;
    //     if ($request->hasFile('image')) {
    //         $imagePath = $request->file('image')->store('images', 'public');
    //     }

    //     $iconPath = null;
    //     if ($request->hasFile('icon')) {
    //         $iconPath = $request->file('icon')->store('icons', 'public');
    //     }

    //     Category::create([
    //         'name' => $request->name,
    //         'category' => $request->add_category,  
    //         'main_category' => $request->userPageFunctionality,  
    //         'image' => $imagePath,
    //         'icon' => $iconPath,
    //         'status' => 1, 
    //     ]);

    //     return redirect()->route('module.category.index')->with('success', 'Category added successfully!');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'add_category' => 'nullable|string|max:255',  
            'userPageFunctionality' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('icons', 'public');
        }

        $categories = explode(',', $request->add_category);

        foreach ($categories as $category) {
            $category = trim($category);

            Category::create([
                'name' => $request->name,
                'category' => $category, 
                'main_category' => $request->userPageFunctionality,
                'image' => $imagePath,
                'icon' => $iconPath,
                'status' => 1, 
            ]);
        }

        return redirect()->route('module.category.index')->with('success', 'Categories added successfully!');
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json(['success' => true, 'category' => $category]);
    }
    
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'add_category' => 'nullable|string|max:255',
            'userPageFunctionality' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
        ]);
    
        $imagePath = $category->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }
    
        $iconPath = $category->icon;
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('icons', 'public');
        }
    
        $category->update([
            'name' => $request->name,
            'category' => $request->add_category,
            'main_category' => $request->userPageFunctionality,
            'image' => $imagePath,
            'icon' => $iconPath,
            'status' => 1,  // You can adjust this based on your requirements
        ]);
    
        return redirect()->route('module.category.index')->with('success', 'Category updated successfully!');
    }
    
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('module.category.index')->with('success', 'Category deleted successfully!');
    }
    public function getCategoriesByType($category_type)
    {

        // $categories = Category::where('main_category', $category_type)->get(['name']);

        $categories = Category::where('main_category', $category_type)
                        ->select('name')
                        ->distinct()
                        ->get(['name']);
        return response()->json(['categories' => $categories]);
    }


}
