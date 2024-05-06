@foreach ($comments as $comment)
    <div class="detail-comment-show">
        <div class="user-info">
            <img class="user-avatar" src="{{ Storage::url($comment->user->avatar) }}" alt="">
            <p class="user-name">{{ $comment->user->user_name }}</p>
        </div>
        <div class="detail-comment-first">
            <p class="comment-content">{{ $comment->content }}</p>
            <div class="comment-content-react">
                <p class="comment-content-created">
                    {{ $comment->created_at->diffForHumans() }}
                </p>
                <form id="likeFormComment{{ $comment->id }}" data-user="{{Auth::user()}}"
                    action="{{ route('users.comment.like', ['id' => $comment]) }}" method="POST">
                    @csrf
                    <button class="btn-like-comment" type="submit" id="likeCommentButton{{ $comment->id }}">
                        <i id="heartIconComment{{ $comment->id }}"
                            class="fa-{{ Auth::check() && Auth::user()->checkLikeComment($comment->id) 
                            ? 'solid' 
                            : 'regular' }} fa-heart"></i>
                    </button>
                    <label class="total-comment-like"
                        id="totalCommentLike{{ $comment->id }}">{{ $comment->likes()->count() }}</label>
                </form>
                <i class="fa-solid fa-reply show-input-reply-comment" data-comment-id="{{ $comment->id }}" 
                    data-user="{{Auth::user()}}"></i>
                <label id="totalCommentReply{{ $comment->id }}">{{ $comment->replies()->count() }}</label>
                @if (Gate::allows('manage-comment', $comment))
                    <i class="fa-regular fa-pen-to-square btn-show-edit-comment"
                        data-comment-id="{{ $comment->id }}"></i>
                    <button><i class="fa-solid fa-trash-can btn-show-delete-comment"
                            data-comment-id="{{ $comment->id }}"></i></button>
                @endif
            </div>
            @unless (!Auth::check())
                <form class="form-reply-comment form-reply{{ $comment->id }}" data-id="{{ $comment->id }}"
                    action="{{ route('comments.store', $comment->post_id) }}" method="POST">
                    @csrf
                    <input class="detail-input-reply commentContentReply" type="text" name="content"
                        id="commentContentReply{{ $comment->post_id }}">
                    <button type="submit" class="btn-send-comment-reply"
                        data-parent-id="{{ $comment->id }}">{{ __('home.btn_send') }}</button>
                </form>
            @endunless
        </div>

        <div class="form-delete update-comment" id="boxEditComment{{ $comment->id }}">
            <div class="box-delete update-comment">
                <i class="fa-solid fa-circle-xmark" id="closeBoxEdit{{ $comment->id }}"></i>
                <p class="question-delete update-comment">{{ __('home.title_update_comment') }}</p>
                <form class="btn-delete update-comment" action="{{ route('comments.update', $comment->id) }}"
                    method="POST">
                    @method('PUT')
                    @csrf
                    <input type="text" value="{{ $comment->content }}" name="content">
                    <div class="btn-update-comment">
                        <button class="accept-delete update-comment">{{ __('home.btn_update') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="form-delete" id="boxDeleteComment{{ $comment->id }}">
            <div class="box-delete">
                <i class="fa-solid fa-circle-xmark" id="closeBoxDelete{{ $comment->id }}"></i>
                <p class="question-delete">{{ __('home.text_delete_comment') }}</p>
                <form class="btn-delete-comment" action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                    @method('DELETE')
                    <button class="accept-delete" type="submit">{{ __('home.text_btn_delete') }}</button>
                </form>
            </div>
        </div>
    </div>

    @foreach ($comment->replies as $reply)
        <div class="detail-comment-reply">
            <div class="user-info">
                <img class="user-avatar" src="{{ Storage::url($reply->user->avatar) }}"
                    alt="">
                <p class="user-name"> {{ $reply->user->user_name }}</p>
            </div>
            <div class="detail-comment-first">
                <p class="comment-content"> {{ $reply->content }}</p>
                <div class="comment-content-react">
                    <p class="comment-content-created">{{ $reply->created_at->diffForHumans() }}</p>
                    <form id="likeFormComment{{ $reply->id }}" data-user="{{Auth::user()}}"
                        action="{{ route('users.comment.like', ['id' => $reply]) }}" method="POST">
                        @csrf
                        <button class="btn-like-comment" type="submit" id="likeCommentButton{{ $reply->id }}">
                            <i id="heartIconComment{{ $reply->id }}"
                                class="fa-{{ Auth::check() && Auth::user()->checkLikeComment($reply->id) ? 'solid' : 'regular' }} fa-heart"></i>
                        </button>
                        <label class="total-comment-like"
                            id="totalCommentLike{{ $reply->id }}">{{ $reply->likes()->count() }}</label>
                    </form>
                    @if (Gate::allows('manage-comment', $reply))
                        <i class="fa-regular fa-pen-to-square btn-show-edit-comment"
                            data-comment-id="{{ $reply->id }}"></i>
                        <button><i class="fa-solid fa-trash-can btn-show-delete-comment"
                                data-comment-id="{{ $reply->id }}"></i></button>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-delete update-comment" id="boxEditComment{{ $reply->id }}">
            <div class="box-delete update-comment">
                <i class="fa-solid fa-circle-xmark" id="closeBoxEdit{{ $reply->id }}"></i>
                <p class="question-delete update-comment">{{ __('home.title_update_comment') }}</p>
                <form class="btn-delete update-comment" action="{{ route('comments.update', $reply->id) }}"
                    method="POST">
                    @method('PUT')
                    @csrf
                    <input type="text" value="{{ $reply->content }}" name="content">
                    <div class="btn-update-comment">
                        <button class="accept-delete update-comment">{{ __('home.btn_update') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="form-delete" id="boxDeleteComment{{ $reply->id }}">
            <div class="box-delete">
                <i class="fa-solid fa-circle-xmark" id="closeBoxDelete{{ $reply->id }}"></i>
                <p class="question-delete">{{ __('home.text_delete_comment') }}</p>
                <form class="btn-delete-comment" action="{{ route('comments.destroy', $reply->id) }}" method="POST">
                    @method('DELETE')
                    <button class="accept-delete" type="submit">{{ __('home.text_btn_delete') }}</button>
                </form>
            </div>
        </div>
    @endforeach
@endforeach
