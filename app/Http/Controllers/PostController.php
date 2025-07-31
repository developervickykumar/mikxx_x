<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
 
use Illuminate\Support\Facades\DB;
 
use App\Models\Post\PostVideo;
use App\Models\Post\PostPoll;
use App\Models\Post\PostPollOption;
use App\Models\Post\PostTag;
use App\Models\Post\Post;
use App\Models\Post\PostImage;
use App\Models\Post\PostLike;
use Illuminate\Support\Facades\Auth;
use App\Models\Post\PostComment;


class PostController extends Controller
{
    public function index()
    {

        
        $primaryTabs = Category::where('parent_id', 116468)
        ->with(['childrenRecursive'])
        ->orderBy('position')
        ->get();
    
    

        $postParent = Category::where('name', 'post')->first();
    
        if (!$postParent) {
            abort(404, 'Post category not found.');
        }
    
        $postTypes = Category::where('parent_id', $postParent->id)
            ->select('id', 'name', 'icon')
            ->get();
            
        
        $posts = Post::with([
            'user',
            'video',
            'image',
            'poll.options',
            'tags',
            'comments' => function ($q) {
                $q->whereNull('parent_id') // Only top-level comments
                  ->withCount('replies')   // Count of replies
                  ->with(['user', 'replies.user']); // Include user and replies' user
            }
        ])->latest()->get();


        return view('backend.post.index', compact('postTypes', 'primaryTabs', 'posts'));

    }

    
    public function getChildren($id)
    {

        $children = Category::where('parent_id', $id)
            ->select('id', 'name', 'icon')
            ->get();

        return response()->json($children);
    }
    
    
    public function store(Request $request)
{
    // $request->validate([
    //     'post_type' => 'required|in:text,image,video,music,link,poll',
    //     'visibility' => 'in:public,private,friends',
    //     'content' => 'nullable|string',
    //     'title' => 'nullable|string',
    //     'category' => 'nullable|string',
    // ]);

    return DB::transaction(function () use ($request) {
        $post = Post::create([
            'user_id' => auth()->id(),
            'post_type' => $request->post_type,
            'content' => $request->content,
            'visibility' => $request->visibility ?? 'public',
        ]);

        // Type-specific inserts
        switch ($request->post_type) {
            case 'video':
                PostVideo::create([
                    'post_id' => $post->id,
                    'video_url' => $request->video_url,
                    'thumbnail_url' => $request->thumbnail_url,
                    'duration' => $request->duration,
                ]);
                break;

        case 'image':
            $image = $request->file('media_file');
            if ($image) {
                try {
                    $path = $image->store('uploads/images', 'public');
                    PostImage::create([
                        'post_id' => $post->id,
                        'image_url' => asset('storage/' . $path),
                        'caption' => $request->input('caption', null),
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Image upload failed: ' . $e->getMessage());
                }
            }

            break;


            case 'poll':
                $poll = PostPoll::create([
                    'post_id' => $post->id,
                    'question' => $request->question,
                    'expires_at' => $request->expires_at,
                ]);
                foreach ($request->options as $option) {
                    PostPollOption::create([
                        'poll_id' => $poll->id,
                        'option_text' => $option,
                    ]);
                }
                break;

            // Add additional case blocks for music, link, etc.
        }

        // Tags
        if ($request->has('tags')) {
            foreach ($request->tags as $tag) {
                PostTag::create([
                    'post_id' => $post->id,
                    'tag' => $tag,
                ]);
            }
        }

        return response()->json(['status' => 'success', 'post_id' => $post->id]);
    });
}


    
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'post_type' => 'required|in:text,image,video,poll,article',
    //         'content' => 'nullable|string',
    //         'visibility' => 'nullable|in:public,private,friends',
    //     ]);
    
    //     $post = Post::create([
    //         'user_id' => auth()->id(),
    //         'post_type' => $validated['post_type'],
    //         'content' => $validated['content'] ?? null,
    //         'visibility' => $validated['visibility'] ?? 'public',
    //     ]);
    
    //     // Post-type specific saving
    //     switch ($validated['post_type']) {
    //         case 'image':
    //             $request->validate(['image_url' => 'required']);
    //             $post->image()->create(['image_url' => $request->image_url, 'caption' => $request->caption]);
    //             break;
    
    //         case 'video':
    //             $request->validate(['video_url' => 'required']);
    //             $post->video()->create([
    //                 'video_url' => $request->video_url,
    //                 'thumbnail_url' => $request->thumbnail_url,
    //                 'duration' => $request->duration,
    //             ]);
    //             break;
    
    //         case 'poll':
    //             $poll = $post->poll()->create([
    //                 'question' => $request->question,
    //                 'expires_at' => $request->expires_at,
    //             ]);
    //             foreach ($request->poll_options as $option) {
    //                 $poll->options()->create(['option_text' => $option]);
    //             }
    //             break;
    
    //         case 'article':
    //             $post->article()->create([
    //                 'title' => $request->title,
    //                 'body' => $request->body,
    //                 'featured_image' => $request->featured_image,
    //             ]);
    //             break;
    //     }
    
    //     // Optional: Save tags
    //     if ($request->tags) {
    //         foreach ($request->tags as $tag) {
    //             $post->tags()->create(['tag' => $tag]);
    //         }
    //     }
    
    //     // Optional: Save location
    //     if ($request->latitude && $request->longitude) {
    //         $post->location()->create([
    //             'latitude' => $request->latitude,
    //             'longitude' => $request->longitude,
    //             'address' => $request->address,
    //         ]);
    //     }
    
    //     return redirect()->back()->with('success', 'Post created successfully!');
    // }
        
    
    public function toggleLike(Request $request, $postId)
    {
        $userId = Auth::id();
    
        $like = PostLike::where('post_id', $postId)->where('user_id', $userId)->first();
    
        if ($like) {
            $like->delete();
            return response()->json(['status' => 'unliked']);
        } else {
            PostLike::create([
                'post_id' => $postId,
                'user_id' => $userId,
            ]);
            return response()->json(['status' => 'liked']);
        }
    }


public function storeComment(Request $request, $postId)
{
 
    $request->validate([
        'comment' => 'required|string|max:1000',
        'parent_id' => 'nullable|exists:post_comments,id',
    ]);

    $commentText = $request->input('comment');
    $parentId = $request->input('parent_id');

    // Prevent nested replies
    if ($parentId) {
        $parentComment = PostComment::find($parentId);
        // if ($parentComment && $parentComment->parent_id !== null) {
        //     return response()->json(['error' => 'Only 1 level reply allowed'], 422);
        // }
    }

    $comment = PostComment::create([
        'post_id' => $postId,
        'user_id' => auth()->id(),
        'comment' => $commentText,
        'parent_id' => $parentId,
    ]);

    $comment->load('user');

    return response()->json([
        'success' => true,
        'comment' => [
            'id' => $comment->id,
            'comment' => $comment->comment,
            'username' => $comment->user->username,
            'created_at' => $comment->created_at->diffForHumans(),
            'profile_picture' => asset('uploads/profile_pics/' . ($comment->user->profile_picture ?? 'default-user.png')),
            'parent_id' => $comment->parent_id
        ]
    ]);
}

    
 }