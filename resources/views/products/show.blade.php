{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0 m-0">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <i class="fas fa-home me-1"></i>Home
                </a>
            </li>
            @foreach ($categoryPath as $category)
                <li class="breadcrumb-item">
                    <a href="{{ route('products.byCategory', $category) }}" class="text-decoration-none">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
            <li class="breadcrumb-item active text-primary" aria-current="page">
                {{ Str::limit($product->name, 40) }}
            </li>
        </ol>
    </nav>

    <!-- Main Product Section -->
    <div class="row gx-5">
        <!-- Product Image -->
        <div class="col-lg-6 mb-4">
            <div class="product-image-container">
                <div class="main-image-wrapper position-relative">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600x600/f8f9fa/6c757d?text=No+Image' }}"
                         class="main-product-image w-100 rounded-3 shadow-sm"
                         alt="{{ $product->name }}"
                         id="mainProductImage">

                    @if ($product->sale_price)
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-danger px-3 py-2 fs-6">
                                <i class="fas fa-tag me-1"></i>SALE
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Thumbnail Images (if you have multiple images) -->
                <div class="thumbnail-container mt-3 d-none">
                    <div class="row g-2">
                        <div class="col-3">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/150x150' }}"
                                 class="thumbnail-image w-100 rounded-2 cursor-pointer"
                                 alt="Thumbnail 1">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-6">
            <div class="product-details">
                <!-- Product Title -->
                <h1 class="product-title h2 fw-bold mb-3">{{ $product->name }}</h1>

                <!-- Rating Section -->
                <div class="rating-section d-flex align-items-center mb-4">
                    <div class="stars me-3">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa{{ $i <= round($averageRating) ? 's' : 'r' }} fa-star text-warning"></i>
                        @endfor
                    </div>
                    <a href="#reviews-section" class="review-link text-decoration-none d-flex align-items-center">
                        <span class="fw-medium">{{ number_format($averageRating, 1) }}</span>
                        <span class="text-muted ms-2">({{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})</span>
                    </a>
                </div>

                <!-- Price Section -->
                <div class="price-section mb-4">
                    @if ($product->sale_price)
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="sale-price h2 text-danger fw-bold mb-0">
                                ${{ number_format($product->sale_price, 2) }}
                            </span>
                            <del class="original-price h4 text-muted mb-0">
                                ${{ number_format($product->price, 2) }}
                            </del>
                        </div>
                        <div class="savings-badge">
                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                <i class="fas fa-percentage me-1"></i>
                                Save ${{ number_format($product->price - $product->sale_price, 2) }}
                                ({{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% off)
                            </span>
                        </div>
                    @else
                        <span class="current-price h2 text-primary fw-bold">
                            ${{ number_format($product->price, 2) }}
                        </span>
                    @endif
                </div>

                <!-- Product Features/Highlights -->
                <div class="product-highlights mb-4">
                    <ul class="list-unstyled">
                        <li class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Premium Quality Components</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="fas fa-truck text-primary me-2"></i>
                            <span>Free Shipping on Orders $50+</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="fas fa-shield-alt text-info me-2"></i>
                            <span>1 Year Warranty Included</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="fas fa-undo text-warning me-2"></i>
                            <span>30-Day Return Policy</span>
                        </li>
                    </ul>
                </div>

                <!-- Add to Cart Section -->
                <div class="add-to-cart-section">
                    <form action="{{ route('cart.add', $product) }}" method="POST" id="addToCartForm">
                        @csrf
                        <div class="row g-3 align-items-end mb-4">
                            <div class="col-md-4">
                                <label for="quantity" class="form-label fw-medium">Quantity</label>
                                <div class="quantity-input-group">
                                    <button type="button" class="btn btn-outline-secondary quantity-btn" data-action="decrease">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" name="quantity" id="quantity" class="form-control text-center" value="1" min="1" max="99">
                                    <button type="button" class="btn btn-outline-secondary quantity-btn" data-action="increase">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="d-grid gap-2 d-md-flex">
                                    <button type="submit" class="btn btn-primary btn-lg px-4 flex-fill" id="addToCartBtn">
                                        <i class="fas fa-cart-plus me-2"></i>
                                        Add to Cart
                                    </button>
                                    <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-secondary btn-lg px-3" title="Add to Wishlist">
                                            @if(in_array($product->id, $wishlistProductIds))
                                                <i class="fas fa-heart text-danger"></i>
                                            @else
                                                <i class="far fa-heart"></i>
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Social Share -->
                <div class="social-share">
                    <span class="text-muted me-3">Share:</span>
                    <a href="#" class="btn btn-outline-primary btn-sm me-2">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-outline-info btn-sm me-2">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-outline-success btn-sm">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Tabs -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="product-tabs-container">
                <!-- Tab Navigation -->
                <ul class="nav nav-pills nav-fill mb-4" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="pill" data-bs-target="#description" type="button" role="tab">
                            <i class="fas fa-info-circle me-2"></i>Description
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specifications-tab" data-bs-toggle="pill" data-bs-target="#specifications" type="button" role="tab">
                            <i class="fas fa-cogs me-2"></i>Specifications
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="pill" data-bs-target="#reviews" type="button" role="tab">
                            <i class="fas fa-star me-2"></i>Reviews ({{ $reviewCount }})
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="productTabsContent">
                    <!-- Description Tab -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h4 class="card-title mb-4">Product Description</h4>
                                <div class="product-description">
                                    {!! nl2br(e($product->description)) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Specifications Tab -->
                    <div class="tab-pane fade" id="specifications" role="tabpanel">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h4 class="card-title mb-4">Technical Specifications</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-medium text-muted">Brand:</td>
                                                <td>{{ $product->brand ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium text-muted">Category:</td>
                                                <td>{{ $product->category->name ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium text-muted">SKU:</td>
                                                <td>{{ $product->sku ?? 'Not specified' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-medium text-muted">Warranty:</td>
                                                <td>1 Year</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium text-muted">Condition:</td>
                                                <td>New</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium text-muted">Availability:</td>
                                                <td><span class="badge bg-success">In Stock</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="reviews-header d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="card-title mb-0">Customer Reviews</h4>
                                    <div class="rating-summary text-end">
                                        <div class="d-flex align-items-center justify-content-end mb-1">
                                            <div class="stars me-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa{{ $i <= round($averageRating) ? 's' : 'r' }} fa-star text-warning"></i>
                                                @endfor
                                            </div>
                                            <span class="fw-bold">{{ number_format($averageRating, 1) }}</span>
                                        </div>
                                        <small class="text-muted">Based on {{ $reviewCount }} reviews</small>
                                    </div>
                                </div>

                                <!-- Reviews List -->
                                <div class="reviews-list" id="reviews-section">
                                    @forelse ($product->reviews as $review)
                                        <div class="review-item border-bottom pb-4 mb-4">
                                            <div class="d-flex">
                                                <div class="review-avatar me-3">
                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                         style="width: 50px; height: 50px; font-weight: 600;">
                                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="review-content flex-grow-1">
                                                    <div class="review-header d-flex justify-content-between align-items-start mb-2">
                                                        <div>
                                                            <h6 class="reviewer-name mb-1 fw-semibold">{{ $review->user->name }}</h6>
                                                            <div class="review-rating">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star text-warning"></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                                    </div>
                                                    <p class="review-text mb-0">{{ $review->comment }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-5">
                                            <div class="mb-3" style="font-size: 3rem; color: var(--text-secondary); opacity: 0.5;">
                                                <i class="far fa-comments"></i>
                                            </div>
                                            <h5 class="text-muted mb-3">No reviews yet</h5>
                                            <p class="text-muted">Be the first to share your experience with this product!</p>
                                        </div>
                                    @endforelse
                                </div>

                                <!-- Write Review Section -->
                                @auth
                                    @if ($userHasReviewed)
                                        <div class="alert alert-success text-primary d-flex align-items-center">
                                            <i class="fas fa-check-circle me-2"></i>
                                            Thank you for your review! You've already reviewed this product.
                                        </div>
                                    @else
                                        <div class="write-review-section mt-5 pt-4 border-top">
                                            <h5 class="mb-4">Write a Review</h5>
                                            <form action="{{ route('reviews.store', $product) }}" method="POST" id="reviewForm">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-medium">Your Rating</label>
                                                        <div class="rating-input">
                                                            <div class="star-rating">
                                                                @for ($i = 5; $i >= 1; $i--)
                                                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="d-none">
                                                                    <label for="star{{ $i }}" class="star-label" title="{{ $i }} stars">
                                                                        <i class="fas fa-star"></i>
                                                                    </label>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="comment" class="form-label fw-medium">Your Review</label>
                                                    <textarea class="form-control" name="comment" id="comment" rows="4"
                                                              placeholder="Share your experience with this product..."
                                                              required>{{ old('comment') }}</textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary px-4">
                                                    <i class="fas fa-paper-plane me-2"></i>Submit Review
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @else
                                    <div class="auth-prompt text-center py-4 border-top mt-4">
                                        <p class="mb-3">Want to share your experience?</p>
                                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                        </a>
                                        <a href="{{ route('register') }}" class="btn btn-primary">
                                            <i class="fas fa-user-plus me-2"></i>Create Account
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Product Image Styles */
.main-product-image {
    max-height: 500px;
    object-fit: cover;
    transition: var(--transition);
}

.main-product-image:hover {
    transform: scale(1.02);
}

.thumbnail-image {
    height: 80px;
    object-fit: cover;
    cursor: pointer;
    opacity: 0.7;
    transition: var(--transition);
}

.thumbnail-image:hover {
    opacity: 1;
    transform: scale(1.05);
}

/* Price Section Styles */
.price-section {
    padding: 1.5rem;
    background: var(--bg-secondary);
    border-radius: var(--border-radius);
    border: 2px solid var(--border-color);
}

.sale-price {
    position: relative;
}

.savings-badge {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* Quantity Input Styles */
.quantity-input-group {
    display: flex;
    align-items: center;
    border: 2px solid var(--border-color);
    border-radius: var(--border-radius-sm);
    overflow: hidden;
}

.quantity-input-group input {
    border: none;
    background: none;
    flex: 1;
    padding: 0.75rem 0.5rem;
    font-weight: 500;
}

.quantity-input-group input:focus {
    outline: none;
    box-shadow: none;
}

.quantity-btn {
    border: none;
    background: var(--bg-secondary);
    color: var(--text-primary);
    padding: 0.75rem;
    transition: var(--transition);
}

.quantity-btn:hover {
    background: var(--primary-color);
    color: white;
}

/* Tab Styles */
.nav-pills .nav-link {
    background: var(--bg-secondary);
    color: var(--text-primary);
    border-radius: var(--border-radius-sm);
    padding: 1rem 1.5rem;
    font-weight: 500;
    transition: var(--transition);
    border: 2px solid transparent;
}

.nav-pills .nav-link:hover {
    background: var(--bg-primary);
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    border-color: var(--primary-color);
}

/* Star Rating Input */
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.star-label {
    color: #ddd;
    font-size: 1.5rem;
    cursor: pointer;
    transition: var(--transition);
    margin-right: 0.25rem;
}

.star-label:hover,
.star-label:hover ~ .star-label {
    color: #ffc107;
    transform: scale(1.1);
}

.star-rating input:checked ~ .star-label {
    color: #ffc107;
}

/* Review Item Styles */
.review-item {
    transition: var(--transition);
}

.review-item:hover {
    background: var(--bg-secondary);
    padding: 1rem;
    border-radius: var(--border-radius-sm);
    margin: -1rem;
    margin-bottom: 1rem;
}

.review-avatar {
    flex-shrink: 0;
}

/* Product Highlights */
.product-highlights {
    background: var(--bg-secondary);
    padding: 1.5rem;
    border-radius: var(--border-radius);
    border-left: 4px solid var(--primary-color);
}

.product-highlights li {
    padding: 0.5rem 0;
}

/* Social Share */
.social-share .btn {
    width: 40px;
    height: 40px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

/* Responsive Design */
@media (max-width: 768px) {
    .price-section {
        padding: 1rem;
    }

    .product-highlights {
        padding: 1rem;
    }

    .nav-pills .nav-link {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }

    .star-rating {
        justify-content: center;
    }
}

/* Loading States */
.btn.loading {
    position: relative;
    color: transparent !important;
}

.btn.loading::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    top: 50%;
    left: 50%;
    margin-left: -10px;
    margin-top: -10px;
    border: 2px solid transparent;
    border-top-color: white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity controls
    const quantityInput = document.getElementById('quantity');
    const decreaseBtn = document.querySelector('[data-action="decrease"]');
    const increaseBtn = document.querySelector('[data-action="increase"]');

    decreaseBtn.addEventListener('click', function() {
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    increaseBtn.addEventListener('click', function() {
        const currentValue = parseInt(quantityInput.value);
        if (currentValue < 99) {
            quantityInput.value = currentValue + 1;
        }
    });

    // Add to cart form submission
    const addToCartForm = document.getElementById('addToCartForm');
    const addToCartBtn = document.getElementById('addToCartBtn');

    addToCartForm.addEventListener('submit', function(e) {
        addToCartBtn.classList.add('loading');
        addToCartBtn.disabled = true;
    });

    // Star rating functionality
    const starLabels = document.querySelectorAll('.star-label');
    starLabels.forEach(label => {
        label.addEventListener('click', function() {
            const rating = this.getAttribute('for').replace('star', '');
            console.log('Rating selected:', rating);
        });
    });

    // Review form validation
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            const rating = document.querySelector('input[name="rating"]:checked');
            if (!rating) {
                e.preventDefault();
                alert('Please select a rating before submitting your review.');
                return false;
            }
        });
    }

    // Smooth scrolling for review link
    const reviewLink = document.querySelector('.review-link');
    if (reviewLink) {
        reviewLink.addEventListener('click', function(e) {
            e.preventDefault();
            const reviewsTab = document.getElementById('reviews-tab');
            reviewsTab.click();

            setTimeout(() => {
                const reviewsSection = document.getElementById('reviews-section');
                reviewsSection.scrollIntoView({ behavior: 'smooth' });
            }, 300);
        });
    }

    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
</script>
@endsection
