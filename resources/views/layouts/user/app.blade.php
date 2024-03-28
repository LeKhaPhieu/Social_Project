<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    @vite(['resources/scss/main.scss'])
    @vite(['resources/js/home.js'])
</head>

<body>
    <header>
        <div class="header-form">
            <div class="header-navbar">
                <div class="header-navbar-right">
                    <img class="header-logo" src="{{ Vite::asset('resources/images/logo.png') }}">
                    <a href="" class="header-logo-name">RT-Blogs</a>
                </div>
                <div class="header-navbar-left">
                    <div class="header-custom-page">
                        <a class="header-btn-top" href="">Top</a>
                    </div>
                    <div class="header-user">
                        @if (!Auth::user())
                            <a class="header-btn login" href="{{ route('view.login') }}">Login</a>
                            <a class="header-btn register" href="{{ route('view.register') }}">Sign up</a>
                        @else
                            <a class="header-btn create" href="">Create</a>
                            <a class="header-user-name">{{ Auth::user()->user_name }}</a>
                            <img class="header-user-avatar" src="{{ Vite::asset('resources/images/user_avatar.png') }}">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button>Log out</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="header-mobile">
                <img class="header-navbar-mobile" src="{{ Vite::asset('resources/images/icon_header_mobile.png') }}"
                    alt="">
                <div class="header-logo-mobile">
                    <img class="header-logo-image" src="{{ Vite::asset('resources/images/logo.png') }}">
                    <a href="" class="header-logo-name">RT-Blogs</a>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <footer>
        <div class="footer-form">
            <p class="footer-content">Copyright © 2024. Made by Regit JSC. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
