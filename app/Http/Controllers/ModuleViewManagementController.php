<?php

namespace App\Http\Controllers;

use App\Models\Category;

class ModuleViewManagementController extends Controller
{
    public function index()
    {
        return view('backend.module-view.index');
    }

    public function moduleView($parentId)
    {
        $primaryTabs = Category::where('parent_id', $parentId)->get();  
        return view('backend.module-view.view', compact('primaryTabs'));
    }


}
