<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    @vite(['resources/scss/main.scss'])
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
                <p class="auth-body-title">Sign up</p>
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
                            <input type="checkbox" name="gender" value="0">
                            <span>Male</span>
                        </div>
                        <div class="gender-item">
                            <input type="checkbox" name="gender" value="1">
                            <span>Female</span>
                        </div>
                        <div class="gender-item">
                            <input type="checkbox" name="gender" value="2">
                            <span>Other</span>
                        </div>
                    </div>
                    @error('gender')
                        <p class="notify-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="auth-tail">
                <button class="btn-submit">Sign up</button>
                <a class="link-sign-in" href="{{ route('view.login') }}">Already have an account? Login</a>
            </div>
        </form>
    </div>
</body>

</html>
