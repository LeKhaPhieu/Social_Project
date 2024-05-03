<?php

namespace App\Service\User;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LikeService
{
    public function likePost(int $postId): bool|array
    {
        try {
            $post = Post::findOrFail($postId);
            $user = auth()->user();
            if ($user->postLikes()->where('post_id', $post->id)->exists()) {
                $user->postLikes()->detach($post);
                $liked = false;
            } else {
                $user->postLikes()->attach($post);
                $liked = true;
            }
            $likesCount = $post->likes()->count();
            return [
                'liked' => $liked,
                'likesCount' => $likesCount,
            ];
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function likeComment(int $commentId): bool|array
    {
        try {
            $comment = Comment::findOrFail($commentId);
            $user = auth()->user();
            if ($user->commentLikes()->where('comment_id', $comment->id)->exists()) {
                $user->commentLikes()->detach($commentId);
                $liked = false;
            } else {
                $user->commentLikes()->attach($commentId);
                $liked = true;
            }
            $likesCount = $comment->likes()->count();
            return [
                'liked' => $liked,
                'likesCount' => $likesCount,
            ];
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }
}
