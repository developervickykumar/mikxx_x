<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormField;
use App\Models\FormFieldType;
use Illuminate\Http\Request;

class FormFieldController extends Controller
{
    public function index(Form $form)
    {
        $fields = $form->fields()->with('fieldType')->orderBy('order')->get();
        return view('backend.form_fields.index', compact('form', 'fields'));
    }

    public function create(Form $form)
    {
        $fieldTypes = FormFieldType::where('is_active', true)
            ->with('category')
            ->get()
            ->groupBy('category.name');
            
        $fields = $form->fields; // For parent field selection
        
        return view('backend.form_fields.create', compact('form', 'fieldTypes', 'fields'));
    }

    public function store(Request $request, Form $form)
    {
        $fieldType = FormFieldType::findOrFail($request->input('field_type_id'));
        
        $validated = $request->validate([
            'field_type_id' => 'required|exists:form_field_types,id',
            'name' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'placeholder' => 'nullable|string|max:255',
            'help_text' => 'nullable|string',
            'default_value' => 'nullable|string',
            'order' => 'nullable|integer',
            'width' => 'nullable|integer|min:1|max:12',
            'wrapper_class' => 'nullable|string|max:255',
            'input_class' => 'nullable|string|max:255',
            'section' => 'nullable|string|max:255',
            'section_order' => 'nullable|integer',
            'parent_field_id' => 'nullable|exists:form_fields,id',
        ]);

        $validated['form_id'] = $form->id;
        $validated['required'] = $request->has('required');
        $validated['is_visible'] = $request->has('is_visible');
        $validated['is_enabled'] = $request->has('is_enabled');
        
        // Handle options for fields that support them
        if ($request->has('options')) {
            $validated['options'] = $request->input('options');
        } else if (in_array($fieldType->component_name, [
            'select', 'multiselect', 'radio', 'checkbox-group', 'checkbox-dropdown'
        ])) {
            $options = [];
            $optionLabels = $request->input('option_labels', []);
            $optionValues = $request->input('option_values', []);
            
            foreach ($optionLabels as $index => $label) {
                if (!empty($label) && isset($optionValues[$index])) {
                    $options[] = [
                        'label' => $label,
                        'value' => $optionValues[$index]
                    ];
                }
            }
            
            $validated['options'] = $options;
        }

        // Handle validation rules
        if ($request->has('validation')) {
            $validated['validation'] = $request->input('validation');
        }

        // Handle attributes
        if ($request->has('attributes')) {
            $validated['attributes'] = $request->input('attributes');
        }

        // Handle config
        if ($request->has('config')) {
            $validated['config'] = $request->input('config');
        } else {
            // Use default config from field type
            $validated['config'] = $fieldType->default_config;
        }

        FormField::create($validated);

        return redirect()->route('forms.fields.index', $form)->with('success', 'Field added successfully');
    }

    public function edit(Form $form, FormField $field)
    {
        $fieldTypes = FormFieldType::where('is_active', true)
            ->with('category')
            ->get()
            ->groupBy('category.name');
            
        $fields = $form->fields()->where('id', '!=', $field->id)->get(); // For parent field selection
        
        return view('backend.form_fields.edit', compact('form', 'field', 'fieldTypes', 'fields'));
    }

    public function update(Request $request, Form $form, FormField $field)
    {
        $fieldType = FormFieldType::findOrFail($request->input('field_type_id'));
        
        $validated = $request->validate([
            'field_type_id' => 'required|exists:form_field_types,id',
            'name' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'placeholder' => 'nullable|string|max:255',
            'help_text' => 'nullable|string',
            'default_value' => 'nullable|string',
            'order' => 'nullable|integer',
            'width' => 'nullable|integer|min:1|max:12',
            'wrapper_class' => 'nullable|string|max:255',
            'input_class' => 'nullable|string|max:255',
            'section' => 'nullable|string|max:255',
            'section_order' => 'nullable|integer',
            'parent_field_id' => 'nullable|exists:form_fields,id',
        ]);

        $validated['required'] = $request->has('required');
        $validated['is_visible'] = $request->has('is_visible');
        $validated['is_enabled'] = $request->has('is_enabled');
        
        // Handle options similar to store method
        if ($request->has('options')) {
            $validated['options'] = $request->input('options');
        } else if (in_array($fieldType->component_name, [
            'select', 'multiselect', 'radio', 'checkbox-group', 'checkbox-dropdown'
        ])) {
            $options = [];
            $optionLabels = $request->input('option_labels', []);
            $optionValues = $request->input('option_values', []);
            
            foreach ($optionLabels as $index => $label) {
                if (!empty($label) && isset($optionValues[$index])) {
                    $options[] = [
                        'label' => $label,
                        'value' => $optionValues[$index]
                    ];
                }
            }
            
            $validated['options'] = $options;
        }

        // Handle validation rules
        if ($request->has('validation')) {
            $validated['validation'] = $request->input('validation');
        }

        // Handle attributes
        if ($request->has('attributes')) {
            $validated['attributes'] = $request->input('attributes');
        }

        // Handle config
        if ($request->has('config')) {
            $validated['config'] = $request->input('config');
        }

        $field->update($validated);

        return redirect()->route('forms.fields.index', $form)->with('success', 'Field updated successfully');
    }

    public function destroy(Form $form, FormField $field)
    {
        $field->delete();

        return redirect()->route('forms.fields.index', $form)->with('success', 'Field deleted successfully');
    }

    public function updateOrder(Request $request, Form $form)
    {
        $validated = $request->validate([
            'fields' => 'required|array',
            'fields.*.id' => 'required|exists:form_fields,id',
            'fields.*.order' => 'required|integer',
        ]);

        foreach ($validated['fields'] as $fieldData) {
            FormField::where('id', $fieldData['id'])
                ->where('form_id', $form->id)
                ->update(['order' => $fieldData['order']]);
        }

        return response()->json(['success' => true]);
    }

    // FormFieldController.php

public function saveFieldSettings(Request $request)
{
    $request->validate([
        'field_id' => 'required|exists:form_fields,id',
        'settings' => 'required|array',
    ]);

    $field = FormField::findOrFail($request->field_id);

    $existingConfig = $field->config ?? [];

    // Merge new settings into existing config
    $updatedConfig = array_merge($existingConfig, $request->settings);

    $field->update([
        'config' => $updatedConfig
    ]);

    return response()->json(['success' => true, 'config' => $updatedConfig]);
}

} 