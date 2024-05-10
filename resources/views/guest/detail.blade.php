@vite(['resources/js/app.js'])
@vite(['resources/js/detail.js'])
@extends('layouts.user.app')

@section('content')
    <div id="data" data-comment_action="{{ route('comments.index', ['postId' => $post->id]) }}"></div>
    <div class="detail-form" id="detail">
        <img class="detail-background" src="{{ Vite::asset('resources/images/image_main_home.png') }}">
        <img class="detail-background-mobile" src="{{ Vite::asset('resources/images/image_home_mobile.png') }}">
        <div class="detail-sidebar-mobile">
            <img id="btnShowSidebar" class="sidebar-icon" src="{{ Vite::asset('resources/images/icon-sidebar-mobile.png') }}"
                alt="">
        </div>
        <div class="detail-overlay-mobile" id="overlayMobile">
            <div class="detail-sidebar-mobile-box" id="sidebarMobile">
                <h3 class="detail-title-list top">{{ __('home.title_search_sidebar') }}</h3>
                <div class="detail-sidebar-mobile-item">
                    <p class="detail-title-list">{{ __('home.title_label_sidebar') }}</p>
                    <form action="">
                        <button class="detail-btn-search-mobile">
                            <img class="icon-search-mobile title"
                                src="{{ Vite::asset('resources/images/icon_search.png') }}" alt="">
                        </button>
                        <input class="detail-search-mobile blog" type="text" placeholder="Search blog title"
                            name="blog">
                    </form>
                    <p class="title-list">{{ __('home.categories_label_sidebar') }}</p>
                    <div class="detail-category-list-mobile">
                        <form action="{{ route('home') }}" method="GET" id="categoryFormMobile">
                            @foreach ($categories as $category)
                                <div class="detail-category-list-item">
                                    <input class="detail-category-box-mobile" type="checkbox" id="{{ $category->id }}"
                                        name="category[]"
                                        {{ in_array($category->id, request('category') ?? []) ? 'checked autofocus' : '' }}
                                        value="{{ $category->id }}">
                                    <label for="{{ $category->id }}"
                                        class="detail-category-name-mobile">{{ $category->name }}</label>
                                </div>
                            @endforeach
                        </form>
                    </div>
                    <p class="title-list">{{ __('home.author_search_sidebar') }}</p>
                    <form action="">
                        <button class="detail-btn-search-mobile">
                            <img class="icon-search-mobile author"
                                src="{{ Vite::asset('resources/images/icon_search.png') }}" alt="">
                        </button>
                        <input class="detail-search-mobile author" type="text" placeholder="Search author"
                            name="author">
                    </form>
                    <form class="detail-sidebar-btn" action="">
                        <p class="sidebar-btn-box close close-box">{{ __('home.btn_cancel_sidebar') }}</p>
                        <button class="sidebar-btn-box search">{{ __('home.btn_search_sidebar') }}</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="detail-content">
            <div class="detail-sidebar-desktop">
                <form action="">
                    <button class="detail-btn-search-desktop blog" type="submit">
                        <img class="icon-search blog" src="{{ Vite::asset('resources/images/icon_search.png') }}"
                            alt="">
                    </button>
                    <input type="text" class="detail-search-input blog" placeholder="Search blog" name="blog"
                        name="blog" value="{{ request('blog') }}" {{ request('blog') ? 'autofocus' : '' }}>
                </form>
                <p class="detail-content-navbar-topic">{{ __('home.categories_label_sidebar') }}</p>
                <div class="detail-category-list">
                    <form action="{{ route('home') }}" method="GET" id="categoryForm">
                        @foreach ($categories as $category)
                            <div class="detail-category-list-item">
                                <input class="category-box" type="checkbox" id="{{ $category->id }}" name="category[]"
                                    {{ in_array($category->id, request('category') ?? []) ? 'checked autofocus' : '' }}
                                    value="{{ $category->id }}">
                                <label for="{{ $category->id }}" class="category-name">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </form>
                </div>
                <p class="detail-content-navbar-topic">{{ __('home.author_search_sidebar') }}</p>
                <form action="" class="form-search-author">
                    <button class="detail-btn-search-desktop author" type="submit">
                        <img class="icon-search author" src="{{ Vite::asset('resources/images/icon_search.png') }}"
                            alt="">
                    </button>
                    <input type="text" class="detail-search-input author" placeholder="Search author" name="author"
                        value="{{ request('author') }}" {{ request('author') ? 'autofocus' : '' }}>
                </form>
            </div>

            <div class="detail-content-blog">
                <div class="detail-blog-list-form">
                    <div class="detail-blog-list">
                        <img class="detail-blog-list-image" src="{{ Storage::url($post->image) }}" alt="">
                        <div class="detail-blog-info">
                            <div class="detail-blog-list-info">
                                <div class="item-info">
                                    <img class="icon-info avatar"
                                        src="{{ Vite::asset('resources/images/icon_avatar_blog.png') }}" alt="">
                                    <p class="info-blog user-name">{{ $post->user->user_name }}</p>
                                </div>
                                <div class="item-info">
                                    <img class="icon-info clock"
                                        src="{{ Vite::asset('resources/images/icon_clock.png') }}" alt="">
                                    <p class="info-blog time-create">{{ $post->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                                <div class="item-info">
                                    <form id="likeForm" action="{{ route('users.post.like', ['post' => $post]) }}" 
                                        data-user="{{Auth::user()}}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" id="likeButton">
                                            <i id="heartIcon"
                                                class="fa-{{ Auth::check() &&
                                                Auth::user()->checkLikePost($post->id)
                                                    ? 'solid'
                                                    : 'regular' }} fa-heart"></i>
                                        </button>
                                        <p class="info-blog heart-create" id="likeCountPost">{{ $post->likes()->count() }}</p>
                                    </form>
                                </div>
                                <div class="item-info">
                                    <img class="icon-info comment"
                                        src="{{ Vite::asset('resources/images/icon_comment.png') }}" alt="">
                                    <p class="info-blog comment-create">{{ $post->comments()->count() }}</p>
                                </div>
                            </div>
                            @if (Gate::allows('manage-post', $post))
                                <div class="item-menu">
                                    <img class="icon-info menu" src="{{ Vite::asset('resources/images/menu_1.png') }}"
                                        alt="">
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-form">
                                            <a href="{{ route('users.post.edit', ['post' => $post]) }}">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                                <p>{{ __('home.text_btn_edit') }}</p>
                                            </a>
                                        </div>
                                        <div class="dropdown-menu-form" id="showBoxDelete">
                                            <i class="fa-solid fa-trash-can"></i>
                                            <p>{{ __('home.text_btn_delete') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="detail-blog-category">
                            @foreach ($post->categories as $category)
                                <p>{{ $category->name }}</p>
                            @endforeach
                        </div>
                        <div class="detail-blog-content">
                            <h2 class="detail-blog-title">{{ $post->title }}</h2>
                            <p class="detail-blog-description">{{ $post->content }}</p>
                        </div>
                        <div class="line"></div>

                        <div class="detail-related">
                            <p class="detail-related-title">{{ __('home.title_related') }}</p>
                            <div class="detail-related-list">
                                @foreach ($relatedPosts as $relatedPost)
                                    <div class="detail-related-item">
                                        <a href="{{ route('detail', ['post' => $relatedPost]) }}">
                                            <img src="{{ Storage::url($relatedPost->image) }}">
                                        </a>
                                        <p class="detail-related-item-created">
                                            {{ $relatedPost->created_at->format('Y-m-d') }}
                                        </p>
                                        <a href="{{ route('detail', ['post' => $relatedPost]) }}">
                                            <p class="detail-related-item-content">{!! nl2br(e(Str::limit($relatedPost->content, 30))) !!}</p>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="detail-related-mobile">
                            <p class="detail-related-title">{{ __('home.title_related') }}</p>
                            <div class="swiper mySwiper">
                                <div class="swiper-wrapper">
                                    @foreach ($relatedPosts as $relatedPost)
                                        <div class="swiper-slide">
                                            <div class="detail-related-list">
                                                <a href="{{ route('detail', ['post' => $relatedPost]) }}">
                                                    <img src="{{ Storage::url($relatedPost->image) }}">
                                                    <p class="detail-related-item-created">
                                                        {{ $relatedPost->created_at->format('Y-m-d') }}</p>
                                                    <p class="detail-related-item-content">
                                                        {!! nl2br(e(Str::limit($relatedPost->content, 30))) !!}
                                                    </p>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>

                        <div class="detail-comment">
                            <p class="detail-comment-title">{{ __('home.title_comment') }}</p>
                            @unless (!Auth::check())
                                <form class="detail-comment-input" 
                                    action="{{ route('comments.store', $post->id) }}" method="POST">
                                    <div class="detail-form-input">
                                        <img class="user-avatar"
                                            src="{{ Vite::asset('resources/images/image_home_mobile.png') }}"
                                            alt="">
                                        <input type="text" name="content" id="commentContent">
                                    </div>
                                    <button type="submit" class="comment-button" id="btnComment">{{ __('home.btn_send') }}</button>
                                </form>
                            @endunless

                            <div id="comments">
                                @include('user.post.comment')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (count($popularPosts) > 0)
                <div class="detail-popular-form">
                    <div class="detail-popular-post">
                        <p class="popular-post-user">{{ $popularPosts[0]->user->user_name }}</p>
                        <a href="{{ route('detail', ['post' => $popularPosts[0]]) }}">
                            <img class="popular-post-image" src="{{ Storage::url($popularPosts[0]->image) }}">
                        </a>
                        <a class="popular-post-content" href="{{ route('detail', ['post' => $popularPosts[0]]) }}">
                            {{ $popularPosts[0]->content }}
                        </a>
                        <div class="popular-post-category">
                            @foreach ($popularPosts[0]->categories as $category)
                                <p>{{ $category->name }}</p>
                            @endforeach
                        </div>
                        <p class="popular-post-related-head">{{ __('home.title_popular') }}</p>
                        @foreach ($popularPosts as $key => $popularPost)
                            @if ($key > 0)
                                <div class="popular-post-related-list">
                                    <img src="{{ Storage::url($popularPost->image) }}">
                                    <div class="post-info">
                                        <p class="post-created">{{ $popularPost->created_at->format('Y-m-d') }}</p>
                                        <a href="{{ route('detail', ['post' => $popularPost]) }}">
                                            <p class="post-content">{!! nl2br(e(Str::limit($popularPost->content, 200))) !!}</p>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        
        <div class="form-delete" id="formBox">
            <div class="box-delete">
                <i class="fa-solid fa-circle-xmark" id="closeBox"></i>
                <p class="question-delete">{{ __('home.text_delete') }}</p>
                <form class="btn-delete" action="{{ route('users.post.destroy', ['id' => $post->id]) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <div class="cancel-delete" id="cancelBox">{{ __('home.text_btn_cancel') }}</div>
                    <button class="accept-delete">{{ __('home.text_btn_delete') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
