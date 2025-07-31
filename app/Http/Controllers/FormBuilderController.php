<?php

namespace App\Http\Controllers;

use App\Models\FormBuilder; 
use Illuminate\Http\Request;
use App\Models\cursor\FormBuilderField;



class FormBuilderController extends Controller
{

    public function store(Request $request)
    {
        $form = FormBuilder::updateOrCreate(
            ['id' => $request->id],
            $request->only([
                'title', 'cta_action', 'cta_success_message', 'cta_redirect_url',
                'for_type', 'data_mode', 'publish_status'
            ])
        );
    
        // Decode fields JSON string into PHP array
        $fields = json_decode($request->fields, true);
    
        if (is_array($fields)) {
            foreach ($fields as $fieldData) {
                $form->fields()->updateOrCreate(
                    ['field_id' => $fieldData['category_id']], // ← match the DB column name
                    [
                        'field_order' => $fieldData['order'],
                        'column_width' => $fieldData['column_span'],
                        'settings' => $fieldData['settings'] ?? []
                    ]
                );
                
            }
        }
    
        return response()->json(['status' => 'success', 'form_id' => $form->id]);
    }
    

}
