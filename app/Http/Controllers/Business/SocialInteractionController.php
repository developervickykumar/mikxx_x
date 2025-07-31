<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Review;
use App\Models\SocialInteraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialInteractionController extends Controller
{
    public function like(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'id' => 'required|integer'
        ]);

        $model = $this->getModel($request->type, $request->id);
        if (!$model) {
            return response()->json(['error' => 'Invalid model type'], 400);
        }

        $model->like(Auth::user());

        return response()->json([
            'likes_count' => $model->likes_count,
            'is_liked' => true
        ]);
    }

    public function unlike(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'id' => 'required|integer'
        ]);

        $model = $this->getModel($request->type, $request->id);
        if (!$model) {
            return response()->json(['error' => 'Invalid model type'], 400);
        }

        $model->unlike(Auth::user());

        return response()->json([
            'likes_count' => $model->likes_count,
            'is_liked' => false
        ]);
    }

    public function comment(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'id' => 'required|integer',
            'content' => 'required|string|min:1|max:1000'
        ]);

        $model = $this->getModel($request->type, $request->id);
        if (!$model) {
            return response()->json(['error' => 'Invalid model type'], 400);
        }

        $comment = $model->comment(Auth::user(), $request->content);

        return response()->json([
            'comment' => $comment,
            'comments_count' => $model->comments_count
        ]);
    }

    public function share(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'id' => 'required|integer',
            'platform' => 'nullable|string'
        ]);

        $model = $this->getModel($request->type, $request->id);
        if (!$model) {
            return response()->json(['error' => 'Invalid model type'], 400);
        }

        $share = $model->share(Auth::user(), $request->platform);

        return response()->json([
            'share' => $share,
            'shares_count' => $model->shares_count
        ]);
    }

    private function getModel($type, $id)
    {
        return match ($type) {
            'post' => Post::find($id),
            'review' => Review::find($id),
            default => null
        };
    }
} 