<?php

namespace App\Http\Controllers;

use App\Models\FormFieldType;
use App\Models\FormFieldCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FormFieldTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = FormFieldType::with(['category', 'fields']);
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('component_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Apply category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }
        
        // Apply status filter
        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('is_active', $status);
        }
        
        // Get paginated results
        $fieldTypes = $query->latest()->paginate(10);
        
        // Get all categories for the filter dropdown
        $categories = FormFieldCategory::all();
        
        return view('backend.field_types.index', compact('fieldTypes', 'categories'));
    }

    public function create()
    {
        $categories = FormFieldCategory::all();
        return view('backend.field_types.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:form_field_categories,id',
            'name' => 'required|string|max:255',
            'component_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'default_config' => 'nullable|json',
            'validation_rules' => 'nullable|json',
            'supported_attributes' => 'nullable|json',
        ]);

        // Process JSON fields
        $validated['default_config'] = $request->filled('default_config') ? json_decode($request->default_config, true) : [];
        $validated['validation_rules'] = $request->filled('validation_rules') ? json_decode($request->validation_rules, true) : [];
        $validated['supported_attributes'] = $request->filled('supported_attributes') ? json_decode($request->supported_attributes, true) : [];
        
        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        FormFieldType::create($validated);

        return redirect()->route('field-types.index')->with('success', 'Field type created successfully');
    }

    public function edit(FormFieldType $fieldType)
    {
        $categories = FormFieldCategory::all();
        return view('backend.field_types.edit', compact('fieldType', 'categories'));
    }

    public function update(Request $request, FormFieldType $fieldType)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:form_field_categories,id',
            'name' => 'required|string|max:255',
            'component_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'default_config' => 'nullable|json',
            'validation_rules' => 'nullable|json',
            'supported_attributes' => 'nullable|json',
        ]);

        // Process JSON fields
        $validated['default_config'] = $request->filled('default_config') ? json_decode($request->default_config, true) : [];
        $validated['validation_rules'] = $request->filled('validation_rules') ? json_decode($request->validation_rules, true) : [];
        $validated['supported_attributes'] = $request->filled('supported_attributes') ? json_decode($request->supported_attributes, true) : [];
        
        $validated['is_active'] = $request->has('is_active');

        $fieldType->update($validated);

        return redirect()->route('field-types.index')->with('success', 'Field type updated successfully');
    }

    public function destroy(FormFieldType $fieldType)
    {
        // Check if the field type is in use
        if ($fieldType->fields()->count() > 0) {
            return redirect()->route('field-types.index')->with('error', 'Field type is in use and cannot be deleted');
        }

        $fieldType->delete();

        return redirect()->route('field-types.index')->with('success', 'Field type deleted successfully');
    }
    
    /**
     * Process batch actions for field types
     */
    public function batch(Request $request)
    {
        $request->validate([
            'selected' => 'required|array',
            'selected.*' => 'exists:form_field_types,id',
            'action' => 'required|string|in:activate,deactivate,duplicate,delete'
        ]);
        
        $selectedIds = $request->input('selected');
        $action = $request->input('action');
        $count = count($selectedIds);
        
        switch ($action) {
            case 'activate':
                FormFieldType::whereIn('id', $selectedIds)->update(['is_active' => true]);
                return redirect()->route('field-types.index')->with('success', "{$count} field type(s) activated successfully");
                
            case 'deactivate':
                FormFieldType::whereIn('id', $selectedIds)->update(['is_active' => false]);
                return redirect()->route('field-types.index')->with('success', "{$count} field type(s) deactivated successfully");
                
            case 'duplicate':
                foreach ($selectedIds as $id) {
                    $original = FormFieldType::findOrFail($id);
                    $clone = $original->replicate();
                    $clone->name = "{$original->name} (Copy)";
                    $clone->slug = Str::slug($clone->name);
                    $clone->save();
                }
                return redirect()->route('field-types.index')->with('success', "{$count} field type(s) duplicated successfully");
                
            case 'delete':
                // Check if any selected field types are in use
                $inUseCount = FormFieldType::whereIn('id', $selectedIds)
                                  ->withCount('fields')
                                  ->having('fields_count', '>', 0)
                                  ->count();
                
                if ($inUseCount > 0) {
                    return redirect()->route('field-types.index')
                        ->with('error', "Cannot delete {$inUseCount} field type(s) because they are in use by forms");
                }
                
                // Delete the field types that are not in use
                FormFieldType::whereIn('id', $selectedIds)->delete();
                return redirect()->route('field-types.index')->with('success', "{$count} field type(s) deleted successfully");
                
            default:
                return redirect()->route('field-types.index')->with('error', 'Invalid action');
        }
    }
    
    /**
     * Export field types as JSON
     */
    public function export(Request $request)
    {
        $query = FormFieldType::with('category');
        
        // Export selected field types if specified
        if ($request->has('selected')) {
            $query->whereIn('id', $request->input('selected'));
        }
        
        $fieldTypes = $query->get()->map(function ($fieldType) {
            return [
                'name' => $fieldType->name,
                'slug' => $fieldType->slug,
                'category' => $fieldType->category ? $fieldType->category->name : null,
                'component_name' => $fieldType->component_name,
                'description' => $fieldType->description,
                'default_config' => $fieldType->default_config,
                'validation_rules' => $fieldType->validation_rules,
                'supported_attributes' => $fieldType->supported_attributes,
                'is_active' => $fieldType->is_active,
            ];
        });
        
        $filename = 'field-types-export-' . date('Y-m-d') . '.json';
        
        // Return as download
        return response()->json($fieldTypes)
                        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                        ->header('Content-Type', 'application/json');
    }
    
    /**
     * Import field types from JSON
     */
    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:json',
            'overwrite' => 'boolean'
        ]);
        
        try {
            $file = $request->file('import_file');
            $content = file_get_contents($file->getRealPath());
            $data = json_decode($content, true);
            
            if (!is_array($data)) {
                return redirect()->route('field-types.index')
                    ->with('error', 'Invalid JSON format in import file');
            }
            
            $imported = 0;
            $errors = 0;
            
            foreach ($data as $item) {
                $validator = Validator::make($item, [
                    'name' => 'required|string|max:255',
                    'component_name' => 'required|string|max:255',
                    'slug' => 'string|max:255',
                ]);
                
                if ($validator->fails()) {
                    $errors++;
                    continue;
                }
                
                // Find category by name if provided
                $categoryId = null;
                if (!empty($item['category'])) {
                    $category = FormFieldCategory::firstOrCreate(
                        ['name' => $item['category']],
                        ['slug' => Str::slug($item['category'])]
                    );
                    $categoryId = $category->id;
                }
                
                // Generate slug if not provided
                $slug = $item['slug'] ?? Str::slug($item['name']);
                
                // Check if field type exists by slug
                $fieldType = FormFieldType::where('slug', $slug)->first();
                
                // Update existing or create new
                if ($fieldType && $request->input('overwrite', false)) {
                    $fieldType->update([
                        'name' => $item['name'],
                        'category_id' => $categoryId,
                        'component_name' => $item['component_name'],
                        'description' => $item['description'] ?? null,
                        'default_config' => $item['default_config'] ?? [],
                        'validation_rules' => $item['validation_rules'] ?? [],
                        'supported_attributes' => $item['supported_attributes'] ?? [],
                        'is_active' => $item['is_active'] ?? true,
                    ]);
                } elseif (!$fieldType) {
                    FormFieldType::create([
                        'name' => $item['name'],
                        'slug' => $slug,
                        'category_id' => $categoryId,
                        'component_name' => $item['component_name'],
                        'description' => $item['description'] ?? null,
                        'default_config' => $item['default_config'] ?? [],
                        'validation_rules' => $item['validation_rules'] ?? [],
                        'supported_attributes' => $item['supported_attributes'] ?? [],
                        'is_active' => $item['is_active'] ?? true,
                    ]);
                    $imported++;
                }
            }
            
            $message = "Imported {$imported} field types successfully.";
            if ($errors > 0) {
                $message .= " {$errors} field types failed validation and were skipped.";
            }
            
            return redirect()->route('field-types.index')->with('success', $message);
            
        } catch (\Exception $e) {
            Log::error('Field Type import error: ' . $e->getMessage());
            return redirect()->route('field-types.index')
                ->with('error', 'Error importing field types: ' . $e->getMessage());
        }
    }

    /**
     * Show the documentation page
     */
    public function documentation()
    {
        return view('backend.field_types.documentation');
    }
} 