<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormTemplate;

class TemplatePreviewController extends Controller
{
    public function preview(Request $request)
    {
        // Select the template based on preview type or other logic
        $previewType = $request->get('preview_type', 'product'); // fallback
        $template = FormTemplate::where('title', $previewType)->first();

        if (!$template) {
            return '<div class="p-4 text-danger">Template not found for preview type: ' . $previewType . '</div>';
        }

        $html = $template->html_code;

        // Replace placeholders with submitted form data
        foreach ($request->except('_token') as $key => $value) {
            $html = str_replace('{{' . $key . '}}', e($value), $html);
        }

        return response($html);
    }
}
