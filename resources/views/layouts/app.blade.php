{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PC Parts Store') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap 5.3 -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

    <!-- Scripts -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    <!-- Custom Modern Styles -->
    <style>
        :root {
            --primary-color: #007AFF;
            --secondary-color: #5856D6;
            --success-color: #34C759;
            --warning-color: #FF9500;
            --danger-color: #FF3B30;
            --text-primary: #1D1D1F;
            --text-secondary: #86868B;
            --bg-primary: #FFFFFF;
            --bg-secondary: #F5F5F7;
            --bg-tertiary: #FAFAFA;
            --border-color: #E5E5E7;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.12);
            --border-radius: 16px;
            --border-radius-sm: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-theme="dark"] {
            --text-primary: #F5F5F7;
            --text-secondary: #A1A1A6;
            --bg-primary: #1D1D1F;
            --bg-secondary: #2C2C2E;
            --bg-tertiary: #1C1C1E;
            --border-color: #38383A;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        body {
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
            transition: var(--transition);
            line-height: 1.6;
            font-weight: 400;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--text-secondary);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-primary);
        }

        /* Modern Offcanvas Sidebar */
        .offcanvas {
            background-color: var(--bg-primary);
            border: none;
            box-shadow: var(--shadow-lg);
            width: 320px !important;
        }

        .offcanvas-header {
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
        }

        .offcanvas-title {
            font-weight: 600;
            font-size: 1.25rem;
            color: var(--text-primary);
        }

        .btn-close {
            background: none;
            border: none;
            opacity: 0.6;
            transition: var(--transition);
        }

        .btn-close:hover {
            opacity: 1;
            transform: scale(1.1);
        }

        .offcanvas-body {
            padding: 1.5rem;
        }

        .offcanvas-body h6 {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Modern Form Controls */
        .form-control, .form-select {
            background-color: var(--bg-secondary);
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            color: var(--text-primary);
            padding: 0.75rem 1rem;
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--bg-primary);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.1);
        }

        .form-check-input {
            background-color: var(--bg-secondary);
            border: 2px solid var(--border-color);
            border-radius: 6px;
            transition: var(--transition);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--text-primary);
            font-weight: 500;
            margin-left: 0.5rem;
        }

        /* Modern Button Styles */
        .btn {
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: var(--transition);
            border: none;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), #5856D6);
            color: white;
            box-shadow: 0 4px 16px rgba(0, 122, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 122, 255, 0.4);
            background: linear-gradient(135deg, #0056b3, #4c46c7);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            transform: translateY(-1px);
        }

        /* Modern List Groups */
        .list-group {
            border: none;
        }

        .list-group-item {
            background-color: transparent;
            border: none;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .list-group-item:hover {
            background-color: var(--bg-secondary);
            border-radius: var(--border-radius-sm);
            margin: 0 -0.5rem;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        /* Search Results Styling */
        .search-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            z-index: -1;
            opacity: 0;
            transition: var(--transition);
            pointer-events: none;
        }

        .search-overlay.show {
            z-index: 999;
            opacity: 1;
            pointer-events: auto;
        }

        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            z-index: 1050;
            display: none;
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            background-color: var(--bg-primary);
            max-height: 400px;
            overflow-y: auto;
            margin-top: 0.5rem;
        }

        .search-results.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }


        @media (max-width: 568px) {
            .responsive-header {
               display: none;
            }
        }

        .search-results .list-group-item {
            display: flex;
            align-items: center;
            border: none;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .search-results .list-group-item:hover {
            background-color: var(--bg-secondary);
        }

        .search-result-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 1rem;
            border-radius: var(--border-radius-sm);
        }

        .search-result-details {
            flex-grow: 1;
        }

        .search-result-price {
            font-weight: 600;
            color: var(--primary-color);
        }

        /* Theme Toggle Button */
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
        }

        .theme-toggle:hover {
            background: var(--bg-primary);
            transform: scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .offcanvas {
                width: 280px !important;
            }

            .offcanvas-body {
                padding: 1rem;
            }
        }

        /* Enhanced Dark Mode Fixes */
        [data-theme="dark"] body {
            background-color: var(--bg-tertiary) !important;
            color: var(--text-primary) !important;
        }

        /* Offcanvas Dark Mode */
        [data-theme="dark"] .offcanvas {
            background-color: var(--bg-primary) !important;
            color: var(--text-primary) !important;
            border-right: 1px solid var(--border-color) !important;
        }

        [data-theme="dark"] .offcanvas-header {
            border-bottom: 1px solid var(--border-color) !important;
            background-color: var(--bg-primary) !important;
        }

        [data-theme="dark"] .offcanvas-title {
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .offcanvas-body {
            background-color: var(--bg-primary) !important;
            color: var(--text-primary) !important;
        }

        /* Form Controls Dark Mode */
        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: var(--bg-secondary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            background-color: var(--bg-tertiary) !important;
            border-color: var(--primary-color) !important;
            color: var(--text-primary) !important;
            box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.1) !important;
        }

        [data-theme="dark"] .form-control::placeholder {
            color: var(--text-secondary) !important;
        }

        /* Labels and Text Dark Mode */
        [data-theme="dark"] .form-label,
        [data-theme="dark"] h1, [data-theme="dark"] h2, [data-theme="dark"] h3,
        [data-theme="dark"] h4, [data-theme="dark"] h5, [data-theme="dark"] h6,
        [data-theme="dark"] .form-check-label {
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .text-muted {
            color: var(--text-secondary) !important;
        }

        /* Checkboxes Dark Mode */
        [data-theme="dark"] .form-check-input {
            background-color: var(--bg-secondary) !important;
            border-color: var(--border-color) !important;
        }

        [data-theme="dark"] .form-check-input:checked {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        /* List Groups Dark Mode */
        [data-theme="dark"] .list-group-item {
            background-color: transparent !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .list-group-item:hover {
            background-color: var(--bg-secondary) !important;
        }

        /* Category Links Dark Mode */
        [data-theme="dark"] .category-link,
        [data-theme="dark"] .category-collapse-btn {
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .category-link:hover,
        [data-theme="dark"] .category-collapse-btn:hover {
            color: var(--primary-color) !important;
            background-color: var(--bg-secondary) !important;
        }

        /* Cards Dark Mode */
        [data-theme="dark"] .card {
            background-color: var(--bg-primary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .card-body {
            background-color: var(--bg-primary) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .card-title {
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .card-text {
            color: var(--text-secondary) !important;
        }

        /* Search Results Dark Mode */
        [data-theme="dark"] .search-results {
            background-color: var(--bg-primary) !important;
            border-color: var(--border-color) !important;
        }

        [data-theme="dark"] .search-results .list-group-item {
            background-color: var(--bg-primary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .search-results .list-group-item:hover {
            background-color: var(--bg-secondary) !important;
        }

        /* Close Button Dark Mode */
        [data-theme="dark"] .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
            opacity: 0.8;
        }

        [data-theme="dark"] .btn-close:hover {
            opacity: 1;
        }

        /* Buttons Dark Mode */
        [data-theme="dark"] .btn-outline-primary {
            color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            background-color: transparent !important;
        }

        [data-theme="dark"] .btn-outline-primary:hover {
            color: white !important;
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        [data-theme="dark"] .btn-outline-secondary {
            color: var(--text-primary) !important;
            border-color: var(--border-color) !important;
            background-color: transparent !important;
        }

        [data-theme="dark"] .btn-outline-secondary:hover {
            color: var(--text-primary) !important;
            background-color: var(--bg-secondary) !important;
            border-color: var(--border-color) !important;
        }

        /* Pagination Dark Mode */
        [data-theme="dark"] .pagination .page-link {
            background-color: var(--bg-primary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .pagination .page-link:hover {
            background-color: var(--bg-secondary) !important;
            border-color: var(--primary-color) !important;
            color: var(--primary-color) !important;
        }

        [data-theme="dark"] .pagination .page-item.active .page-link {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }

        /* Force text color inheritance */
        [data-theme="dark"] p,
        [data-theme="dark"] span,
        [data-theme="dark"] div {
            color: inherit;
        }

        [data-theme="dark"] a {
            color: var(--primary-color);
        }

        [data-theme="dark"] a:hover {
            color: var(--secondary-color);
        }

        /* Custom category collapse styling */
        .category-collapse-btn {
            color: var(--text-primary);
            text-decoration: none;
            display: flex;
            justify-content: between;
            align-items: center;
            width: 100%;
            transition: var(--transition);
        }

        .category-collapse-btn:hover {
            color: var(--primary-color);
        }

        .category-collapse-btn .chevron {
            transition: transform 0.3s ease;
        }

        .category-collapse-btn[aria-expanded="true"] .chevron {
            transform: rotate(90deg);
        }
    </style>
</head>

<body>
    {{-- Modern Offcanvas Sidebar --}}
    <div class="offcanvas offcanvas-start" tabindex="-1" id="categoryOffcanvas" aria-labelledby="categoryOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="categoryOffcanvasLabel">
                <i class="fas fa-filter me-2"></i>Filter & Sort
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('products.index') }}" method="GET">
                {{-- Categories Section --}}
                <h6><i class="fas fa-tags me-2"></i>Categories</h6>
                <ul class="list-group list-group-flush mb-4">
                    @if(isset($categoriesForSidebar))
                        @foreach($categoriesForSidebar as $category)
                            @include('layouts.partials.category-item', ['category' => $category])
                        @endforeach
                    @endif
                </ul>

                {{-- Brands Section --}}
                @if(isset($brandsForSidebar) && $brandsForSidebar->isNotEmpty())
                    <h6><i class="fas fa-building me-2"></i>Brands</h6>
                    <div class="mb-4">
                        @foreach($brandsForSidebar as $brand)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="brands[]" value="{{ $brand }}" id="brand-{{ $loop->index }}"
                                    @if(request('brands') && in_array($brand, request('brands'))) checked @endif
                                >
                                <label class="form-check-label" for="brand-{{ $loop->index }}">
                                    {{ $brand }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Price Range Section --}}
                <h6><i class="fas fa-dollar-sign me-2"></i>Price Range</h6>
                <div class="row mb-4">
                    <div class="col-6">
                        <input type="number" name="min_price" class="form-control" placeholder="Min $" value="{{ request('min_price') }}">
                    </div>
                    <div class="col-6">
                        <input type="number" name="max_price" class="form-control" placeholder="Max $" value="{{ request('max_price') }}">
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('layouts.navigation')

    <!-- Page Content -->
    <main style="position: relative; z-index: 1;">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    {{-- Search overlay and enhanced script --}}
    <div id="search-overlay" class="search-overlay"></div>

    <!-- Bootstrap JS -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            const resultsContainer = document.getElementById('search-results-container');
            const searchOverlay = document.getElementById('search-overlay');
            const themeToggle = document.getElementById('theme-toggle');
            const html = document.documentElement;

            // Theme toggle functionality - Enhanced
            if (themeToggle) {
                themeToggle.addEventListener('click', function() {
                    const currentTheme = html.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

                    // Apply theme immediately
                    html.setAttribute('data-theme', newTheme);
                    document.body.setAttribute('data-theme', newTheme);

                    // Save preference
                    localStorage.setItem('theme', newTheme);

                    // Update icon
                    const icon = themeToggle.querySelector('i');
                    icon.className = newTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';

                    // Force update of all elements
                    document.querySelectorAll('.offcanvas, .modal, .dropdown-menu').forEach(el => {
                        el.setAttribute('data-theme', newTheme);
                    });
                });

                // Load saved theme - Enhanced
                const savedTheme = localStorage.getItem('theme') ||
                    (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

                html.setAttribute('data-theme', savedTheme);
                document.body.setAttribute('data-theme', savedTheme);

                const icon = themeToggle.querySelector('i');
                icon.className = savedTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';

                // Apply theme to dynamic elements
                document.querySelectorAll('.offcanvas, .modal, .dropdown-menu').forEach(el => {
                    el.setAttribute('data-theme', savedTheme);
                });
            }

            // System theme preference detection
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (!localStorage.getItem('theme')) {
                    const newTheme = e.matches ? 'dark' : 'light';
                    html.setAttribute('data-theme', newTheme);
                    document.body.setAttribute('data-theme', newTheme);

                    if (themeToggle) {
                        const icon = themeToggle.querySelector('i');
                        icon.className = newTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
                    }
                }
            });

            // Enhanced search functionality
            if (searchInput && resultsContainer && searchOverlay) {
                let searchTimeout;

                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();

                    clearTimeout(searchTimeout);

                    if (query.length < 2) {
                        resultsContainer.classList.remove('show');
                        searchOverlay.classList.remove('show');
                        return;
                    }

                    searchTimeout = setTimeout(async () => {
                        try {
                            const response = await fetch(`/api/search?query=${encodeURIComponent(query)}`);
                            if (!response.ok) throw new Error('Search failed');

                            const products = await response.json();
                            resultsContainer.innerHTML = '';

                            if (products.length > 0) {
                                products.forEach(product => {
                                    const link = document.createElement('a');
                                    link.href = `/products/${product.slug}`;
                                    link.classList.add('list-group-item', 'list-group-item-action');

                                    const imageUrl = product.image ? `/storage/${product.image}` : 'https://via.placeholder.com/150x150/f0f0f0/666?text=No+Image';
                                    const formattedPrice = new Intl.NumberFormat('en-US', {
                                        style: 'currency',
                                        currency: 'USD'
                                    }).format(product.price);

                                    link.innerHTML = `
                                        <img src="${imageUrl}" alt="${product.name}" class="search-result-img">
                                        <div class="search-result-details">
                                            <div class="fw-medium">${product.name}</div>
                                            <small class="text-muted">${product.category || 'Uncategorized'}</small>
                                        </div>
                                        <span class="search-result-price">${formattedPrice}</span>
                                    `;

                                    resultsContainer.appendChild(link);
                                });

                                resultsContainer.classList.add('show');
                                searchOverlay.classList.add('show');
                            } else {
                                const noResults = document.createElement('div');
                                noResults.className = 'list-group-item text-center text-muted py-4';
                                noResults.innerHTML = `
                                    <i class="fas fa-search mb-2 d-block"></i>
                                    No products found for "${query}"
                                `;
                                resultsContainer.appendChild(noResults);
                                resultsContainer.classList.add('show');
                                searchOverlay.classList.add('show');
                            }
                        } catch (error) {
                            console.error('Search error:', error);
                            resultsContainer.classList.remove('show');
                            searchOverlay.classList.remove('show');
                        }
                    }, 300);
                });

                // Close search results when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                        resultsContainer.classList.remove('show');
                        searchOverlay.classList.remove('show');
                    }
                });

                // Close search results on escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        resultsContainer.classList.remove('show');
                        searchOverlay.classList.remove('show');
                        searchInput.blur();
                    }
                });
            }

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
