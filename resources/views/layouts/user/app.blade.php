<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ Vite::asset('resources/images/logo.png') }}" />
    <title>Home page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.unpkg.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.unpkg.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @vite(['resources/js/app.js'])
    @vite(['resources/scss/main.scss'])
    @vite(['resources/js/header.js'])
    @vite(['resources/js/home.js'])
</head>

<body>
    <header>
        <div class="header-form">
            <div class="header-navbar">
                <div class="header-navbar-right">
                    <img class="header-logo" src="{{ Vite::asset('resources/images/logo.png') }}">
                    <a href="{{ route('home') }}" class="header-logo-name">{{ __('home.logo_name') }}</a>
                </div>
                <div class="header-navbar-left">
                    <div class="header-custom-page">
                        <a class="header-btn-top" href="{{ route('home') }}">{{ __('home.text_btn_top') }}</a>
                    </div>
                    @if (!Auth::user())
                        <div class="header-auth">
                            <a class="header-btn login" href="{{ route('login') }}">{{ __('home.text_btn_login') }}</a>
                            <a class="header-btn register"
                                href="{{ route('register') }}">{{ __('home.text_btn_register') }}</a>
                        </div>
                    @else
                        <div class="header-user">
                            <a class="header-btn create"
                                href="{{ route('users.post.create') }}">{{ __('home.text_btn_create') }}</a>
                            <div class="dropdown">
                                <a class="header-user-name">{{ Auth::user()->user_name }}</a>
                                @if(Auth::user()->avatar)
                                    <img class="header-user-avatar" src="{{ Storage::url(Auth::user()->avatar) }}">
                                @else
                                    <img class="header-user-avatar" src="{{ Vite::asset('resources/images/user_avatar.jpg') }}">
                                @endif
                                <div class="dropdown-content">
                                    <div class="connect-menu"></div>
                                    <a href="{{ route('user.profile') }}">{{ __('home.text_btn_my_profile') }}</a>
                                    <a
                                        href="{{ route('passwords.edit') }}">{{ __('home.text_btn_change_password') }}</a>
                                    <a
                                        href="{{ route('my.blog')}}">My blogs</a>
                                    @if (Auth::user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}">{{ __('admin.title_sidebar') }}</a>
                                    @endif
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button>{{ __('home.text_btn_logout') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="header-mobile">
                <img class="header-navbar-mobile" src="{{ Vite::asset('resources/images/icon_header_mobile.png') }}"
                    alt="">
                <div class="dropdown-menu-user">
                    @if (!Auth::user())
                        <a class="dropdown-item login" href="{{ route('login') }}">{{ __('home.text_btn_login') }}</a>
                        <a class="dropdown-item sign-up"
                            href="{{ route('register') }}">{{ __('home.text_btn_register') }}</a>
                    @else
                        <a class="dropdown-item profile"
                            href="{{ route('user.profile') }}">{{ __('home.text_btn_my_profile') }}</a>
                        <a class="dropdown-item password-edit"
                            href="{{ route('passwords.edit') }}">{{ __('home.text_btn_change_password') }}</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button>{{ __('home.text_btn_logout') }}</button>
                        </form>
                    @endif
                </div>
                <div class="header-logo-mobile">
                    <img class="header-logo-image" src="{{ Vite::asset('resources/images/logo.png') }}">
                    <a href="{{ route('home') }}" class="header-logo-name">{{ __('home.logo_name') }}</a>
                </div>
            </div>
        </div>
    </header>
    <div class="notification">
        @include('layouts.components.notification')
    </div>

    @yield('content')

    <footer>
        <div class="footer-form">
            <p class="footer-content">{{ __('home.text_footer') }}</p>
        </div>
    </footer>
</body>

</html>
