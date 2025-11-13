<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Weiboo</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/fav.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/fontawesome-5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/unicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/metismenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/timepickers.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        .admin-panel-container {
            padding-top: 40px;
            padding-bottom: 60px;
        }
        .admin-sidebar {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            height: 100%;
        }
        .admin-sidebar .nav-link {
            color: #333;
            padding: 10px 15px;
            margin-bottom: 5px;
            border-radius: 5px;
        }
        .admin-sidebar .nav-link.active,
        .admin-sidebar .nav-link:hover {
            background: var(--color-primary);
            color: #fff;
        }
        .admin-content {
            padding-left: 30px;
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body class="home-one">
    <header class="header-one header--sticky">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-one-wrapper">
                        <div class="left-side">
                            <a href="{{ route('admin.dashboard') }}" class="logo">
                                <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
                                <strong>Admin Panel</strong>
                            </a>
                        </div>
                        <div class="right-side">
                            <ul class="nav-pills d-flex align-items-center" style="gap:12px;">
                                <li><a href="{{ route('home') }}" target="_blank"><i class="fas fa-globe"></i> View Site</a></li>
                                @auth
                                    <li class="text-muted" style="font-size:14px;">Hello, {{ auth()->user()->name }}</li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="rts-btn btn-sm btn-danger">Logout</button>
                                        </form>
                                    </li>
                                @else
                                    <li><a href="{{ route('login') }}" class="rts-btn btn-sm btn-primary">Login</a></li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container admin-panel-container">
        <div class="row">
            <div class="col-lg-3">
                <aside class="admin-sidebar">
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                            <i class="fas fa-tags"></i> Categories
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                            <i class="fas fa-box-open"></i> Products
                        </a>
                    </nav>
                </aside>
            </div>
            <div class="col-lg-9">
                <main class="admin-content">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/plugins/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
