<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StoryController extends Controller
{
    /**
     * Display a listing of the stories.
     */
    public function index(Business $business)
    {
        $stories = $business->stories()
            ->active()
            ->latest()
            ->get();

        return view('business.stories.index', compact('business', 'stories'));
    }

    /**
     * Show the form for creating a new story.
     */
    public function create(Business $business)
    {
        return view('business.stories.create', compact('business'));
    }

    /**
     * Store a newly created story.
     */
    public function store(Request $request, Business $business)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'media' => 'required|file|mimes:jpeg,png,jpg,gif,mp4|max:10240',
            'expires_at' => 'nullable|date|after:now',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $media = $request->file('media');
        $mediaType = $media->getMimeType();
        $isVideo = Str::startsWith($mediaType, 'video/');
        
        $mediaPath = $media->store('stories/' . $business->id, 'public');
        
        $thumbnailPath = null;
        if ($isVideo) {
            // Generate thumbnail for video
            $thumbnailPath = $this->generateVideoThumbnail($media, $business->id);
        }

        $story = $business->stories()->create([
            'title' => $request->title,
            'content' => $request->content,
            'media_type' => $isVideo ? 'video' : 'image',
            'media_path' => $mediaPath,
            'thumbnail_path' => $thumbnailPath,
            'expires_at' => $request->expires_at,
            'metadata' => [
                'views' => 0,
                'duration' => $isVideo ? $this->getVideoDuration($media) : null,
            ],
        ]);

        return redirect()->route('business.stories.index', $business)
            ->with('success', 'Story created successfully.');
    }

    /**
     * Display the specified story.
     */
    public function show(Business $business, Story $story)
    {
        // Increment view count
        $metadata = $story->metadata;
        $metadata['views'] = ($metadata['views'] ?? 0) + 1;
        $story->update(['metadata' => $metadata]);

        return view('business.stories.show', compact('business', 'story'));
    }

    /**
     * Show the form for editing the specified story.
     */
    public function edit(Business $business, Story $story)
    {
        return view('business.stories.edit', compact('business', 'story'));
    }

    /**
     * Update the specified story.
     */
    public function update(Request $request, Business $business, Story $story)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4|max:10240',
            'expires_at' => 'nullable|date|after:now',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'expires_at' => $request->expires_at,
        ];

        if ($request->hasFile('media')) {
            // Delete old media
            Storage::disk('public')->delete([
                $story->media_path,
                $story->thumbnail_path
            ]);

            $media = $request->file('media');
            $mediaType = $media->getMimeType();
            $isVideo = Str::startsWith($mediaType, 'video/');
            
            $mediaPath = $media->store('stories/' . $business->id, 'public');
            
            $thumbnailPath = null;
            if ($isVideo) {
                $thumbnailPath = $this->generateVideoThumbnail($media, $business->id);
            }

            $data = array_merge($data, [
                'media_type' => $isVideo ? 'video' : 'image',
                'media_path' => $mediaPath,
                'thumbnail_path' => $thumbnailPath,
                'metadata' => [
                    'views' => $story->metadata['views'] ?? 0,
                    'duration' => $isVideo ? $this->getVideoDuration($media) : null,
                ],
            ]);
        }

        $story->update($data);

        return redirect()->route('business.stories.index', $business)
            ->with('success', 'Story updated successfully.');
    }

    /**
     * Remove the specified story.
     */
    public function destroy(Business $business, Story $story)
    {
        // Delete media files
        Storage::disk('public')->delete([
            $story->media_path,
            $story->thumbnail_path
        ]);

        $story->delete();

        return redirect()->route('business.stories.index', $business)
            ->with('success', 'Story deleted successfully.');
    }

    /**
     * Toggle story active status.
     */
    public function toggle(Business $business, Story $story)
    {
        $story->update(['is_active' => !$story->is_active]);

        return redirect()->route('business.stories.index', $business)
            ->with('success', 'Story status updated successfully.');
    }

    /**
     * Generate thumbnail for video.
     */
    private function generateVideoThumbnail($video, $businessId)
    {
        // This is a placeholder. In a real implementation, you would use FFmpeg
        // or a similar tool to generate a thumbnail from the video.
        // For now, we'll just return null.
        return null;
    }

    /**
     * Get video duration.
     */
    private function getVideoDuration($video)
    {
        // This is a placeholder. In a real implementation, you would use FFmpeg
        // or a similar tool to get the video duration.
        // For now, we'll just return null.
        return null;
    }
} 