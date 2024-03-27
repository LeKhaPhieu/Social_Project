<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    @vite(['resources/scss/main.scss'])
</head>

<body>
    <div class="auth-main">
        <form class="auth-form">
            <div class="auth-head">
                <img class="auth-head-image" src="{{ Vite::asset('resources/images/logo.png') }}" alt="">
                <p class="auth-head-name">RT-Blogs</p>
            </div>
            <div class="auth-body">
                <p class="auth-body-title">Sign in</p>
                <div class="auth-body-item">
                    <p>Email<span>*</span></p>
                    <input type="email">
                </div>
                <div class="auth-body-item">
                    <p>Password<span>*</span></p>
                    <input type="password">
                </div>
                <div class="auth-body-item">
                    <div class="remember-form">
                        <div class="remember-item">
                            <input type="checkbox">
                            <span>Remember password</span>
                        </div>
                        <a class="link-forgot" href="{{ route('view.token.form') }}">Forgot your password?</a>
                    </div>
                </div>
            </div>
            <div class="auth-tail">
                <button class="btn-submit">Login</button>
                <a class="link-sign-in" href="{{ route('view.register') }}">Don't have an account? Sign up here</a>
            </div>
        </form>
    </div>
</body>

</html>
