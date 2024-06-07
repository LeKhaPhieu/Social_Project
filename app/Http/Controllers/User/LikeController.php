<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Service\User\LikeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LikeController extends Controller
{
    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function likePost(Request $request, int $postId): JsonResponse
    {
        $post = Post::find($postId);
        if (!$post) {
            return response()->json('error', __('home.post_not_approved_error'));
        }
        if ($post->status !== Post::APPROVED) {
            return response()->json('error', __('home.post_not_approved_error'));
        }
        $result = $this->likeService->likePost($postId);
        return response()->json($result);
    }

    public function likeComment(Request $request, int $commentId): JsonResponse
    {
        $comment = Comment::findOrFail($commentId);
        $postId = $comment->post_id;
        $post = Post::findOrFail($postId);
        if ($post->status !== Post::APPROVED) {
            return response()->json(['error' => __('home.post_not_approved_error')], 400);
        }
        $result = $this->likeService->likeComment($commentId);
        return response()->json($result);
    }
}
