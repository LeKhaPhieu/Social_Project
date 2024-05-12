<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Service\Admin\CategoryService;
use App\Service\Admin\PostService;
use Illuminate\Http\RedirectResponse;
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

    public function index(): View
    {
        $posts = $this->postService->index();
        $categories = $this->categoryService->getAll();
        return view('admin.post.index')->with([
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function edit(Post $post): View
    {
        $categories = $this->categoryService->getAll();
        return view('admin.post.update', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    public function updateStatus(Request $request, int $postId): RedirectResponse
    {
        $newStatus = $request->input('status');
        $result = $this->postService->updateStatus($postId, $newStatus);
        if ($result) {
            return redirect()->back()->with('success', __('admin.approved_post_success'));
        }
        return redirect()->back()->with('error', __('admin.approved_post_error'));
    }


    public function destroy($id): RedirectResponse
    {
        $result = $this->postService->destroy($id);
        if ($result) {
            return redirect()->back()->with('success', __('admin.delete_category_success'));
        }
        return redirect()->back()->with('error', __('admin.delete_category_error'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->only('title', 'image', 'content', 'category');
        $result = $this->postService->update($data, $id);
        if ($result) {
            return redirect()->back()->with('success', __('admin.update_category_success'));
        }
        return redirect()->back()->with('error', __('admin.update_category_error'));
    }
}
