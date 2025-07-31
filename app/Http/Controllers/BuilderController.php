<?php

namespace App\Http\Controllers;

 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Route;
use App\Models\Category;

class BuilderController extends Controller
{
    
    
    
    //chooseBuilder
    
        // $builder = Category::where('name', 'builders')->first();
    // $builders = $builder ? $builder->children()->where('status', 'active')->get() : [];

    // return view('backend.builder.choose-builder', compact('builders'));
    
    
   public function index()
    {

       
        $builderCategory = Category::where('name', 'builders')->first();
    
        $formCategory = optional($builderCategory)
            ->children()
            ->where('name', 'Form')
            ->first();
    
        if (!$formCategory) {
            abort(404, "Form category not found.");
        }
    
        $formSubCategories = $formCategory->children()->where('status', 'active')->get();
    
        $groupedSubCategories = [];
    
        foreach ($formSubCategories as $subCategory) {
            if (!is_object($subCategory) || !isset($subCategory->name)) {
                \Log::error("Invalid subCategory:", ['data' => $subCategory]);
                continue;
            }
    
            $groupedSubCategories[$subCategory->name] = $subCategory->children()->where('status', 'active')->get();
        }
        
            $modules = Category::where('name', 'modules')->first();
    
   
        return view('backend.builder.index', [
            'groupedSubCategories' => $groupedSubCategories,
            'formCategory' => $formCategory,
            'modules' => $modules
        ]);
    }


    
     public function index2()
    {
      

       $userCategory = Category::where('name', 'user')->first();
        $userCategories = $userCategory ? $userCategory->children()->where('status', 'active')->get() : [];

        $pageCategory = Category::where('name', 'pages')->first(); 
        $pageCategories = $pageCategory ? $pageCategory->children()->where('status', 'active')->get() : [];

        $functionalityCategory = Category::where('name', 'functionality')->first(); 
        $functionalityCategories = $functionalityCategory ? $functionalityCategory->children()->where('status', 'active')->get() : [];
        
        $defaultForms = Category::where('label->label', 'Form')->get();


        return view('backend.builder.index', compact('userCategories', 'pageCategories', 'functionalityCategories', 'defaultForms'));
        
    }
    
}