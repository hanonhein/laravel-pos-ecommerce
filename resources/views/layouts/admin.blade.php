{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel - {{ config('app.name', 'PC Parts Store') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Admin Custom Styles -->
    <style>
        :root {
            --admin-primary: #6C5CE7;
            --admin-secondary: #A29BFE;
            --admin-success: #00B894;
            --admin-warning: #FDCB6E;
            --admin-danger: #E17055;
            --admin-info: #74B9FF;
            --admin-dark: #2D3436;
            --admin-light: #DDD6FE;
            --text-primary: #2D3436;
            --text-secondary: #636E72;
            --bg-primary: #FFFFFF;
            --bg-secondary: #F8F9FA;
            --bg-tertiary: #FAFAFC;
            --border-color: #E9ECEF;
            --shadow: 0 2px 8px rgba(108, 92, 231, 0.08);
            --shadow-lg: 0 8px 32px rgba(108, 92, 231, 0.12);
            --border-radius: 16px;
            --border-radius-sm: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-theme="dark"] {
            --text-primary: #F8F9FA;
            --text-secondary: #ADB5BD;
            --bg-primary: #1A1D23;
            --bg-secondary: #25282E;
            --bg-tertiary: #2B2F36;
            --border-color: #343A40;
            --admin-primary: #8B7CF6;
            --admin-secondary: #C7B9FF;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        body {
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
            transition: var(--transition);
            line-height: 1.6;
        }

        /* Modern Admin Navbar */
        .admin-navbar {
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
            border: none;
            box-shadow: var(--shadow-lg);
            padding: 1rem 0;
        }

        .admin-navbar .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .admin-navbar .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.75rem 1.25rem !important;
            border-radius: var(--border-radius-sm);
            transition: var(--transition);
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .admin-navbar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white !important;
            transform: translateY(-1px);
        }

        .admin-navbar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white !important;
        }

        .admin-navbar .btn {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: var(--border-radius-sm);
            padding: 0.5rem 1rem;
            transition: var(--transition);
        }

        .admin-navbar .btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }

        /* Admin Content Area */
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Modern Cards */
        .admin-card {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: var(--transition);
        }

        .admin-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .admin-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border-color);
        }

        .admin-card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Stats Cards */
        .stats-card {
            background: linear-gradient(135deg, var(--bg-primary), var(--bg-secondary));
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            text-align: center;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--admin-primary);
            margin-bottom: 0.5rem;
        }

        .stats-label {
            color: var(--text-secondary);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
        }

        /* Modern Tables */
        .admin-table {
            background: var(--bg-primary);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .admin-table .table {
            margin: 0;
        }

        .admin-table .table th {
            background: var(--bg-secondary);
            border: none;
            font-weight: 600;
            color: var(--text-primary);
            padding: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
        }

        .admin-table .table td {
            border: none;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .admin-table .table tbody tr:hover {
            background-color: var(--bg-secondary);
        }

        /* Modern Buttons */
        .btn-admin-primary {
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
            border: none;
            color: white;
            border-radius: var(--border-radius-sm);
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-admin-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(108, 92, 231, 0.4);
            color: white;
        }

        .btn-admin-secondary {
            background: var(--bg-secondary);
            border: 2px solid var(--border-color);
            color: var(--text-primary);
            border-radius: var(--border-radius-sm);
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-admin-secondary:hover {
            border-color: var(--admin-primary);
            color: var(--admin-primary);
            transform: translateY(-1px);
        }

        /* Theme Toggle for Admin */
        .admin-theme-toggle {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            cursor: pointer;
            color: white;
        }

        .admin-theme-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .admin-container {
                padding: 1rem;
            }

            .admin-card {
                padding: 1rem;
            }

            .stats-number {
                font-size: 2rem;
            }
        }

        /* Success/Error Alerts */
        .alert-modern {
            border: none;
            border-radius: var(--border-radius-sm);
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
        }

        .alert-success {
            background: rgba(0, 184, 148, 0.1);
            border-left-color: var(--admin-success);
            color: var(--admin-success);
        }

        .alert-danger {
            background: rgba(225, 112, 85, 0.1);
            border-left-color: var(--admin-danger);
            color: var(--admin-danger);
        }
    </style>
</head>

<body>
    <!-- Modern Admin Navigation -->
    <nav class="navbar navbar-expand-lg admin-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-crown"></i>
                Admin Panel
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <i class="fas fa-bars text-white"></i>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                           href="{{ route('admin.products.index') }}">
                            <i class="fas fa-box"></i>
                            Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                           href="{{ route('admin.categories.index') }}">
                            <i class="fas fa-tags"></i>
                            Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                           href="{{ route('admin.orders.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                            Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                           href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users"></i>
                            Users
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav align-items-center">
                    <!-- Theme Toggle -->
                    <li class="nav-item me-2">
                        <button class="admin-theme-toggle" id="admin-theme-toggle" title="Toggle Theme">
                            <i class="fas fa-moon"></i>
                        </button>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ route('home') }}" target="_blank">
                            <i class="fas fa-external-link-alt"></i>
                            View Site
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn">
                                <i class="fas fa-sign-out-alt me-1"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="admin-container">
        @if(session('success'))
            <div class="alert alert-success alert-modern">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-modern">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const themeToggle = document.getElementById('admin-theme-toggle');
            const html = document.documentElement;

            // Theme toggle functionality
            if (themeToggle) {
                themeToggle.addEventListener('click', function() {
                    const currentTheme = html.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    html.setAttribute('data-theme', newTheme);
                    localStorage.setItem('admin-theme', newTheme);

                    // Update icon
                    const icon = themeToggle.querySelector('i');
                    icon.className = newTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
                });

                // Load saved theme
                const savedTheme = localStorage.getItem('admin-theme') || 'light';
                html.setAttribute('data-theme', savedTheme);
                const icon = themeToggle.querySelector('i');
                icon.className = savedTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            }

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert-modern');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });

            // Add smooth transitions to table rows
            const tableRows = document.querySelectorAll('.admin-table tbody tr');
            tableRows.forEach(row => {
                row.style.transition = 'all 0.3s ease';
            });
        });
    </script>
</body>
</html>
