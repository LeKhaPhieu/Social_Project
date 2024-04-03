<?php

namespace App\Service\Admin;

use App\Models\Post;
use Exception;

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
}
