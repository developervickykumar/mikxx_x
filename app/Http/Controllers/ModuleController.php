<?php

namespace App\Http\Controllers;
use App\Models\Module;
use App\Models\Category;

use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $categories = $categories->unique('name');
   
        return view('backend.modules.create', compact('categories'));
    }
    
    
    public function store(Request $request)
    {

        $request->validate([
            'category_type' => 'required',
            'moduleSubcategory' => 'required',
            'page_name' => 'required',
            'module_name' => 'required',
            'tag_line' => 'nullable',
            'image' => 'nullable|image',
            'logo' => 'nullable|image',
            'short_desc' => 'nullable',
            'long_desc' => 'nullable',
            'feature' => 'nullable|array',
            'feature_desc' => 'nullable|array',
            'feature.*' => 'nullable|string',
            'feature_desc.*' => 'nullable|string',
        ]);

        $module = new Module();
        $module->category = $request->category_type;
        $module->subcategory = $request->moduleSubcategory;
        $module->page_name = $request->page_name;
        $module->module_name = $request->module_name;
        $module->tag_line = $request->tag_line;
        $module->short_desc = $request->short_desc;
        $module->long_desc = $request->long_desc;

        // Handle image and logo file upload
        if ($request->hasFile('image')) {
            $module->image = $request->file('image')->store('images', 'public');
        }
        if ($request->hasFile('logo')) {
            $module->logo = $request->file('logo')->store('logos', 'public');
        }

        // Save features in JSON format
        if ($request->has('feature') && count($request->feature) > 0) {
            $features = [];
            foreach ($request->feature as $index => $feature) {
                $features[] = [
                    'feature' => $feature,
                    'feature_desc' => $request->feature_desc[$index] ?? '',
                ];
            }
            $module->feature = json_encode($features); // Store as JSON
        }

        $module->save();

        return redirect()->route('modules.index')->with('success', 'Module created successfully');
    }

    public function index()
    {
        $modules = Module::orderBy('created_at', 'desc')->get(); 
        $categories = Category::select('id', 'name')->get();
        $categories = $categories->unique('name');

        return view('backend.modules.index', compact('modules', 'categories'));
    }

    public function edit($id)
    {

        $categories = Category::select('id', 'name', 'main_category')->get();
        $categories = $categories->unique('name');
        $module = Module::findOrFail($id);
        
        return view('backend.modules.edit', compact('module', 'categories')); 
    }

    public function update(Request $request, $id)
    {

        // dd($request->all());
        // Validate the incoming request
        $request->validate([
            'category' => 'required',
            'moduleSubcategory' => 'required',
            'page_name' => 'required',
            'module_name' => 'required',
            'tag_line' => 'nullable',
            'image' => 'nullable|image',
            'logo' => 'nullable|image',
            'short_desc' => 'nullable',
            'long_desc' => 'nullable',
            'feature' => 'nullable|array',
            'feature_desc' => 'nullable|array',
            'feature.*' => 'nullable|string',
            'feature_desc.*' => 'nullable|string',
        ]);

        $module = Module::findOrFail($id);
        $module->category = $request->category;
        $module->subcategory = $request->moduleSubcategory;
        $module->page_name = $request->page_name;
        $module->module_name = $request->module_name;
        $module->tag_line = $request->tag_line;
        $module->short_desc = $request->short_desc;
        $module->long_desc = $request->long_desc;

        // Handle image and logo file upload
        if ($request->hasFile('image')) {
            $module->image = $request->file('image')->store('images', 'public');
        }
        if ($request->hasFile('logo')) {
            $module->logo = $request->file('logo')->store('logos', 'public');
        }

        // Update features (JSON format)
        if ($request->has('feature') && count($request->feature) > 0) {
            $features = [];
            foreach ($request->feature as $index => $feature) {
                $features[] = [
                    'feature' => $feature,
                    'feature_desc' => $request->feature_desc[$index] ?? '',
                ];
            }
            $module->feature = json_encode($features); // Store as JSON
        }

        $module->save();

        return redirect()->route('modules.index')->with('success', 'Module updated successfully');
    }

    public function destroy($id)
    {
        $module = Module::findOrFail($id);
        $module->delete();
        return redirect()->route('modules.index')->with('success', 'Module deleted successfully');
    }

    function moduleDetail($id)
    {
        $module = Module::findOrFail($id);
        $features = json_decode($module->feature, true);
        return view('backend.modules.detail', compact('module', 'features'));
    }

    
}