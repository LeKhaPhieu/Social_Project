<?php

namespace App\Service\Admin;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostService
{
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

    public function updateStatus(int $id): bool
    {
        try {
            $post = Post::where('id', $id)->firstOrFail();
            if ($post->status == Post::APPROVED) {
                $post->update(['status' => Post::NOT_APPROVED]);
            } else {
                $post->update(['status' => Post::APPROVED]);
            }
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
            $fileImage = $post->image;
            if ($fileImage) {
                unlink(storage_path('app/public/' . $fileImage));
            }
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
            $fileImage = '';
            if (isset($data['image'])) {
                $fileImage = Storage::disk('public')->put('images', $data['image']);
                $post->update(['image' => $fileImage]);
                unlink(storage_path('app/public/' . $fileImageOld));
            }
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
