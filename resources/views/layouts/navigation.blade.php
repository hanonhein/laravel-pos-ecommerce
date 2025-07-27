{{-- resources/views/layouts/navigation.blade.php --}}

<style>
    /* Modern Navigation Styles */
    .navbar-modern {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--border-color);
        transition: var(--transition);
        z-index: 1000;
    }

    [data-theme="dark"] .navbar-modern {
        background: rgba(29, 29, 31, 0.95);
    }

    .navbar-brand-modern {
        font-weight: 700;
        font-size: 1.75rem;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-decoration: none;
        transition: var(--transition);
    }

    .navbar-brand-modern:hover {
        transform: scale(1.05);
    }

    .nav-link-modern {
        color: var(--text-primary) !important;
        font-weight: 500;
        padding: 0.75rem 1rem !important;
        border-radius: var(--border-radius-sm);
        transition: var(--transition);
        position: relative;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .nav-link-modern:hover {
        background-color: var(--bg-secondary);
        transform: translateY(-1px);
        color: var(--primary-color) !important;
    }

    .search-container-modern {
        position: relative;
        max-width: 500px;
        margin: 0 auto;
        flex-grow: 1;
    }

    .search-input-modern {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 3rem;
        border: 2px solid var(--border-color);
        border-radius: 25px;
        background-color: var(--bg-secondary);
        color: var(--text-primary);
        font-size: 1rem;
        transition: var(--transition);
        font-weight: 400;
    }

    .search-input-modern:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.1);
        background-color: var(--bg-primary);
    }

    .search-input-modern::placeholder {
        color: var(--text-secondary);
    }

    .search-icon-modern {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
        z-index: 2;
        transition: var(--transition);
    }

    .search-input-modern:focus + .search-icon-modern {
        color: var(--primary-color);
    }

    .user-menu-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        border: 2px solid var(--border-color);
        font-size: 1rem;
    }

    .user-menu-avatar:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 16px rgba(0, 122, 255, 0.3);
    }

    .user-dropdown-menu {
        width: 320px;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
        padding: 0;
        background-color: var(--bg-primary);
        margin-top: 0.5rem;
    }




    .user-dropdown-header {
        text-align: center;
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: linear-gradient(135deg, var(--bg-secondary), var(--bg-primary));
    }

    .user-dropdown-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0 auto 1rem;
        border: 3px solid var(--bg-primary);
        box-shadow: var(--shadow);
    }

    .user-dropdown-menu .dropdown-item {
        padding: 0.875rem 1.5rem;
        color: var(--text-primary);
        transition: var(--transition);
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
    }

    .user-dropdown-menu .dropdown-item:hover {
        background-color: var(--bg-secondary);
        color: var(--primary-color);
        transform: translateX(4px);
    }

    .user-dropdown-menu .dropdown-item i {
        width: 16px;
        text-align: center;
    }

    .cart-badge {
        background: linear-gradient(135deg, var(--danger-color), #ff6b6b);
        color: white;
        border-radius: 50%;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        position: absolute;
        top: -8px;
        right: -8px;
        min-width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    .category-toggle-modern {
        background: var(--bg-secondary);
        border: 2px solid var(--border-color);
        border-radius: var(--border-radius-sm);
        color: var(--text-primary);
        padding: 0.75rem;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
    }

    .category-toggle-modern:hover {
        background: var(--bg-primary);
        border-color: var(--primary-color);
        color: var(--primary-color);
        transform: translateY(-1px);
    }

    .navbar-nav-modern {
        gap: 0.5rem;
    }

    /* Theme Toggle Specific Styles */
    .theme-toggle {
        background: var(--bg-secondary);
        border: 2px solid var(--border-color);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        cursor: pointer;
        color: var(--text-primary);
        font-size: 1.1rem;
    }

    .theme-toggle:hover {
        background: var(--bg-primary);
        border-color: var(--primary-color);
        color: var(--primary-color);
        transform: scale(1.1);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .search-container-modern {
            max-width: none;
            margin: 0.5rem 0;
        }

        .navbar-nav-modern {
            gap: 0.25rem;
        }

        .user-dropdown-menu {
            width: 180px;
            font-size: 11px;
        }
    }
</style>

<header class="sticky-top">
    <!-- Top Navbar (Logo, Cart, User) -->
    <nav class="navbar navbar-expand-lg navbar-modern">
        <div class="container">
            <a class="navbar-brand-modern" href="{{ route('home') }}">
                <i class="fas fa-bolt me-2"></i>PC Parts Store
            </a>

            <div class="d-flex align-items-center navbar-nav-modern">
                <!-- Theme Toggle -->
                <button class="theme-toggle me-3" id="theme-toggle" title="Toggle Theme">
                    <i class="fas fa-moon"></i>
                </button>

                @auth
                    <!-- Cart Link -->
                    <a class="nav-link-modern me-3 position-relative" href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="d-none d-md-inline">Cart</span>
                        @if(isset($cartItemCount) && $cartItemCount > 0)
                            <span class="cart-badge">{{ $cartItemCount }}</span>
                        @endif
                    </a>

                    <!-- User Menu -->
                    <div class="dropdown ">
                        <div class="user-menu-avatar" data-bs-toggle="dropdown" aria-expanded="false" title="{{ Auth::user()->name }}">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu ">
                            <li class="user-dropdown-header">
                                <div class="user-dropdown-avatar">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="fw-bold fs-5">{{ Auth::user()->name }}</div>
                                <div class="text-muted small">{{ Auth::user()->email }}</div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('wishlist.index') }}">
                                    <i class="fas fa-heart"></i>
                                    My Wishlist
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('account.orders') }}">
                                    <i class="fas fa-box"></i>
                                    My Orders
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-cog"></i>
                                    Profile Settings
                                </a>
                            </li>
                            @if (Auth::user()->is_admin)
                                <li><hr class="dropdown-divider my-0"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-crown"></i>
                                        Admin Panel
                                    </a>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider my-0"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- Guest Links -->
                    <a class="nav-link-modern me-3 position-relative" href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="d-none d-md-inline">Cart</span>
                    </a>
                    <a class="nav-link-modern me-2" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i>
                        <span class="d-none d-md-inline">Login</span>
                    </a>
                    <a class="nav-link-modern" href="{{ route('register') }}">
                        <i class="fas fa-user-plus"></i>
                        <span class="d-none d-md-inline">Register</span>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Bottom Navbar (Category Menu, Search) -->
    <nav class="navbar navbar-expand-lg navbar-modern border-top">
        <div class="container">
            <div class="d-flex align-items-center w-100">
                <!-- Category Toggle Button -->
                <button class="category-toggle-modern me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#categoryOffcanvas" aria-controls="categoryOffcanvas">
                    <i class="fas fa-bars"></i>
                    <span class="d-none d-md-inline">Categories</span>
                </button>

                <!-- Search Container -->
                <div class="search-container-modern">
                    <form action="{{ route('search.results') }}" method="GET" class="d-flex position-relative">
                        <i class="fas fa-search search-icon-modern"></i>
                        <input name="query" class="search-input-modern" type="search"
                               placeholder="Search for PC parts, components..."
                               id="search-input"
                               autocomplete="off"
                               value="{{ request('query') }}">
                    </form>
                    <div id="search-results-container" class="search-results list-group"></div>
                </div>

                <!-- Quick Categories (Desktop Only) -->
                <div class="d-none d-lg-flex ms-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-fire me-1"></i>Popular
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', ['category' => 'graphics-cards']) }}">Graphics Cards</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', ['category' => 'processors']) }}">Processors</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', ['category' => 'motherboards']) }}">Motherboards</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', ['category' => 'memory']) }}">Memory</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
