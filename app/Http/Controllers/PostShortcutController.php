<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostShortcutController extends Controller
{
    // Show Post Shortcut Page
    public function index()
    {
        return view('backend.post.shortcut');
    }

    // Show Create Post Page depending on type
    public function create($type)
    {
        $allowedTypes = ['story', 'image', 'video', 'blog', 'recipe', 'holiday', 'teach', 'classified', 'film'];

        if (!in_array($type, $allowedTypes)) {
            abort(404); // If type is not allowed
        }

        return view('backend.post.create_' . $type, compact('type'));
    }
}
