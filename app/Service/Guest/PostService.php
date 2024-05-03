<?php

namespace App\Service\Guest;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class PostService
{
    public function index(array $data): LengthAwarePaginator
    {
        $posts = Post::with('categories', 'user', 'likes', 'comments')
            ->approved()
            ->orderByDesc('created_at');
        if (isset($data['blog'])) {
            $posts->where(function ($query) use ($data) {
                $query->where('title', 'like', '%' . $data['blog'] . '%')
                    ->orWhere('content', 'like', '%' . $data['blog'] . '%');
            });
        }
        if (isset($data['author'])) {
            $posts->whereHas('user', function ($query) use ($data) {
                $query->where('user_name', 'like', '%' . $data['author'] . '%');
            });
        }

        if (isset($data['category'])) {
            $posts->whereHas('categories', function ($query) use ($data) {
                $query->whereIn('category_id', $data['category']);
            });
        }
        return $posts->paginate(config('length.limit_home_page'));
    }

    public function detailRelated(int $userId, int $postId): Collection
    {
        return Post::approved()->with('categories', 'user')
            ->where([['user_id', $userId], ['id', '<>', $postId]])
            ->inRandomOrder()
            ->take(config('length.limit_related_post'))
            ->get();
    }

    public function detailPopular(int $userId, int $postId): Collection
    {
        return Post::approved()->with('categories', 'user')
            ->where([['user_id', $userId], ['id', '<>', $postId]])
            ->withCount('likes')
            ->orderByDesc('likes_count')
            ->take(config('length.limit_related_popular'))
            ->get();
    }

    public function detailComment(int $postId): Collection
    {
        try {
            return Comment::with('likes', 'replies', 'user')
                ->whereNull('parent_id')
                ->where('post_id', $postId)
                ->get();
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }
}
