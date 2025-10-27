<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'سامانه تیکتینگ' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">


    <style>
        @font-face {
            font-family: 'Vazir';
            src: url('{{ asset('fonts/vazir/Vazir-FD-WOL.woff2') }}') format('woff2'),
                url('{{ asset('fonts/vazir/Vazir-FD-WOL.woff') }}') format('woff'),
                url('{{ asset('fonts/vazir/Vazir-FD-WOL.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }


        body {
            background-color: #f5f7fa;
            font-family: 'Vazir', sans-serif;
        }


        .navbar {
            background: linear-gradient(135deg, #212529, #343a40);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .user-menu {
            position: relative;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            cursor: pointer;
        }

        .dropdown-menu {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                <span>سامانه تیکتینگ</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    @guest
                        <li class="nav-item mx-1">
                            <a class="btn btn-outline-light btn-sm" href="{{ route('login') }}">ورود</a>
                        </li>
                        <li class="nav-item mx-1">
                            <a class="btn btn-primary btn-sm" href="{{ route('register') }}">ثبت‌نام</a>
                        </li>
                    @endguest

                    @auth
                        <li class="nav-item dropdown user-menu ms-3">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                                data-bs-toggle="dropdown">
                                <span>{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <h6 class="dropdown-header">{{ auth()->user()->email }}</h6>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                @if(auth()->user()->is_admin_level)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.tickets.index') }}">پنل کاربری</a>
                                    </li>
                                @endif
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">خروج</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        @if (session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger shadow-sm">
                <ul class="m-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
