<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Service\User\LikeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LikeController extends Controller
{
    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function likePost(Request $request, $postId): JsonResponse
    {
        $result = $this->likeService->likePost($postId);
        return response()->json($result);
    }

    public function likeComment(Request $request, $commentId): JsonResponse
    {
        $result = $this->likeService->likeComment($commentId);
        return response()->json($result);
    }
}
