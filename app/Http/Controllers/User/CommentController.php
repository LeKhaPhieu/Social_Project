<?php

namespace App\Http\Controllers\User;

use App\Events\CommentEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Service\User\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index(Request $request): JsonResponse
    {
        $comments = $this->commentService->index($request->postId);
        $listComments = view('user.post.comment', compact('comments'))->render();
        return response()->json(['comments' => $listComments]);
    }

    public function store(int $postId, CreateCommentRequest $request): JsonResponse
    {
        $data = $request->only('content', 'parent_id', 'user_id');
        $response = $this->commentService->store($postId, $data);
        return response()->json(['status' => $response]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $comment = $this->commentService->findComment($id);
        $postId = $comment->post_id;
        $post = Post::findOrFail($postId);
        if ($post->status !== Post::APPROVED) {
            return response()->json(['error' => __('home.update_comment_error')]);
        }
        if (Gate::allows('manage-comment', $comment)) {
            $data = $request->all();
            $response = $this->commentService->update($data, $id);
            return response()->json(['status' => $response]);
        }
        return response()->json(['error', __('home.update_comment_error')]);
    }

    public function destroy(int $id): JsonResponse
    {
        $comment = $this->commentService->findComment($id);
        $postId = $comment->post_id;
        $post = Post::findOrFail($postId);
        if ($post->status !== Post::APPROVED) {
            return response()->json(['error' => __('home.delete_comment_error')]);
        }
        if (Gate::allows('manage-comment', $comment)) {
            $response = $this->commentService->destroy($id);
            return response()->json(['status' => $response]);
        }
        return response()->json(['error', __('home.delete_comment_error')]);
    }
}
