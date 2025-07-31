<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business\Post;
use App\Models\Business\Media;
use App\Models\Business\Story;
use Illuminate\Support\Facades\Storage;

class ContentManagerController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        $stories = Story::latest()->paginate(10);
        $media = Media::latest()->paginate(10);

        return view('business.admin.content.index', compact('posts', 'stories', 'media'));
    }

    public function storeMedia(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:10240|mimes:jpeg,png,jpg,gif,mp4,mov',
            'type' => 'required|in:image,video',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $path = $request->file('file')->store('business/media', 'public');

        $media = Media::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'path' => $path,
            'business_id' => auth()->user()->business_id,
        ]);

        return back()->with('success', 'Media uploaded successfully');
    }

    public function deleteMedia($id)
    {
        $media = Media::findOrFail($id);
        
        if (Storage::disk('public')->exists($media->path)) {
            Storage::disk('public')->delete($media->path);
        }
        
        $media->delete();

        return back()->with('success', 'Media deleted successfully');
    }

    public function updateMediaDetails(Request $request, $id)
    {
        $media = Media::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $media->update($validated);

        return back()->with('success', 'Media details updated successfully');
    }
} 