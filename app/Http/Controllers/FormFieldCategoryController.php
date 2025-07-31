<?php

namespace App\Http\Controllers;

use App\Models\FormFieldCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormFieldCategoryController extends Controller
{
    public function index()
    {
        $categories = FormFieldCategory::orderBy('display_order')->get();
        return view('backend.field_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.field_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'display_order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        FormFieldCategory::create($validated);

        return redirect()->route('field-categories.index')->with('success', 'Category created successfully');
    }

    public function edit(FormFieldCategory $category)
    {
        return view('backend.field_categories.edit', compact('category'));
    }

    public function update(Request $request, FormFieldCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'display_order' => 'nullable|integer',
        ]);

        $category->update($validated);

        return redirect()->route('field-categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(FormFieldCategory $category)
    {
        // Check if the category has field types
        if ($category->fieldTypes()->count() > 0) {
            return redirect()->route('field-categories.index')
                ->with('error', 'Category has field types and cannot be deleted');
        }

        $category->delete();

        return redirect()->route('field-categories.index')->with('success', 'Category deleted successfully');
    }

    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:form_field_categories,id',
            'categories.*.display_order' => 'required|integer',
        ]);

        foreach ($validated['categories'] as $categoryData) {
            FormFieldCategory::where('id', $categoryData['id'])
                ->update(['display_order' => $categoryData['display_order']]);
        }

        return response()->json(['success' => true]);
    }
} 