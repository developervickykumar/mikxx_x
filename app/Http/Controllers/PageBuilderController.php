<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Component;

class PageBuilderController extends Controller
{
    public function index()
    {
        return view('page-builder.index');
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|json',
            'page_id' => 'nullable|exists:pages,id'
        ]);

        if ($request->page_id) {
            $page = Page::findOrFail($request->page_id);
            $page->update([
                'content' => $validated['content'],
                'last_modified_by' => auth()->id()
            ]);
        } else {
            $page = Page::create([
                'content' => $validated['content'],
                'created_by' => auth()->id(),
                'last_modified_by' => auth()->id()
            ]);
        }

        return response()->json([
            'success' => true,
            'page_id' => $page->id,
            'message' => 'Page saved successfully'
        ]);
    }

    public function preview($id)
    {
        $page = Page::findOrFail($id);
        return view('page-builder.preview', compact('page'));
    }

    public function export($id)
    {
        $page = Page::findOrFail($id);
        $html = view('page-builder.export', compact('page'))->render();
        
        return response()->streamDownload(function() use ($html) {
            echo $html;
        }, 'page-export.html');
    }

    public function getComponents()
    {
        $components = Component::all();
        return response()->json($components);
    }
} 