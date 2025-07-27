{{-- resources/views/search/results.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            {{-- Display the search query and the number of results found --}}
            <h1 class="display-5 fw-light mb-4">
                Search Results for: <span class="text-primary">"{{ $query }}"</span>
            </h1>
            <p class="text-muted">{{ $products->total() }} products found.</p>
            <hr>
        </div>
    </div>

    <div class="row">
        @forelse($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                {{-- This is your existing, excellent card component --}}
                <div class="card h-100 border-0 shadow-sm">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x200' }}"
                         class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            {{ Str::limit($product->description, 80) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="h5 text-primary mb-0">${{ number_format($product->price, 2) }}</span>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            {{-- Message shown when no products match the search --}}
            <div class="col-12 text-center">
                <div class="card border-0 shadow-sm py-5">
                    <div class="card-body">
                        <h3 class="card-title">No products found for "{{ $query }}".</h3>
                        <p class="card-text text-muted">Please try a different search term.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Back to Products</a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex flex-column align-items-center mt-4">
        {{-- Add the original query to the pagination links to preserve the search --}}
        {{ $products->appends(['query' => $query])->links() }}
    </div>
</div>
@endsection
