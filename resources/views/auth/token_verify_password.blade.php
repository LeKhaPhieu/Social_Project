<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ Vite::asset('resources/images/logo.png') }}" />
    <title>Sign in</title>
    @vite(['resources/scss/main.scss'])
</head>

<body>
    <div class="auth-main">
        <form class="auth-form" action="{{ route('post.token.password') }}" method="POST">
            @csrf
            <div class="auth-head">
                <img class="auth-head-image" src="{{ Vite::asset('resources/images/logo.png') }}" alt="">
                <p class="auth-head-name">RT-Blogs</p>
            </div>
            <div class="auth-body">
                <p class="auth-body-title">{{ __('auth.title_token_forgot_password') }}</p>
                <div class="auth-body-item">
                    <p>Token<span>*</span></p>
                    <input type="number" name="token_reset_password">
                    @error('token_reset_password')
                        <p class="notify-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            @if (session('success'))
                <span class='notify-success'>{{ session('success') }}</span>
            @endif
            @if (session('error'))
                <span class='notify-error'>{{ session('error') }}</span>
            @endif
            <div class="auth-tail">
                <button class="btn-submit">{{ __('auth.text_btn_forgot') }}</button>
            </div>
        </form>
    </div>
</body>

</html>
