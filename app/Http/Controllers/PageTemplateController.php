<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;



class PageTemplateController extends Controller
{
    public function index()
    {
         
        $pageTemplates = Category::where('parent_id', '116615')
        ->where('status', 'Active')
        ->orderBy('position')
        ->get();
 
        return view('page-templates.index', compact('pageTemplates'));
    }

    public function show($id)
    {
        $pageTemplate = Category::find($id);
        $pageTemplate->html_code = $pageTemplate->code;
        return view('page-templates.show', compact('pageTemplate'));
    }

    public function create()
    {
        return view('page-templates.create');
    }

    public function update(Request $request, $id)
    {
        $pageTemplate = Category::findOrFail($id);
    
        $html = $request->input('html_input', '');
        $css = $request->input('css_input', '');
        $js = $request->input('js_input', '');
    
        $combinedCode = $html;
    
        if (!empty($css)) {
            $combinedCode .= "\n<style>\n" . $css . "\n</style>";
        }
    
        if (!empty($js)) {
            $combinedCode .= "\n<script>\n" . $js . "\n</script>";
        }
    
        $pageTemplate->code = $combinedCode;
        $pageTemplate->save();
    
        return response()->json(['success' => true, 'message' => 'Template updated successfully.']);
    }
     
}