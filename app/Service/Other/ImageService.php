<?php

namespace App\Service\Other;

use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function uploadImage(array $data): string
    {
        try {
            $imageExists = Storage::disk('public')->exists('images/' . $data['image']->getClientOriginalName());
            if ($imageExists) {
                return 'images/' . $data['image']->getClientOriginalName();
            }
            $path = Storage::disk('public')->put('images', $data['image']);
            return $path;
        } catch (\Exception $e) {
            return config('image.image_fail');
        }
    }
}
