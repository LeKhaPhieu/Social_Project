<?php

namespace App\Service\User;

use App\Models\Comment;
use App\Models\Post;
use App\Service\Other\ImageService;
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
                'status' => Post::NOT_APPROVED
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
