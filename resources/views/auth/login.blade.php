<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ Vite::asset('resources/images/logo.png') }}"/>
    <title>Sign in</title>
    @vite(['resources/scss/main.scss'])
</head>

<body>
    <div class="auth-main">
        <form class="auth-form" action="{{ route('post.login') }}" method="POST">
            @csrf
            <div class="auth-head">
                <img class="auth-head-image" src="{{ Vite::asset('resources/images/logo.png') }}" alt="">
                <p class="auth-head-name">RT-Blogs</p>
            </div>
            <div class="auth-body">
                <p class="auth-body-title">{{ __('auth.login_title') }}</p>
                <div class="auth-body-item">
                    <p>Username or email<span>*</span></p>
                    <input type="text" name="email_or_username">
                    @error('email_or_username')
                        <p class="notify-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="auth-body-item">
                    <p>Password<span>*</span></p>
                    <input type="password" name="password">
                    @error('password')
                        <p class="notify-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="auth-body-item">
                    <div class="remember-form">
                        <div class="remember-item">
                            <input type="checkbox" name="remember">
                            <span>{{ __('auth.text_remember_password') }}</span>
                        </div>
                        <a class="link-forgot" href="{{ route('forgot.password') }}">{{ __('auth.text_link_forgot') }}</a>
                    </div>
                </div>
            </div>
            @if (session('success'))
                <span class='notify-success'>{{ session('success') }}</span>
            @endif
            @if (session('error'))
                <span class='notify-error'>{{ session('error') }}</span>
            @endif
            <div class="auth-tail">
                <button class="btn-submit">{{ __('auth.text_btn_login') }}</button>
                <a class="link-sign-in" href="{{ route('register') }}">{{ __('auth.text_link_register') }}</a>
            </div>
        </form>
    </div>
</body>

</html>
