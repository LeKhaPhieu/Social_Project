<?php

namespace App\Service\User;

use App\Models\Post;
use App\Service\Other\ImageService;
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
}
