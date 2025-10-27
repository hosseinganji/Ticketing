<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'پنل مدیریت - سامانه تیکتینگ' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <style>
        @font-face {
            font-family: 'Vazir';
            src: url('{{ asset('fonts/vazir/Vazir-FD-WOL.woff2') }}') format('woff2'),
                url('{{ asset('fonts/vazir/Vazir-FD-WOL.woff') }}') format('woff'),
                url('{{ asset('fonts/vazir/Vazir-FD-WOL.ttf') }}') format('truetype');
            font-display: swap;
        }

        body {
            background-color: #f5f7fa;
            font-family: 'Vazir', sans-serif;
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        .sidebar {
            width: 240px;
            background: linear-gradient(135deg, #212529, #343a40);
            color: #fff;
            flex-shrink: 0;
            min-height: 100vh;
            transition: all 0.3s ease;
            position: fixed;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            border-radius: 6px;
            padding: 10px 15px;
            transition: all 0.2s;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background: #495057;
            color: #fff;
        }

        .sidebar .sidebar-header {
            font-weight: bold;
            font-size: 1.1rem;
            padding: 20px 15px;
            background: rgba(255, 255, 255, 0.05);
            text-align: center;
        }

        .main-content {
            flex-grow: 1;
            margin-right: 240px;
            transition: margin 0.3s ease;
        }

        .sidebar.collapsed + .main-content {
            margin-right: 70px;
        }

        .toggle-btn {
            position: absolute;
            top: 15px;
            left: 15px;
            color: #fff;
            background: none;
            border: none;
            font-size: 1.3rem;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <button class="toggle-btn" id="toggleSidebar">
            <i class="bi bi-list"></i>
        </button>
        <div class="sidebar-header">مدیریت</div>
        <ul class="nav flex-column px-2 mt-3">
            <li class="nav-item">
                <a href="{{ route('admin.tickets.index') }}"
                   class="nav-link {{ request()->routeIs('admin.tickets.index') ? 'active' : '' }}">
                    تیکت‌ها
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('dashboard') }}">سامانه تیکتینگ</a>
                <div class="d-flex align-items-center">
                    <span class="text-white me-3">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-light">خروج</button>
                    </form>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('collapsed');
        });
    </script>
    @yield('scripts')
</body>
</html>
