<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ Vite::asset('resources/images/logo.png') }}"/>
    <title>Token verify account</title>
    @vite(['resources/scss/main.scss'])
</head>

<body>
    <div class="auth-main token">
        <form class="auth-form token" action="{{ route('resend.token')}}" method="POST">
            @csrf
            <div class="auth-head">
                <img class="auth-head-image" src="{{ Vite::asset('resources/images/logo.png') }}" alt="">
                <p class="auth-head-name">RT-Blogs</p>
            </div>
            <div class="auth-body">
                <p class="auth-body-title">Authentication email</p>
                <div class="auth-body-item">
                    <p>Email<span>*</span></p>
                    <input type="email" name="email">
                    @error('email')
                        <p class="notify-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            @if (session('error'))
                <span class='notify-error'>{{ session('error') }}</span>
            @endif
            <div class="auth-tail">
                <button class="btn-submit">{{ __('auth.text_btn_token') }}</button>
            </div>
        </form>
    </div>
</body>

</html>
