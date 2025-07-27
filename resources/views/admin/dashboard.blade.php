{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="dashboard-container">
    <!-- Welcome Header -->
    <div class="dashboard-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="dashboard-title">
                    <i class="fas fa-tachometer-alt me-3"></i>
                    Welcome back, {{ Auth::user()->name }}!
                </h1>
                <p class="dashboard-subtitle">Here's what's happening with your store today</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="dashboard-date">
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{ now()->format('l, F j, Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="admin-card stats-card">
                <div class="card-body">
                    <div class="stats-content">
                        <div class="stats-icon bg-primary">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stats-info">
                            <h3 class="stats-number">{{ $productCount }}</h3>
                            <p class="stats-label">Total Products</p>
                            <div class="stats-trend">
                                <i class="fas fa-arrow-up text-success"></i>
                                <span class="text-success">12% from last month</span>
                            </div>
                        </div>
                    </div>
                    <div class="stats-action">
                        <a href="{{ route('admin.products.index') }}" class="btn-admin-primary">
                            <i class="fas fa-cog me-2"></i>Manage
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="admin-card stats-card">
                <div class="card-body">
                    <div class="stats-content">
                        <div class="stats-icon bg-success">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stats-info">
                            <h3 class="stats-number">{{ $orderCount }}</h3>
                            <p class="stats-label">Total Orders</p>
                            <div class="stats-trend">
                                <i class="fas fa-arrow-up text-success"></i>
                                <span class="text-success">8% from last month</span>
                            </div>
                        </div>
                    </div>
                    <div class="stats-action">
                        <a href="{{ route('admin.orders.index') }}" class="btn-admin-primary">
                            <i class="fas fa-eye me-2"></i>View Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="admin-card stats-card">
                <div class="card-body">
                    <div class="stats-content">
                        <div class="stats-icon bg-info">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-info">
                            <h3 class="stats-number">{{ $userCount }}</h3>
                            <p class="stats-label">Registered Users</p>
                            <div class="stats-trend">
                                <i class="fas fa-arrow-up text-success"></i>
                                <span class="text-success">15% from last month</span>
                            </div>
                        </div>
                    </div>
                    <div class="stats-action">
                        <a href="{{ route('admin.users.index') }}" class="btn-admin-primary">
                            <i class="fas fa-user-cog me-2"></i>Manage Users
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="admin-card stats-card">
                <div class="card-body">
                    <div class="stats-content">
                        <div class="stats-icon bg-warning">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stats-info">
                            <h3 class="stats-number">$24.5K</h3>
                            <p class="stats-label">Monthly Revenue</p>
                            <div class="stats-trend">
                                <i class="fas fa-arrow-up text-success"></i>
                                <span class="text-success">23% from last month</span>
                            </div>
                        </div>
                    </div>
                    <div class="stats-action">
                        <a href="#" class="btn-admin-primary">
                            <i class="fas fa-chart-line me-2"></i>View Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h4 class="admin-card-title">
                        <i class="fas fa-chart-area me-2"></i>
                        Sales Overview
                    </h4>
                    <div class="card-actions">
                        <select class="form-select form-select-sm">
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                            <option>Last 3 months</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="salesChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card h-100">
                <div class="admin-card-header">
                    <h4 class="admin-card-title">
                        <i class="fas fa-bolt me-2"></i>
                        Quick Actions
                    </h4>
                </div>
                <div class="card-body">
                    <div class="quick-actions">
                        <a href="{{ route('admin.products.create') }}" class="quick-action-item">
                            <div class="quick-action-icon bg-primary">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="quick-action-content">
                                <h6>Add Product</h6>
                                <p>Create a new product listing</p>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>

                        <a href="{{ route('admin.categories.create') }}" class="quick-action-item">
                            <div class="quick-action-icon bg-success">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="quick-action-content">
                                <h6>Add Category</h6>
                                <p>Create product categories</p>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>

                        <a href="{{ route('admin.orders.index') }}" class="quick-action-item">
                            <div class="quick-action-icon bg-warning">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="quick-action-content">
                                <h6>Process Orders</h6>
                                <p>Manage pending orders</p>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>

                        <a href="{{ route('admin.users.index') }}" class="quick-action-item">
                            <div class="quick-action-icon bg-info">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div class="quick-action-content">
                                <h6>User Management</h6>
                                <p>Manage user accounts</p>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h4 class="admin-card-title">
                        <i class="fas fa-clock me-2"></i>
                        Recent Orders
                    </h4>
                    <div class="card-actions">
                        <a href="{{ route('admin.orders.index') }}" class="btn-admin-secondary">View All</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="admin-table">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Sample data - replace with actual recent orders -->
                                <tr>
                                    <td><strong>#ORD-001</strong></td>
                                    <td>John Doe</td>
                                    <td><strong>$299.99</strong></td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td>2 hours ago</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>#ORD-002</strong></td>
                                    <td>Jane Smith</td>
                                    <td><strong>$199.50</strong></td>
                                    <td><span class="badge bg-success">Delivered</span></td>
                                    <td>5 hours ago</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>#ORD-003</strong></td>
                                    <td>Bob Johnson</td>
                                    <td><strong>$89.99</strong></td>
                                    <td><span class="badge bg-info">Processing</span></td>
                                    <td>1 day ago</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Specific Styles */
.dashboard-container {
    max-width: none;
    padding: 0;
}

.dashboard-header {
    background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
    color: white;
    padding: 2rem;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
}

.dashboard-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
}

.dashboard-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
}

.dashboard-date {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.75rem 1.5rem;
    border-radius: var(--border-radius-sm);
    font-weight: 500;
}

/* Enhanced Stats Cards */
.stats-card {
    border: none;
    overflow: hidden;
    position: relative;
    transition: var(--transition);
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
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
}

.stats-content {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin-right: 1rem;
    flex-shrink: 0;
}

.stats-info {
    flex-grow: 1;
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    color: var(--text-primary);
}

.stats-label {
    color: var(--text-secondary);
    margin: 0;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.875rem;
}

.stats-trend {
    margin-top: 0.5rem;
    font-size: 0.875rem;
}

.stats-action {
    border-top: 1px solid var(--border-color);
    padding-top: 1rem;
}

/* Quick Actions */
.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.quick-action-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    border-radius: var(--border-radius-sm);
    border: 2px solid var(--border-color);
    text-decoration: none;
    color: var(--text-primary);
    transition: var(--transition);
}

.quick-action-item:hover {
    color: var(--text-primary);
    border-color: var(--admin-primary);
    background: var(--bg-secondary);
    transform: translateX(5px);
}

.quick-action-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 1rem;
    flex-shrink: 0;
}

.quick-action-content {
    flex-grow: 1;
}

.quick-action-content h6 {
    margin: 0;
    font-weight: 600;
    font-size: 1rem;
}

.quick-action-content p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

/* Chart Container */
.chart-container {
    position: relative;
    height: 300px;
    width: 100%;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-header {
        text-align: center;
        padding: 1.5rem;
    }

    .dashboard-title {
        font-size: 1.5rem;
    }

    .stats-content {
        flex-direction: column;
        text-align: center;
    }

    .stats-icon {
        margin-right: 0;
        margin-bottom: 1rem;
    }

    .quick-action-item {
        padding: 0.75rem;
    }
}

/* Dark Mode Overrides */
[data-theme="dark"] .dashboard-header {
    background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
}

[data-theme="dark"] .stats-card {
    background: var(--bg-primary) !important;
}

[data-theme="dark"] .quick-action-item {
    background: var(--bg-primary) !important;
    border-color: var(--border-color) !important;
}

[data-theme="dark"] .quick-action-item:hover {
    background: var(--bg-secondary) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Chart (if Chart.js is available)
    const ctx = document.getElementById('salesChart');
    if (ctx && typeof Chart !== 'undefined') {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Sales',
                    data: [1200, 1900, 3000, 5000, 2000, 3000, 4500],
                    borderColor: 'rgb(108, 92, 231)',
                    backgroundColor: 'rgba(108, 92, 231, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Animate stats numbers on page load
    const statsNumbers = document.querySelectorAll('.stats-number');
    statsNumbers.forEach(stat => {
        const finalValue = parseInt(stat.textContent.replace(/[^0-9]/g, ''));
        let currentValue = 0;
        const increment = Math.ceil(finalValue / 50);

        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                currentValue = finalValue;
                clearInterval(timer);
            }

            // Format number (add K, M suffixes)
            let displayValue = currentValue;
            if (currentValue >= 1000) {
                displayValue = (currentValue / 1000).toFixed(1) + 'K';
            }
            if (stat.textContent.includes('$')) {
                stat.textContent = '$' + displayValue;
            } else {
                stat.textContent = displayValue;
            }
        }, 30);
    });
});
</script>
@endsection
