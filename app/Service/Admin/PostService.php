<?php

namespace App\Service\Admin;

use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\Storage;

class PostService
{
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
        } catch (Exception $e) {
            return false;
        }
    }

    public function destroy(Post $post): bool
    {
        try {
            $post->delete();

            return true;
        } catch (Exception $e) {

            return false;
        }
    }

    public function update(array $data, int $id): bool
    {
        try {
            $post = Post::findOrFail($id);

            if (isset($data['image'])) {
                $fileImage = Storage::disk('public')->put('images', $data['image']);
            } else {
                $fileImage = $post->image;
            }

            $post->update([
                'category_id' => $data['category_id'],
                'title' => $data['title'],
                'content' => $data['content'],
                'image' => $fileImage,
            ]);

            return true;
        } catch (Exception $e) {

            return false;
        }
    }
}
