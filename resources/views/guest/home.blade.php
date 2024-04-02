@extends('layouts.user.app')

@section('content')
    <div class="home-form">
        <img class="home-background" src="{{ Vite::asset('resources/images/image_main_home.png') }}">
        <img class="home-background-mobile" src="{{ Vite::asset('resources/images/image_home_mobile.png') }}">
        <div class="home-sidebar-mobile">
            <img id="btnShowSidebar" class="sidebar-icon" src="{{ Vite::asset('resources/images/icon-sidebar-mobile.png') }}" alt="">
        </div>
        <div class="overlay-mobile" id="overlayMobile">
            <div class="home-sidebar-mobile-box" id="sidebarMobile">
                <h3 class="title-list top">Search Blogs</h3>
                <form class="sidebar-mobile-item" action="">
                    <p class="title-list">Title</p>
                    <img class="icon-search-mobile title" src="{{ Vite::asset('resources/images/icon_search.png') }}" alt="">
                    <input class="search-mobile blog" type="text" placeholder="Search blog title">
                    <p class="title-list">Categories</p>
                    <div class="category-list-mobile">
                        <div class="category-list-item">
                            <input class="category-box-mobile" type="checkbox">
                            <span class="category-name-mobile" href="">Kinh tế</span>
                        </div>
                        <div class="category-list-item">
                            <input class="category-box-mobile" type="checkbox">
                            <span class="category-name-mobile" href="">Khoa học</span>
                        </div>
                        <div class="category-list-item">
                            <input class="category-box-mobile" type="checkbox">
                            <span class="category-name-mobile" href="">Chính trị</span>
                        </div>
                        <div class="category-list-item">
                            <input class="category-box-mobile" type="checkbox">
                            <span class="category-name-mobile" href="">Xã hội</span>
                        </div>
                    </div>
                    <p class="title-list">Author</p>
                    <img class="icon-search-mobile author" src="{{ Vite::asset('resources/images/icon_search.png') }}" alt="">
                    <input class="search-mobile author" type="text" placeholder="Search author">
                    <div class="sidebar-btn">
                        <button class="sidebar-btn-box close close-box">Cancel</button>
                        <button class="sidebar-btn-box search">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="home-content">
            <form class="home-sidebar-desktop" action="">
                <img class="icon-search blog" src="{{ Vite::asset('resources/images/icon_search.png') }}" alt="">
                <input type="text" class="search-input blog" placeholder="Search blog">
                <p class="home-content-navbar-topic">Categories</p>
                <div class="category-list">
                    <div class="category-list-item">
                        <input class="category-box" type="checkbox">
                        <span class="category-name" href="">Kinh tế</span>
                    </div>
                    <div class="category-list-item">
                        <input class="category-box" type="checkbox">
                        <span class="category-name" href="">Khoa học</span>
                    </div>
                    <div class="category-list-item">
                        <input class="category-box" type="checkbox">
                        <span class="category-name" href="">Chính trị</span>
                    </div>
                    <div class="category-list-item">
                        <input class="category-box" type="checkbox">
                        <span class="category-name" href="">Xã hội</span>
                    </div>
                </div>
                <p class="home-content-navbar-topic">Author</p>
                <img class="icon-search author" src="{{ Vite::asset('resources/images/icon_search.png') }}" alt="">
                <input type="text" class="search-input author" placeholder="Search author">
            </form>

            <div class="home-content-blog">
                <div class="home-blog-list-form">
                    <div class="home-blog-list">
                        <img class="home-blog-list-image" src="{{ Vite::asset('resources/images/image-blog.png') }}" alt="">
                        <div class="home-blog-list-info">
                            <div class="item-info">
                                <img class="icon-info avatar" src="{{ Vite::asset('resources/images/icon_avatar_blog.png') }}" alt="">
                                <p class="info-blog user-name">Jimmy Nguyen</p>
                            </div>
                            <div class="item-info">
                                <img class="icon-info clock" src="{{ Vite::asset('resources/images/icon_clock.png') }}" alt="">
                                <p class="info-blog time-create">2024.2.29 12:00</p>
                            </div>
                            <div class="item-info">
                                <img class="icon-info heart" src="{{ Vite::asset('resources/images/icon_heart.png') }}" alt="">
                                <p class="info-blog heart-create">2</p>
                            </div>
                            <div class="item-info">
                                <img class="icon-info comment" src="{{ Vite::asset('resources/images/icon_comment.png') }}" alt="">
                                <p class="info-blog comment-create">4</p>
                            </div>
                        </div>
                        <div class="blog-content">
                            <h2 class="blog-title">Lorem ipsum dolor sit am et</h2>
                            <p class="blog-description">Lorem ipsum dolor sit am et, consectetur
                                ipsum li num amataki hulanjfh bf ueodap fief hief Lorem
                                ipsum dolor sit am et, consectetur ipsum li num amataki
                                hulanjfh bf ueodap li num amataki hulanjfh bf ueodap...</p>
                        </div>
                        <a class="text-detail" href="">
                            {{ __('auth.text_button_detail') }}
                            <img src="{{ Vite::asset('resources/images/icon_detail.png') }}" alt="">
                        </a>
                    </div>

                    <div class="home-blog-list">
                        <img class="home-blog-list-image" src="{{ Vite::asset('resources/images/image-blog.png') }}" alt="">
                        <div class="home-blog-list-info">
                            <div class="item-info">
                                <img class="icon-info avatar" src="{{ Vite::asset('resources/images/icon_avatar_blog.png') }}" alt="">
                                <p class="info-blog user-name">Jimmy Nguyen</p>
                            </div>
                            <div class="item-info">
                                <img class="icon-info clock" src="{{ Vite::asset('resources/images/icon_clock.png') }}" alt="">
                                <p class="info-blog time-create">2024.2.29 12:00</p>
                            </div>
                            <div class="item-info">
                                <img class="icon-info heart" src="{{ Vite::asset('resources/images/icon_heart.png') }}" alt="">
                                <p class="info-blog heart-create">2</p>
                            </div>
                            <div class="item-info">
                                <img class="icon-info comment" src="{{ Vite::asset('resources/images/icon_comment.png') }}" alt="">
                                <p class="info-blog comment-create">4</p>
                            </div>
                        </div>
                        <div class="blog-content">
                            <h2 class="blog-title">Lorem ipsum dolor sit am et</h2>
                            <p class="blog-description">Lorem ipsum dolor sit am et, consectetur
                                ipsum li num amataki hulanjfh bf ueodap fief hief Lorem
                                ipsum dolor sit am et, consectetur ipsum li num amataki
                                hulanjfh bf ueodap li num amataki hulanjfh bf ueodap...</p>
                        </div>
                        <a class="text-detail" href="">
                            {{ __('auth.text_button_detail') }}
                            <img src="{{ Vite::asset('resources/images/icon_detail.png') }}" alt="">
                        </a>
                    </div>

                    <div class="home-blog-list">
                        <img class="home-blog-list-image" src="{{ Vite::asset('resources/images/image-blog.png') }}" alt="">
                        <div class="home-blog-list-info">
                            <div class="item-info">
                                <img class="icon-info avatar" src="{{ Vite::asset('resources/images/icon_avatar_blog.png') }}" alt="">
                                <p class="info-blog user-name">Jimmy Nguyen</p>
                            </div>
                            <div class="item-info">
                                <img class="icon-info clock" src="{{ Vite::asset('resources/images/icon_clock.png') }}" alt="">
                                <p class="info-blog time-create">2024.2.29 12:00</p>
                            </div>
                            <div class="item-info">
                                <img class="icon-info heart" src="{{ Vite::asset('resources/images/icon_heart.png') }}" alt="">
                                <p class="info-blog heart-create">2</p>
                            </div>
                            <div class="item-info">
                                <img class="icon-info comment" src="{{ Vite::asset('resources/images/icon_comment.png') }}" alt="">
                                <p class="info-blog comment-create">4</p>
                            </div>
                        </div>
                        <div class="blog-content">
                            <h2 class="blog-title">Lorem ipsum dolor sit am et</h2>
                            <p class="blog-description">Lorem ipsum dolor sit am et, consectetur
                                ipsum li num amataki hulanjfh bf ueodap fief hief Lorem
                                ipsum dolor sit am et, consectetur ipsum li num amataki
                                hulanjfh bf ueodap li num amataki hulanjfh bf ueodap...</p>
                        </div>
                        <a class="text-detail" href="">
                            {{ __('auth.text_button_detail') }}
                            <img src="{{ Vite::asset('resources/images/icon_detail.png') }}" alt="">
                        </a>
                    </div>

                    <div class="home-move-tag">
                        <img class="move-left" src="{{ Vite::asset('resources/images/icon_arrow_move_left.png') }}" alt="">
                        <a class="page-number" href="">1</a>
                        <a class="page-number" href="">2</a>
                        <a class="page-number active" href="">3</a>
                        <a class="page-number" href="">4</a>
                        <a class="page-number" href="">5</a>
                        <a class="page-number" href="">6</a>
                        <img class="move-right" src="{{ Vite::asset('resources/images/icon_arrow_move_right.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
