<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Media;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    public function view()
    {
        $candidates = Candidate::with(['user', 'role'])->orderBy('created_at', 'desc')->paginate(10);
        return view('candidate-list', compact('candidates'));
    }


    public function storeMedia(Request $request)
    {
        // Validate the file upload
        $request->validate([
            'avatar' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,mov|max:10240', // Allow images and videos
        ]);

        // Handle file upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            
            // Store the file and get the file path
            $filePath = $file->store('media', 'public'); // 'public' disk is for public storage

            // Determine media type based on MIME type
            $mimeType = $file->getClientMimeType();
            $mediaType = 'image'; // Default to image
            if (strpos($mimeType, 'video') !== false) {
                $mediaType = 'video'; // If MIME type contains "video", set as video
            }

            // Create a new media record in the database
            Media::create([
                'candidate_id' => Auth::user()->candidate->id, // assuming user is a candidate
                'media_type' => $mediaType,  // Use 'image' or 'video' based on MIME type
                'file_path' => $filePath,
            ]);

            return redirect()->back()->with('success', 'Media uploaded successfully!');
        }

        return redirect()->back()->with('error', 'No file selected or upload failed!');
    }


    public function storeLike(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user
        $mediaId = $request->input('media_id'); // Get the media ID from the request

        // Check if the user has already liked this media
        $existingLike = Like::where('media_id', $mediaId)
                            ->where('user_id', $user->id)
                            ->first();

        if ($existingLike) {
            return back()->with('error', 'You have already liked this media.');
        }

        // If not, store the new like
        Like::create([
            'media_id' => $mediaId,
            'user_id' => $user->id,
        ]);

        return back()->with('success', 'You liked this media!');
    }

    public function storeComment(Request $request)
    {
        $user = auth()->user();  
        $mediaId = $request->input('media_id');  
        $commentText = $request->input('comment');  
    
        $existingComment = Comment::where('media_id', $mediaId)
                                   ->where('user_id', $user->id)
                                   ->first();
    
        if ($existingComment) {
            return back()->with('error', 'You have already commented on this media.');
        }
    
        Comment::create([
            'media_id' => $mediaId,
            'user_id' => $user->id,
            'comment' => $commentText,
        ]);
    
        return back()->with('success', 'Your comment was posted!');
    }

}