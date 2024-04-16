<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateCommentRequest;
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

    public function update(int $id, Request $request): JsonResponse|RedirectResponse
    {
        $comment = $this->commentService->findComment($id);
        if (Gate::allows('manage-comment', $comment)) {
            $data = $request->all();
            $response = $this->commentService->update($data, $id);
            return response()->json(['status' => $response]);
        }
        return redirect()->back()->with('error', __('home.update_comment_error'));
    }

    public function destroy(int $id): JsonResponse|RedirectResponse
    {
        $comment = $this->commentService->findComment($id);
        if (Gate::allows('manage-comment', $comment)) {
            $response = $this->commentService->destroy($id);
            return response()->json(['status' => $response]);
        }
        return redirect()->back()->with('error', __('home.delete_comment_error'));
    }
}
