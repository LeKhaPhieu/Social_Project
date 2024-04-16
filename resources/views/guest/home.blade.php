@extends('layouts.user.app')

@section('content')
    <div class="home-form">
        <img class="home-background" src="{{ Vite::asset('resources/images/image_main_home.png') }}">
        <img class="home-background-mobile" src="{{ Vite::asset('resources/images/image_home_mobile.png') }}">
        <div class="home-sidebar-mobile">
            <img id="btnShowSidebar" class="sidebar-icon" src="{{ Vite::asset('resources/images/icon-sidebar-mobile.png') }}"
                alt="">
        </div>
        <div class="overlay-mobile" id="overlayMobile">
            <div class="home-sidebar-mobile-box" id="sidebarMobile">
                <h3 class="title-list top">{{ __('home.title_search_sidebar') }}</h3>
                <div class="sidebar-mobile-item">
                    <p class="title-list">{{ __('home.title_label_sidebar') }}</p>
                    <form action="">
                        <button class="btn-search-mobile">
                            <img class="icon-search-mobile title"
                                src="{{ Vite::asset('resources/images/icon_search.png') }}" alt="">
                        </button>
                        <input class="search-mobile blog" type="text" placeholder="Search blog title" name="blog">
                    </form>
                    <p class="title-list">{{ __('home.categories_label_sidebar') }}</p>
                    <div class="category-list-mobile">
                        <form action="{{ route('home') }}" method="GET" id="categoryFormMobile">
                            @foreach ($categories as $category)
                                <div class="category-list-item">
                                    <input class="category-box-mobile" type="checkbox" id="{{ $category->id }}"
                                        name="category[]"
                                        {{ in_array($category->id, request('category') ?? []) ? 'checked autofocus' : '' }}
                                        value="{{ $category->id }}">
                                    <label for="{{ $category->id }}" class="category-name-mobile">{{ $category->name }}</label>
                                </div>
                            @endforeach
                        </form>
                    </div>
                    <p class="title-list">{{ __('home.author_search_sidebar') }}</p>
                    <form action="">
                        <button class="btn-search-mobile">
                            <img class="icon-search-mobile author"
                                src="{{ Vite::asset('resources/images/icon_search.png') }}" alt="">
                        </button>
                        <input class="search-mobile author" type="text" placeholder="Search author" name="author">
                    </form>
                    <form class="sidebar-btn" action="">
                        <p class="sidebar-btn-box close close-box">{{ __('home.btn_cancel_sidebar') }}</p>
                        <button class="sidebar-btn-box search">{{ __('home.btn_search_sidebar') }}</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="home-content">
            <div class="home-sidebar-desktop">
                <form action="">
                    <button class="btn-search-desktop blog" type="submit">
                        <img class="icon-search blog" src="{{ Vite::asset('resources/images/icon_search.png') }}"
                            alt="">
                    </button>
                    <input type="text" class="search-input blog" placeholder="Search blog" name="blog" name="blog"
                        value="{{ request('blog') }}" {{ request('blog') ? 'autofocus' : '' }}>
                </form>
                <p class="home-content-navbar-topic">{{ __('home.categories_label_sidebar') }}</p>
                <div class="category-list">
                    <form action="{{ route('home') }}" method="GET" id="categoryForm">
                        @foreach ($categories as $category)
                            <div class="category-list-item">
                                <input class="category-box" type="checkbox" id="{{ $category->id }}" name="category[]"
                                    {{ in_array($category->id, request('category') ?? []) ? 'checked autofocus' : '' }}
                                    value="{{ $category->id }}">
                                <label for="{{ $category->id }}" class="category-name">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </form>
                </div>
                <p class="home-content-navbar-topic">{{ __('home.author_search_sidebar') }}</p>
                <form action="">
                    <button class="btn-search-desktop author" type="submit">
                        <img class="icon-search author" src="{{ Vite::asset('resources/images/icon_search.png') }}"
                            alt="">
                    </button>
                    <input type="text" class="search-input author" placeholder="Search author" name="author"
                        value="{{ request('author') }}" {{ request('author') ? 'autofocus' : '' }}>
                </form>
            </div>

            <div class="home-content-blog">
                <div class="home-blog-list-form">
                    @foreach ($posts as $post)
                        <div class="home-blog-list">
                            <a href="">
                                <img class="home-blog-list-image" src="{{ Storage::url($post->image) }}" alt="">
                            </a>
                            <div class="home-blog-list-info">
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
                                    <img class="icon-info heart"
                                        src="{{ Vite::asset('resources/images/icon_heart.png') }}" alt="">
                                    <p class="info-blog heart-create">{{ $post->likes()->count() }}</p>
                                </div>
                                <div class="item-info">
                                    <img class="icon-info comment"
                                        src="{{ Vite::asset('resources/images/icon_comment.png') }}" alt="">
                                    <p class="info-blog comment-create">{{ $post->comments()->count() }}</p>
                                </div>
                            </div>
                            <div class="blog-content">
                                <h2 class="blog-title">{{ $post->title }}</h2>
                                <p class="blog-description">{!! nl2br(e(Str::limit($post->content, 180))) !!}</p>
                            </div>
                            <a class="text-detail" href="{{ route('detail', ['post' => $post]) }}">
                                {{ __('auth.text_button_detail') }}
                                <i class="fa-solid fa-arrow-right-long"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
                @include('layouts.components.pagination')
            </div>
        </div>
    </div>
@endsection
