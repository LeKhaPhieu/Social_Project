<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ Vite::asset('resources/images/logo.png') }}" />
    <title>Change password</title>
    @vite(['resources/scss/main.scss'])
</head>

<body>
    <div class="auth-main">
        <form class="auth-form" action="{{ route('passwords.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="auth-head">
                <img class="auth-head-image" src="{{ Vite::asset('resources/images/logo.png') }}" alt="">
                <p class="auth-head-name">RT-Blogs</p>
            </div>
            <div class="auth-body">
                <p class="auth-body-title">{{ __('auth.login_title') }}</p>
                <div class="auth-body-item">
                    <p>Password current<span>*</span></p>
                    <input type="password" name="password_current">
                    @error('password_current')
                        <p class="notify-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="auth-body-item">
                    <p>Password new<span>*</span></p>
                    <input type="password" name="password">
                    @error('password')
                        <p class="notify-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="auth-body-item">
                    <p>Password new confirm<span>*</span></p>
                    <input type="password" name="password_confirmation">
                </div>
            </div>
            @if (session('success'))
                <span class='notify-success'>{{ session('success') }}</span>
            @endif
            @if (session('error'))
                <span class='notify-error'>{{ session('error') }}</span>
            @endif
            <div class="auth-tail">
                <button class="btn-submit">{{ __('auth.text_btn_change_pass') }}</button>
            </div>
        </form>
    </div>
</body>

</html>
