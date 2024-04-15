<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Service\Admin\CategoryService;
use App\Service\User\PostService;
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

    public function create(): View
    {
        $categories = $this->categoryService->getAll();
        return view('user.post.create')->with([
            'categories' => $categories,
        ]);
    }
}
