<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\User\CreatePostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Service\Admin\CategoryService;
use App\Service\User\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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

    public function myBlog(Request $request): View
    {
        $data = $request->all();
        $user = auth()->user();
        $categories = $this->categoryService->getAll();
        $posts = $this->postService->myBlog($user->id, config('length.limit_home_page'), $data);
        return view('guest.home')->with([
            'categories' => $categories,
            'posts' => $posts,
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

    public function edit(Post $post): View|RedirectResponse
    {
        $post = Post::findOrFail($post->id);
        if ($post->status === Post::NOT_APPROVED) {
            return redirect()->route('home')->with('error', __('home.edit_post_error'));
        }
        if (!Gate::allows('manage-post', $post)) {
            return redirect()->route('home')->with('error', __('home.edit_post_error'));
        }
        $categories = $this->categoryService->getAll();
        return view('user.post.update', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    public function update(UpdatePostRequest $request, int $id): RedirectResponse
    {
        $post = Post::findOrFail($id);
        if ($post->status === Post::NOT_APPROVED) {
            return redirect()->route('home')->with('error', __('admin.update_post_error'));
        }
        if (!Gate::allows('manage-post', $post)) {
            return redirect()->route('home')->with('error', __('home.edit_post_error'));
        }
        $data = $request->only('title', 'image', 'content', 'category');
        $result = $this->postService->update($data, $id);
        if ($result) {
            return redirect()->back()->with('success', __('admin.update_post_success'));
        }
        return redirect()->back()->with('error', __('admin.update_post_error'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $post = Post::findOrFail($id);
        if ($post->status === Post::NOT_APPROVED) {
            return redirect()->route('home')->with('error', __('admin.delete_category_error'));
        }
        if (!Gate::allows('manage-post', $post)) {
            return redirect()->back()->with('error', __('home.delete_post_error'));
        }
        $result = $this->postService->destroy($id);
        if ($result) {
            return redirect()->back()->with('success', __('admin.delete_category_success'));
        }
        return redirect()->back()->with('error', __('admin.delete_category_error'));
    }
}
