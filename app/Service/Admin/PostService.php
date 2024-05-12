<?php

namespace App\Service\Admin;

use App\Models\Post;
use App\Service\Other\ImageService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function index(): LengthAwarePaginator
    {
        $posts = Post::with('categories')->orderByDesc('created_at');
        if ($status = request()->status) {
            $posts->where('status', $status);
        }
        if ($key = request()->key) {
            $posts->where(function ($posts) use ($key) {
                $posts->where('title', 'like', '%' . $key . '%')
                    ->orWhere('content', 'like', '%' . $key . '%');
            });
        }
        return $posts->paginate(config('length.limit_page_admin'));
    }

    public function updateStatus(int $postId, string $newStatus): bool
    {
        try {
            $post = Post::findOrFail($postId);
            $post->update(['status' => $newStatus]);
            return true;
        } catch (\Exception $e) {
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
}
