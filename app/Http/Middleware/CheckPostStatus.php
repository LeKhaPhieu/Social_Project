<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPostStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $postId = $request->route('postId'); 
        $post = Post::find($postId);
        if ($post && $post->status === Post::NOT_APPROVED) {
            return redirect()->route('home')->with('error', '');
        }
        return $next($request);
    }
}
