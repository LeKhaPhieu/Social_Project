<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Service\Admin\CategoryService;
use App\Service\Guest\PostService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    protected PostService $postService;

    protected CategoryService $categoryService;

    public function __construct(
        PostService $postService,
        CategoryService $categoryService
    ) {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request): View
    {
        $data = $request->all();
        $posts = $this->postService->index($data);
        $categories = $this->categoryService->getAll();
        return view('guest.home')->with([
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }
}
