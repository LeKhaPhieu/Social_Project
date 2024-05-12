<?php

namespace App\Service\User;

use App\Events\CommentEvent;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentService
{
    public function index(int $postId): Collection
    {
        try {
            return Comment::with('likes', 'replies', 'user')
                ->where('post_id', $postId)
                ->whereNull('parent_id')
                ->orderByDesc('id')
                ->get();
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function store(int $postId, array $data): Comment
    {
        $userId = auth()->id();
        $commentData = [
            'post_id' => $postId,
            'user_id' => $userId,
            'content' => $data['content'],
            'parent_id' => $data['parent_id'] ?? null,
        ];
        $comment = Comment::create($commentData);
        broadcast(new CommentEvent($comment))->toOthers();
        return $comment;
    }

    public function update(array $data, int $id): bool
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->update([
                'content' => $data['content'],
            ]);
            broadcast(new CommentEvent($comment))->toOthers();
            return true;
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function destroy(int $id): bool
    {
        try {
            $comment = Comment::with('likes', 'replies')->findOrFail($id);
            $repliesId = $comment->replies()->get()->pluck('id')->toArray();
            DB::table('likes')->whereIn('comment_id', $repliesId)->delete();
            $comment->replies()->delete();
            $comment->likes()->detach();
            broadcast(new CommentEvent($comment))->toOthers();
            $comment->delete();
            return true;
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function findComment(int $id): Comment
    {
        try {
            return Comment::findOrFail($id);
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }
}
