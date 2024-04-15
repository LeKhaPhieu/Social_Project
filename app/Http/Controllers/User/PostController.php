<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreatePostRequest;
use App\Service\Admin\CategoryService;
use App\Service\User\PostService;
use Illuminate\Http\RedirectResponse;
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

    public function store(CreatePostRequest $request): RedirectResponse
    {
        $data = $request->only('title', 'content', 'image', 'category');
        $response = $this->postService->store($data);
        if ($response) {
            return redirect()->back()->with('success', __('home.create_post_success'));
        }
        return redirect()->back()->with('error', __('home.create_post_error'));
    }
}
