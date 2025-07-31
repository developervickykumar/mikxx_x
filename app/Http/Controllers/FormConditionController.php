<?php

namespace App\Http\Controllers;

use App\Models\FormCondition;
use App\Models\FormField;
use Illuminate\Http\Request;

class FormConditionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'form_field_id' => 'required|exists:form_fields,id',
            'condition_type' => 'required|in:show,hide,enable,disable,require',
            'target_field' => 'required|string',
            'operator' => 'required|in:equals,not_equals,contains,greater_than,less_than,in,not_in',
            'value' => 'required|string',
            'additional_settings' => 'nullable|array',
        ]);

        $condition = FormCondition::create($validated);

        return response()->json([
            'message' => 'Condition created successfully',
            'condition' => $condition
        ]);
    }

    public function update(Request $request, FormCondition $condition)
    {
        $validated = $request->validate([
            'condition_type' => 'sometimes|in:show,hide,enable,disable,require',
            'operator' => 'sometimes|in:equals,not_equals,contains,greater_than,less_than,in,not_in',
            'value' => 'sometimes|string',
            'additional_settings' => 'nullable|array',
            'is_active' => 'sometimes|boolean',
        ]);

        $condition->update($validated);

        return response()->json([
            'message' => 'Condition updated successfully',
            'condition' => $condition
        ]);
    }

    public function destroy(FormCondition $condition)
    {
        $condition->delete();

        return response()->json([
            'message' => 'Condition deleted successfully'
        ]);
    }

    public function evaluate(Request $request)
    {
        $validated = $request->validate([
            'form_field_id' => 'required|exists:form_fields,id',
            'value' => 'required',
        ]);

        $field = FormField::findOrFail($validated['form_field_id']);
        $conditions = $field->conditions()->where('is_active', true)->get();

        $results = [];
        foreach ($conditions as $condition) {
            $results[] = [
                'condition_id' => $condition->id,
                'condition_met' => $condition->evaluate($validated['value']),
                'target_field' => $condition->target_field,
                'condition_type' => $condition->condition_type,
            ];
        }

        return response()->json($results);
    }
} 