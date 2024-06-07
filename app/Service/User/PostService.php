<?php

namespace App\Service\User;

use App\Models\Comment;
use App\Models\Post;
use App\Service\Other\ImageService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostService
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function myBlog(int $userId, int $limit, array $data): LengthAwarePaginator
    {
        $posts = Post::with('categories', 'user', 'likes', 'comments')
            ->where('user_id', $userId);
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
        return $posts->orderByDesc('created_at')
            ->paginate($limit);
    }

    public function store(array $data): bool
    {
        DB::beginTransaction();
        try {
            $fileImage = $this->imageService->uploadImage($data);
            $post = Post::create([
                'user_id' => auth()->user()->id,
                'title' => $data['title'],
                'content' => $data['content'],
                'image' => $fileImage,
                'status' => Post::PENDING,
            ]);
            $post->categories()->attach($data['category']);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }
    }

    public function update(array $data, int $id): bool
    {
        DB::beginTransaction();
        try {
            $post = Post::findOrFail($id);
            $fileImageOld = $post->image;
            $this->imageService->updateImage($data, $post, $fileImageOld);
            $post->update([
                'title' => $data['title'],
                'content' => $data['content'],
            ]);
            $post->categories()->sync($data['category']);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }
    }

    public function destroy(int $id): bool
    {
        DB::beginTransaction();
        try {
            $post = Post::findOrFail($id);
            $post->categories()->detach();
            $post->likes()->detach();
            $commentsId = $post->comments()->get()->pluck('id')->toArray();
            DB::table('likes')->whereIn('comment_id', $commentsId)->delete();
            $post->comments()->delete();
            $this->imageService->deleteOldImage($post->image);
            $post->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }
    }
}
