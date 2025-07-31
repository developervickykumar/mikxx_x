<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormFieldSetting;

class FormFieldSettingController extends Controller
{
    public function save(Request $request)
    {

        dd($request->all());

        $validated = $request->validate([
            'form_id' => 'required|integer',
            'category_id' => 'required|integer',
        ]);

        FormFieldSetting::updateOrCreate(
            [
                'form_id' => $request->form_id,
                'category_id' => $request->category_id,
            ],
            $request->only([
                'input_type',
                'label',
                'placeholder',
                'tooltip',
                'default_value',
                'is_required',
                'validation_rules',
                'is_visible',
                'is_readonly',
                'is_disabled',
                'column_span',
                'custom_css_class',
                'position',
                'group_name',
                'help_text',
                'icon',
                'has_child',
                'child_display_type',
                'condition_on',
                'condition_value',
                'extra_settings'
            ])
        );

        return response()->json(['status' => 'success']);
    }
}
