{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
        <div class="row mb-4 ">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="responsive-header">
                    @if (isset($currentCategory))
                        <h1 class="h2 fw-bold mb-2">{{ $currentCategory->name }}</h1>
                        <p class="text-muted mb-0">Discover premium PC components in this category</p>
                    @else
                        <h1 class="h2 fw-bold mb-2">All Products</h1>
                        <p class="text-muted mb-0">Explore our complete collection of PC parts and components</p>
                    @endif
                </div>

                <!-- View Toggle & Sort Options -->
                <div class="d-flex align-items-center gap-3">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary active" id="gridView">
                            <i class="fas fa-th"></i>
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="listView">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>

                    <select class="form-select" style="width: auto;" onchange="location = this.value">
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row" id="productsContainer">
        @forelse($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4 product-card">
                <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 border-0 shadow-sm product-item" style="transition: var(--transition);">
                        <!-- Product Image -->
                        <div class="position-relative overflow-hidden" style="height: 220px;">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x220/f8f9fa/6c757d?text=No+Image' }}"
                                 class="card-img-top w-100 h-100"
                                 alt="{{ $product->name }}"
                                 style="object-fit: cover; transition: var(--transition);">

                            <!-- Sale Badge -->
                            @if ($product->sale_price)
                                <div class="position-absolute top-0 start-0 m-2">
                                    <span class="badge bg-danger px-2 py-1">
                                        SALE
                                    </span>
                                </div>
                            @endif

                            <!-- Quick Actions -->
                            <div class="position-absolute top-0 end-0 m-2 d-flex flex-column gap-2 quick-actions" style="opacity: 0; transition: var(--transition);">
                                <button class="btn btn-light btn-sm rounded-circle p-2" title="Quick View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-light btn-sm rounded-circle p-2" title="Add to Wishlist">
                                        @if(in_array($product->id, $wishlistProductIds))
                                            <i class="fas fa-heart text-danger"></i> {{-- Filled Heart --}}
                                        @else
                                            <i class="far fa-heart"></i> {{-- Empty Heart --}}
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="card-body d-flex flex-column p-3">
                            <!-- Product Name -->
                            <h5 class="card-title fw-semibold mb-2 text-truncate" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h5>

                            <!-- Product Description -->
                            <p class="card-text text-muted small flex-grow-1 mb-3" style="font-size: 0.875rem; line-height: 1.4;">
                                {{ Str::limit($product->description, 80) }}
                            </p>

                            <!-- Price Section -->
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div class="price-section">
                                    @if ($product->sale_price)
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="h6 text-danger mb-0 fw-bold">${{ number_format($product->sale_price, 2) }}</span>
                                            <del class="text-muted small">${{ number_format($product->price, 2) }}</del>
                                        </div>
                                        <small class="text-success">
                                            Save ${{ number_format($product->price - $product->sale_price, 2) }}
                                        </small>
                                    @else
                                        <span class="h6 text-primary mb-0 fw-bold">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>

                                <!-- Add to Cart Button -->
                                <div class="d-flex gap-2">
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary btn-sm px-3" title="Add to Cart">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm px-3" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>



            </div>
        @empty
            <!-- Empty State -->
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4" style="font-size: 4rem; color: var(--text-secondary); opacity: 0.5;">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h3 class="h4 mb-3">No products found</h3>
                    <p class="text-muted mb-4">We couldn't find any products matching your criteria.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>View All Products
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="d-flex justify-content-center mt-5">
            <nav aria-label="Products pagination">
                {{ $products->links() }}
            </nav>
        </div>
    @endif
</div>

<style>
/* Product Card Hover Effects */
.product-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15) !important;
}

.product-item:hover img {
    transform: scale(1.05);
}

.product-item:hover .quick-actions {
    opacity: 1 !important;
}

/* List View Styles */
.list-view .product-card {
    width: 100%;
}

.list-view .product-item {
    flex-direction: row;
    align-items: center;
}

.list-view .product-item img {
    width: 150px;
    height: 120px;
    object-fit: cover;
}

.list-view .card-body {
    flex: 1;
    padding: 1.5rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .product-item:hover {
        transform: none;
    }

    .quick-actions {
        opacity: 1 !important;
    }
}

/* Loading Animation */
.product-item {
    animation: fadeInUp 0.6s ease-out forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Stagger animation for product cards */
.product-card:nth-child(1) .product-item { animation-delay: 0.1s; }
.product-card:nth-child(2) .product-item { animation-delay: 0.2s; }
.product-card:nth-child(3) .product-item { animation-delay: 0.3s; }
.product-card:nth-child(4) .product-item { animation-delay: 0.4s; }
.product-card:nth-child(5) .product-item { animation-delay: 0.5s; }
.product-card:nth-child(6) .product-item { animation-delay: 0.6s; }
.product-card:nth-child(7) .product-item { animation-delay: 0.7s; }
.product-card:nth-child(8) .product-item { animation-delay: 0.8s; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const gridViewBtn = document.getElementById('gridView');
    const listViewBtn = document.getElementById('listView');
    const productsContainer = document.getElementById('productsContainer');

    // View toggle functionality
    gridViewBtn.addEventListener('click', function() {
        productsContainer.classList.remove('list-view');
        gridViewBtn.classList.add('active');
        listViewBtn.classList.remove('active');
        localStorage.setItem('viewMode', 'grid');
    });

    listViewBtn.addEventListener('click', function() {
        productsContainer.classList.add('list-view');
        listViewBtn.classList.add('active');
        gridViewBtn.classList.remove('active');
        localStorage.setItem('viewMode', 'list');
    });

    // Load saved view preference
    const savedView = localStorage.getItem('viewMode');
    if (savedView === 'list') {
        listViewBtn.click();
    }

    // Add to cart with feedback
    const addToCartForms = document.querySelectorAll('form[action*="cart.add"]');
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            const originalContent = button.innerHTML;

            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;

            // Re-enable after a delay (in case of page redirect)
            setTimeout(() => {
                button.innerHTML = originalContent;
                button.disabled = false;
            }, 2000);
        });
    });
});
</script>
@endsection
