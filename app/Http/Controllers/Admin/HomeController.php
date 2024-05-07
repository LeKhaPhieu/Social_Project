<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Service\Admin\HomeService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function dashboard(): View
    {
        $countPost = Post::approved()->count();
        $countUser = User::activated()->count();
        $countLike = Post::approved()->withCount('likes')->get()->sum('likes_count');
        $countComment = Post::approved()->withCount('comments')->get()->sum('comments_count');
        return view('admin.dashboard')->with([
            'countPost' => $countPost,
            'countUser' => $countUser,
            'countLike' => $countLike,
            'countComment' => $countComment,
        ]);
    }

    public function statisticsPosts(Request $request): JsonResponse
    {
        $data = $request->all();
        $formattedData = $this->homeService->filter($data,'posts');
        return response()->json($formattedData);
    }

    public function statisticsUsers(Request $request): JsonResponse
    {
        $data = $request->all();
        $formattedData = $this->homeService->filter($data,'users');
        return response()->json($formattedData);
    }

    public function filterPosts(Request $request): JsonResponse
    {
        $data = $request->all();
        $result = $this->homeService->filter($data, 'posts');
        return response()->json($result);
    }

    public function filterUsers(Request $request): JsonResponse
    {
        $data = $request->all();
        $result = $this->homeService->filter($data, 'users');
        return response()->json($result);
    }
}
