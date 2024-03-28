<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    @vite(['resources/scss/main.scss'])
    @vite(['resources/js/auth.js'])
</head>

<body>
    <div class="auth-main">
        <form class="auth-form" action="{{ route('post.register') }}" method="POST">
            @csrf
            <div class="auth-head">
                <img class="auth-head-image" src="{{ Vite::asset('resources/images/logo.png') }}" alt="">
                <p class="auth-head-name">RT-Blogs</p>
            </div>
            <div class="auth-body">
                <p class="auth-body-title">{{ __('auth.register_title') }}</p>
                <div class="auth-body-item">
                    <p>Username<span>*</span></p>
                    <input type="text" name="user_name">
                    @error('user_name')
                        <p class="notify-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="auth-body-item">
                    <p>Email<span>*</span></p>
                    <input type="email" name="email">
                    @error('email')
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
                    <p>Password confirm<span>*</span></p>
                    <input type="password" name="password_confirmation">
                    @error('password_confirmation')
                        <p class="notify-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="auth-body-item">
                    <p>Tel<span>*</span></p>
                    <input type="number" name="phone_number">
                    @error('phone_number')
                        <p class="notify-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="auth-body-item">
                    <p>Gender<span>*</span></p>
                    <div class="gender-from">
                        <div class="gender-item">
                            <input class="gender-choose" type="checkbox" name="gender" value="0">
                            <span>Male</span>
                        </div>
                        <div class="gender-item">
                            <input class="gender-choose" type="checkbox" name="gender" value="1">
                            <span>Female</span>
                        </div>
                        <div class="gender-item">
                            <input class="gender-choose" type="checkbox" name="gender" value="2">
                            <span>Other</span>
                        </div>
                    </div>
                    @error('gender')
                        <p class="notify-error">{{ $message }}</p>
                    @enderror
                    @if (session('error'))
                        <span class='notify-error'>{{ session('error') }}</span>
                    @endif
                </div>
            </div>
            <div class="auth-tail">
                <button class="btn-submit">{{ __('auth.text_btn_register') }}</button>
                <a class="link-sign-in" href="{{ route('view.login') }}">{{ __('auth.text_link_login') }}</a>
            </div>
        </form>
    </div>
</body>

</html>
