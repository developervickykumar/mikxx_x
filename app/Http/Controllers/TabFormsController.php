<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\FormBuilder;
use App\Models\cursor\FormBuilderField;
use Illuminate\Http\Request;
use App\Models\User;

class TabFormsController extends Controller
{
    

    public function index()
    {
        

        $primaryTabs = Category::where('parent_id', '116468')
        ->where('status', 'Active')
        ->orderBy('position')
        ->get();

        
        return view('backend.tab-form-management', compact('primaryTabs'));
    }

    public function saveSettings(Request $request, $id)
    {
        // Save settings logic here
        // Example: Save in a JSON column or related settings table
    
        // Return with success message
        return redirect()->back()->with('success', 'Settings saved!');
    }


        public function tabForm(Request $request, $parent_id = null)
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }

        $currentUser = auth()->user();
        $user = User::findOrFail($currentUser->id);
        $socialLinks = $user->social_links ?? [];

        // Fallback parent_id if none is passed
        if (!$parent_id) {
            $defaultParent = Category::where('name', 'users setting')->first();
            $parent_id = $defaultParent ? $defaultParent->id : null;
        }

        $profileTabs = collect();



        if ($parent_id) {
            
            $formName = Category::where('id', $parent_id)->first();
            $formName = $formName->name;
            $profileTabs = Category::where('parent_id', $parent_id)
                ->where('status', 'Active')
                ->orderBy('position', 'asc')
                ->get();
               


            foreach ($profileTabs as $tab) {
                $tab->subTabs = Category::where('parent_id', $tab->id)
                    ->where('status', 'Active')
                    ->orderBy('position', 'asc')
                    ->get();

                foreach ($tab->subTabs as $subTab) {
                    $form = FormBuilder::where('tab_id', $tab->id)
                        ->where('sub_tab_id', $subTab->id)
                        ->where('publish_status', 'yes')
                        ->with('fields')
                        ->first();

                    if ($form) {
                        $subTab->form_settings = $form;

                        
                        $subTab->form_name = $form->name;


                        $fields = collect();

                        foreach ($form->fields as $savedField) {
                            $field = Category::with('children')
                                ->where('id', $savedField->field_id)
                                ->where('status', 'Active')
                                ->first();
                            if ($field) {
                                $field->column_width = $savedField->column_width;
                                $field->order = $savedField->field_order;
                                $fields->push($field);
                            }
                        }

                        $subTab->fields = $fields->sortBy('order')->values();
                    } else {
                        $subTab->form_settings = null;
                        $subTab->form_name = null;
                        $subTab->fields = Category::where('parent_id', $subTab->id)
                            ->where('status', 'Active')
                            ->orderBy('position', 'asc')
                            ->with('children')
                            ->get();
                    }
                }
            }
        }
        

        return view('backend.tab-forms', compact('user', 'socialLinks', 'profileTabs' , 'formName'));
    }

    public function formManagementView()
    {

        $primaryTabs = Category::where('parent_id', '116468')->get(); // No .with()


        return view('backend.form-management-view', compact('primaryTabs'));
    }

    public function formReport()
    {
        return view('backend.forms-report');
    }

   
}