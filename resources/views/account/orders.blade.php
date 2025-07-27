{{-- resources/views/account/orders.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 fw-bold mb-2">
                        <i class="fas fa-box me-3 text-primary"></i>My Orders
                    </h1>
                    <p class="text-muted mb-0">Track and manage your order history</p>
                </div>

                <!-- Order Summary Stats -->
                <div class="d-none d-md-block">
                    <div class="row g-3 text-center">
                        <div class="col">
                            <div class="stat-card">
                                <div class="stat-number text-primary">{{ $orders->total() }}</div>
                                <div class="stat-label">Total Orders</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="stat-card">
                                <div class="stat-number text-success">{{ $orders->where('status', 'delivered')->count() }}</div>
                                <div class="stat-label">Delivered</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="stat-card">
                                <div class="stat-number text-warning">{{ $orders->where('status', 'pending')->count() }}</div>
                                <div class="stat-label">Pending</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Section -->
    <div class="row justify-content-center">
        <div class="col-12">
            @forelse ($orders as $order)
                <div class="order-card mb-4" data-order-id="{{ $order->id }}">
                    <div class="card border-0 shadow-sm h-100">
                        <!-- Order Header -->
                        <div class="card-header bg-transparent border-0 p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="order-info">
                                    <h5 class="card-title mb-2 fw-bold">
                                        Order #{{ $order->order_number }}
                                    </h5>
                                    <div class="order-meta d-flex flex-wrap gap-3 text-muted small">
                                        <span><i class="fas fa-calendar me-1"></i>{{ $order->created_at->format('M d, Y') }}</span>
                                        <span><i class="fas fa-clock me-1"></i>{{ $order->created_at->format('h:i A') }}</span>
                                        <span><i class="fas fa-cube me-1"></i>{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}</span>
                                    </div>
                                </div>

                                <div class="order-actions d-flex align-items-center gap-3">
                                    <div class="text-end">
                                        <div class="order-total h5 mb-1 fw-bold text-primary">
                                            ${{ number_format($order->total_amount, 2) }}
                                        </div>
                                        <div class="order-status">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'warning',
                                                    'processing' => 'info',
                                                    'shipped' => 'primary',
                                                    'delivered' => 'success',
                                                    'cancelled' => 'danger'
                                                ];
                                                $statusColor = $statusColors[$order->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $statusColor }} px-3 py-2">
                                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <button class="btn btn-outline-primary btn-sm toggle-details"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#orderDetails{{ $order->id }}"
                                            aria-expanded="false">
                                        <i class="fas fa-chevron-down transition-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Order Details (Collapsible) -->
                        <div class="collapse" id="orderDetails{{ $order->id }}">
                            <div class="card-body border-top p-4">
                                <!-- Shipping Information -->
                                <div class="shipping-info mb-4">
                                    <h6 class="fw-semibold mb-3">
                                        <i class="fas fa-shipping-fast me-2 text-primary"></i>Shipping Information
                                    </h6>
                                    <div class="shipping-address bg-light p-3 rounded-3">
                                        <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                        {{ $order->shipping_address }}
                                    </div>
                                </div>

                                <!-- Order Items -->
                                <div class="order-items">
                                    <h6 class="fw-semibold mb-3">
                                        <i class="fas fa-list me-2 text-primary"></i>Order Items
                                    </h6>
                                    <div class="items-list">
                                        @foreach ($order->items as $item)
                                            <div class="item-card border rounded-3 p-3 mb-3">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center">
                                                            <div class="item-image me-3">
                                                                <div class="image-placeholder bg-light rounded-2 d-flex align-items-center justify-content-center"
                                                                     style="width: 60px; height: 60px;">
                                                                    <i class="fas fa-cube text-muted"></i>
                                                                </div>
                                                            </div>
                                                            <div class="item-details">
                                                                <h6 class="item-name mb-1 fw-semibold">{{ $item->product_name }}</h6>
                                                                <div class="item-meta text-muted small">
                                                                    <span class="me-3">Qty: {{ $item->quantity }}</span>
                                                                    <span>Unit Price: ${{ number_format($item->price, 2) }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 text-md-center">
                                                        <div class="quantity-badge">
                                                            <span class="badge bg-light text-dark px-3 py-2">
                                                                {{ $item->quantity }}x
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 text-md-end">
                                                        <div class="item-total">
                                                            <span class="h6 fw-bold text-primary mb-0">
                                                                ${{ number_format($item->price * $item->quantity, 2) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Order Summary -->
                                <div class="order-summary mt-4 pt-3 border-top">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="order-actions-buttons d-flex gap-2">
                                                @if($order->status === 'delivered')
                                                    <button class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-redo me-1"></i>Reorder
                                                    </button>
                                                    <button class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-file-invoice me-1"></i>Invoice
                                                    </button>
                                                @elseif($order->status === 'pending')
                                                    <button class="btn btn-outline-danger btn-sm">
                                                        <i class="fas fa-times me-1"></i>Cancel Order
                                                    </button>
                                                @endif
                                                <button class="btn btn-outline-info btn-sm">
                                                    <i class="fas fa-truck me-1"></i>Track Order
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="total-breakdown text-md-end">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">Subtotal:</span>
                                                    <span>${{ number_format($order->items->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">Shipping:</span>
                                                    <span class="text-success">Free</span>
                                                </div>
                                                <div class="d-flex justify-content-between border-top pt-2">
                                                    <span class="fw-bold">Total:</span>
                                                    <span class="fw-bold text-primary h6 mb-0">${{ number_format($order->total_amount, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="empty-state text-center py-5">
                    <div class="empty-icon mb-4">
                        <i class="fas fa-box-open text-muted" style="font-size: 5rem; opacity: 0.3;"></i>
                    </div>
                    <h3 class="h4 mb-3">No Orders Yet</h3>
                    <p class="text-muted mb-4 lead">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                    <div class="empty-actions">
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4 me-3">
                            <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg px-4">
                            <i class="fas fa-home me-2"></i>Go Home
                        </a>
                    </div>
                </div>
            @endforelse

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="pagination-wrapper mt-5 d-flex justify-content-center">
                    <nav aria-label="Orders pagination">
                        {{ $orders->links() }}
                    </nav>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Order Cards Styling */
.order-card {
    transition: var(--transition);
    animation: fadeInUp 0.6s ease-out forwards;
}

.order-card:hover {
    transform: translateY(-2px);
}

.order-card:hover .card {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
}

/* Page Header */
.page-header {
    padding: 2rem 0;
    border-bottom: 2px solid var(--border-color);
    margin-bottom: 2rem;
}

/* Stat Cards */
.stat-card {
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: var(--border-radius-sm);
    border: 1px solid var(--border-color);
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Order Header */
.card-header {
    background: linear-gradient(135deg, var(--bg-primary), var(--bg-secondary)) !important;
}

.order-meta span {
    display: inline-flex;
    align-items: center;
}

/* Order Status Badges */
.badge {
    font-weight: 500;
    letter-spacing: 0.25px;
}

/* Toggle Button */
.toggle-details {
    width: 40px;
    height: 40px;
    border-radius: 50% !important;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}

.toggle-details:hover {
    transform: scale(1.1);
}

.toggle-details[aria-expanded="true"] .transition-icon {
    transform: rotate(180deg);
}

.transition-icon {
    transition: transform 0.3s ease;
}

/* Shipping Info */
.shipping-address {
    background: var(--bg-secondary) !important;
    border: 1px solid var(--border-color);
    font-weight: 500;
}

/* Item Cards */
.item-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color) !important;
    transition: var(--transition);
}

.item-card:hover {
    background: var(--bg-primary);
    border-color: var(--primary-color) !important;
    transform: translateX(5px);
}

.image-placeholder {
    background: var(--bg-tertiary) !important;
    border: 1px solid var(--border-color);
}

.item-name {
    color: var(--text-primary);
    font-size: 1rem;
}

.item-meta {
    font-size: 0.875rem;
}

/* Quantity Badge */
.quantity-badge .badge {
    font-size: 0.875rem;
    background: var(--bg-tertiary) !important;
    color: var(--text-primary) !important;
    border: 1px solid var(--border-color);
}

/* Order Summary */
.total-breakdown {
    background: var(--bg-secondary);
    padding: 1rem;
    border-radius: var(--border-radius-sm);
    border: 1px solid var(--border-color);
}

/* Action Buttons */
.order-actions-buttons .btn {
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
    transition: var(--transition);
}

.order-actions-buttons .btn:hover {
    transform: translateY(-1px);
}

/* Empty State */
.empty-state {
    background: var(--bg-secondary);
    border-radius: var(--border-radius);
    border: 2px dashed var(--border-color);
    margin: 3rem 0;
    padding: 4rem 2rem;
}

.empty-icon {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* Dark Mode Specific Overrides */
[data-theme="dark"] .card-header {
    background: linear-gradient(135deg, var(--bg-primary), var(--bg-secondary)) !important;
}

[data-theme="dark"] .shipping-address {
    background: var(--bg-secondary) !important;
    color: var(--text-primary) !important;
}

[data-theme="dark"] .item-card {
    background: var(--bg-secondary) !important;
    color: var(--text-primary) !important;
}

[data-theme="dark"] .item-card:hover {
    background: var(--bg-tertiary) !important;
}

[data-theme="dark"] .total-breakdown {
    background: var(--bg-secondary) !important;
    color: var(--text-primary) !important;
}

[data-theme="dark"] .empty-state {
    background: var(--bg-secondary) !important;
    border-color: var(--border-color) !important;
    color: var(--text-primary) !important;
}

[data-theme="dark"] .stat-card {
    background: var(--bg-secondary) !important;
    color: var(--text-primary) !important;
}

[data-theme="dark"] .image-placeholder {
    background: var(--bg-tertiary) !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        text-align: center;
        padding: 1rem 0;
    }

    .order-info, .order-actions {
        text-align: center;
        width: 100%;
    }

    .order-actions {
        margin-top: 1rem;
    }

    .item-card .row > div {
        text-align: center;
        margin-bottom: 0.5rem;
    }

    .total-breakdown {
        margin-top: 1rem;
    }

    .order-actions-buttons {
        justify-content: center;
        margin-bottom: 1rem;
    }
}

/* Animation Delays */
.order-card:nth-child(1) { animation-delay: 0.1s; }
.order-card:nth-child(2) { animation-delay: 0.2s; }
.order-card:nth-child(3) { animation-delay: 0.3s; }
.order-card:nth-child(4) { animation-delay: 0.4s; }
.order-card:nth-child(5) { animation-delay: 0.5s; }

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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced accordion functionality
    const toggleButtons = document.querySelectorAll('.toggle-details');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const icon = this.querySelector('.transition-icon');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';

            // Update icon rotation
            if (isExpanded) {
                icon.style.transform = 'rotate(0deg)';
            } else {
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });

    // Order tracking simulation (for demo purposes)
    const trackButtons = document.querySelectorAll('.btn:contains("Track Order")');
    trackButtons.forEach(button => {
        if (button.textContent.includes('Track Order')) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                // You can integrate with real tracking API here
                alert('Order tracking functionality would be integrated here!');
            });
        }
    });

    // Reorder functionality
    const reorderButtons = document.querySelectorAll('.btn:contains("Reorder")');
    reorderButtons.forEach(button => {
        if (button.textContent.includes('Reorder')) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                // Add reorder logic here
                alert('Reorder functionality would be implemented here!');
            });
        }
    });

    // Cancel order functionality
    const cancelButtons = document.querySelectorAll('.btn:contains("Cancel")');
    cancelButtons.forEach(button => {
        if (button.textContent.includes('Cancel')) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to cancel this order?')) {
                    // Add cancel order logic here
                    alert('Order cancellation would be processed here!');
                }
            });
        }
    });

    // Smooth scrolling for pagination
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
});
</script>
@endsection
