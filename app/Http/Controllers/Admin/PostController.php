<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Service\Admin\CategoryService;
use App\Service\Admin\PostService as PostServiceAdmin;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    protected PostServiceAdmin $postServiceAdmin;

    protected CategoryService $categoryService;

    public function __construct(PostServiceAdmin $postServiceAdmin)
    {
        $this->postServiceAdmin = $postServiceAdmin;
    }

    public function store(): View
    {
        $posts = Post::orderBy('created_at', 'desc')
            ->paginate(Post::LIMIT_ADMIN_PAGE);

        return view('admin.post.index')->with([
            'Posts' => $posts,
            'items' => $posts
        ]);
    }

    public function edit(Post $post): View
    {
        return view('admin.post.update', [
            'post' => $post,
        ]);
    }

    public function updateStatus(int $id)
    {
        $result = $this->postServiceAdmin->updateStatus($id);

        if ($result) {

            return redirect()->route('posts.store')->with('success', __('admin.approved_post_success'));
        }

        return redirect()->route('posts.store')->with('error', __('admin.approved_post_error'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $result = $this->postServiceAdmin->destroy($post);

        if ($result) {

            return redirect()->back()->with('success', __('admin.delete_category_success'));
        }

        return redirect()->back()->with('error', __('admin.delete_category_error'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->only('title', 'image', 'content', 'category_id');
        $result = $this->postServiceAdmin->update($data, $id);

        if ($result) {

            return redirect()->back()->with('success', __('admin.update_category_success'));
        }

        return redirect()->back()->with('error', __('admin.update_category_error'));
    }
}
