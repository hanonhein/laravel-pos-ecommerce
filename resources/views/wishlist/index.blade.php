{{-- resources/views/wishlist/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 fw-bold mb-2">My Wishlist</h1>
            <p class="text-muted mb-0">Your favorite products, all in one place.</p>
        </div>
    </div>

    <div class="row">
        @forelse($wishlistProducts as $product)
            {{-- We can reuse the same product card structure --}}
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4 product-card">
                 <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 border-0 shadow-sm product-item" style="transition: var(--transition);">
                        <div class="position-relative overflow-hidden" style="height: 220px;">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x220/f8f9fa/6c757d?text=No+Image' }}"
                                 class="card-img-top w-100 h-100"
                                 alt="{{ $product->name }}"
                                 style="object-fit: cover; transition: var(--transition);">
                            @if ($product->sale_price)
                                <div class="position-absolute top-0 start-0 m-2">
                                    <span class="badge bg-danger px-2 py-1">SALE</span>
                                </div>
                            @endif
                            <div class="position-absolute top-0 end-0 m-2 d-flex flex-column gap-2 quick-actions" style="opacity: 1;">
                                <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-light btn-sm rounded-circle p-2" title="Remove from Wishlist">
                                        <i class="fas fa-heart text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column p-3">
                            <h5 class="card-title fw-semibold mb-2 text-truncate" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h5>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div class="price-section">
                                    @if ($product->sale_price)
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="h6 text-danger mb-0 fw-bold">${{ number_format($product->sale_price, 2) }}</span>
                                            <del class="text-muted small">${{ number_format($product->price, 2) }}</del>
                                        </div>
                                    @else
                                        <span class="h6 text-primary mb-0 fw-bold">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-primary btn-sm px-3" title="View Details">
                                    View Product
                                </a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4" style="font-size: 4rem; color: var(--text-secondary); opacity: 0.5;">
                        <i class="far fa-heart"></i>
                    </div>
                    <h3 class="h4 mb-3">Your wishlist is empty</h3>
                    <p class="text-muted mb-4">Add products you love to your wishlist to see them here.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Start Shopping
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if($wishlistProducts->hasPages())
        <div class="d-flex justify-content-center mt-5">
            <nav aria-label="Wishlist pagination">
                {{ $wishlistProducts->links() }}
            </nav>
        </div>
    @endif
</div>
@endsection
