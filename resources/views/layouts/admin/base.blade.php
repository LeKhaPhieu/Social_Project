<!DOCTYPE html>

<head>
    <title>{{ __('admin.title_admin_home') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords"
        content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/admin/css/bootstrap.min.css')}} ">
    <link href="{{ Vite::asset('resources/admin/css/style.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ Vite::asset('resources/admin/css/style-responsive.css') }}" rel="stylesheet" />
    <link
        href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{Vite::asset('resources/admin/css/font.css')}}" type="text/css" />
    <link href="{{ Vite::asset('resources/admin/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{Vite::asset('resources/admin/css/morris.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{Vite::asset('resources/admin/css/monthly.css')}}">
    <script src="{{ Vite::asset('resources/admin/js/jquery2.0.3.min.js')}}"></script>
    <script src="{{ Vite::asset('resources/admin/js/raphael-min.js')}}"></script>
    <script src="{{ Vite::asset('resources/admin/js/morris.js')}}"></script>
    @vite(['resources/scss/main.scss'])
    @vite(['resources/js/admin.js'])
</head>

<body>
    <section id="container">
        <header class="header fixed-top clearfix">
            <div class="brand">
                <a href="#" class="logo">
                    {{ __('admin.title_sidebar') }}
                </a>
                <div class="sidebar-toggle-box">
                    <div class="fa fa-bars"></div>
                </div>
            </div>
            <div class="top-nav clearfix">
                <ul class="nav pull-right top-menu">
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="" src="{{ Vite::asset('resources/admin/images/logo.png') }}">
                            <span class="username">{{ __('admin.title_sidebar') }}</span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <li><a href="{{ route('user.profile')}}"><i class=" fa fa-suitcase"></i>{{ __('admin.text_btn_profile') }}</a></li>
                            <li><a href="{{ route('home')}}"><i class="fa fa-cog"></i>{{ __('admin.text_btn_user') }}</a></li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn-logout" type="submit"><i class="fa fa-key icon-btn-logout"></i>{{ __('admin.text_btn_logout') }}</button>
                            </form>
                        </ul>
                    </li>
                </ul>
            </div>
        </header>

        <aside>
            <div id="sidebar" class="nav-collapse">
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a class="active" href="{{ route('admin.dashboard') }}">
                                <i class="fa fa-dashboard"></i>
                                <span>{{ __('admin.dashboard') }}</span>
                            </a>
                        </li>

                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-tasks"></i>
                                <span>{{ __('admin.categories') }}</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{{ route('categories.create') }}">{{ __('admin.title_create_category') }}</a></li>
                                <li><a href="{{ route('categories.index') }}">{{ __('admin.title_list_category') }}</a></li>
                            </ul>
                        </li>

                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span>{{ __('admin.posts') }}</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{{ route('posts.index') }}">{{ __('admin.title_list_post') }}</a></li>
                            </ul>
                        </li>

                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-users"></i>
                                <span>{{ __('admin.users') }}</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{{ route('users.index') }}">{{ __('admin.title_list_user') }}</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

        <section id="main-content">
            <section class="wrapper">
                @yield('admin_content')
            </section>
        </section>
    </section>
    <script src="{{ Vite::asset('resources/admin/js/bootstrap.js') }}"></script>
    <script src="{{ Vite::asset('resources/admin/js/jquery.dcjqaccordion.2.7.js') }}"></script>
    <script src="{{ Vite::asset('resources/admin/js/scripts.js') }}"></script>
    <script src="{{ Vite::asset('resources/admin/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ Vite::asset('resources/admin/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ Vite::asset('resources/admin/js/jquery.scrollTo.js') }}"></script>
</body>

</html>
