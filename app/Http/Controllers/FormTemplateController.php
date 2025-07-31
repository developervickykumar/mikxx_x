<?php

namespace App\Http\Controllers;

use App\Models\FormTemplate;
use Illuminate\Http\Request;

class FormTemplateController extends Controller
{
    public function index()
    {
        $templates = FormTemplate::all();
        return view('form-templates.index', compact('templates'));
    }

    public function create()
    {
        return view('form-templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'html_code' => 'required|string',
        ]);

        FormTemplate::create($request->only('title', 'html_code'));
        return redirect()->route('form-templates.index')->with('success', 'Template saved successfully!');
    }

    public function show(FormTemplate $template)
    {
        return view('form-templates.show', compact('template'));
    }

    public function update(Request $request, Template $template)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'html_code' => 'required|string',
        ]);

        $template->update([
            'title' => $request->title,
            'html_code' => $request->html_code,
        ]);

        return redirect()->route('templates.show', $template->id)->with('success', 'Template updated successfully.');
    }

}
