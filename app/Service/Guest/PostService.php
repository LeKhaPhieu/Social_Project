<?php

namespace App\Service\Guest;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

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

        if(isset($data['category'])) {
            $posts->whereHas('categories', function ($query) use ($data) {
                $query->whereIn('category_id', $data['category']);
            });
        }
        return $posts->paginate(config('length.limit_home_page'));
    }
}
