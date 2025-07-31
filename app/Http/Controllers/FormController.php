<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::all();
        return view('backend.forms.index', compact('forms'));
    }

    public function create()
    {
        return view('backend.forms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'success_message' => 'nullable|string',
            'redirect_url' => 'nullable|url',
            'submit_button_text' => 'nullable|string|max:255',
            'cancel_button_text' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');
        $validated['settings'] = $request->input('settings', []);
        $validated['permissions'] = $request->input('permissions', []);

        $form = Form::create($validated);

        return redirect()->route('forms.edit', $form)->with('success', 'Form created successfully');
    }

    public function show(Form $form)
    {
        $fieldsBySection = $form->getFieldsBySection();
        return view('backend.forms.show', compact('form', 'fieldsBySection'));
    }

    public function edit(Form $form)
    {
        return view('backend.forms.edit', compact('form'));
    }

    public function update(Request $request, Form $form)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'success_message' => 'nullable|string',
            'redirect_url' => 'nullable|url',
            'submit_button_text' => 'nullable|string|max:255',
            'cancel_button_text' => 'nullable|string|max:255',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['settings'] = $request->input('settings', []);
        $validated['permissions'] = $request->input('permissions', []);

        $form->update($validated);

        return redirect()->route('forms.edit', $form)->with('success', 'Form updated successfully');
    }

    public function destroy(Form $form)
    {
        $form->delete();
        return redirect()->route('forms.index')->with('success', 'Form deleted successfully');
    }

    public function render($slug)
    {
        $form = Form::findBySlug($slug);
        if (!$form || !$form->is_active) {
            abort(404);
        }

        $fieldsBySection = $form->getFieldsBySection();
        return view('frontend.forms.render', compact('form', 'fieldsBySection'));
    }

    public function submit(Request $request, $slug)
    {
        $form = Form::findBySlug($slug);
        if (!$form || !$form->is_active) {
            abort(404);
        }

        $fields = $form->fields;
        $rules = [];

        foreach ($fields as $field) {
            if ($field->is_visible && $field->is_enabled) {
                $rules["field.{$field->id}"] = $field->getValidationRulesAttribute();
            }
        }

        $validated = $request->validate($rules);

        // Process the form submission (e.g., save to database, send email, etc.)
        // This would be implemented based on your specific requirements

        if ($form->redirect_url) {
            return redirect($form->redirect_url);
        }

        return redirect()->back()->with('success', $form->success_message ?? 'Form submitted successfully');
    }
} 