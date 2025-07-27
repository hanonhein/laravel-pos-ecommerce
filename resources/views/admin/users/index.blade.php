{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="admin-container">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="admin-card-title mb-2">
                <i class="fas fa-users me-3"></i>User Management
            </h1>
            <p class="text-muted mb-0">Manage user accounts and permissions</p>
        </div>
        <div class="d-flex gap-2">
            <select class="form-select" id="roleFilter">
                <option value="">All Roles</option>
                <option value="admin">Administrators</option>
                <option value="user">Regular Users</option>
            </select>
            <button class="btn-admin-primary" onclick="exportUsers()">
                <i class="fas fa-download me-2"></i>Export Users
            </button>
        </div>
    </div>

    <!-- User Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card bg-primary">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h4>{{ $users->total() }}</h4>
                    <p>Total Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-success">
                <div class="stat-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="stat-info">
                    <h4>{{ $users->where('is_admin', true)->count() }}</h4>
                    <p>Administrators</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-info">
                <div class="stat-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="stat-info">
                    <h4>{{ $users->where('is_admin', false)->count() }}</h4>
                    <p>Regular Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-warning">
                <div class="stat-icon">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="stat-info">
                    <h4>{{ $users->where('created_at', '>=', now()->subDays(30))->count() }}</h4>
                    <p>New This Month</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h4 class="admin-card-title mb-0">
                <i class="fas fa-list me-2"></i>All Users
            </h4>
            <div class="card-actions">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" placeholder="Search users..." id="searchInput">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="admin-table">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#ID</th>
                            <th>User</th>
                            <th style="width: 120px;">Role</th>
                            <th style="width: 140px;">Joined Date</th>
                            <th style="width: 120px;">Status</th>
                            <th style="width: 180px;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="user-row" data-role="{{ $user->is_admin ? 'admin' : 'user' }}">
                                <td>
                                    <span class="user-id">#{{ $user->id }}</span>
                                </td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="user-details">
                                            <strong class="user-name">{{ $user->name }}</strong>
                                            <small class="user-email text-muted d-block">{{ $user->email }}</small>
                                            @if($user->email_verified_at)
                                                <span class="badge bg-success verified-badge">
                                                    <i class="fas fa-check-circle me-1"></i>Verified
                                                </span>
                                            @else
                                                <span class="badge bg-warning verified-badge">
                                                    <i class="fas fa-exclamation-circle me-1"></i>Unverified
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($user->is_admin)
                                        <span class="badge bg-danger role-badge">
                                            <i class="fas fa-crown me-1"></i>Admin
                                        </span>
                                    @else
                                        <span class="badge bg-secondary role-badge">
                                            <i class="fas fa-user me-1"></i>User
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="join-date">
                                        <strong>{{ $user->created_at->format('M d, Y') }}</strong>
                                        <small class="d-block text-muted">{{ $user->created_at->format('h:i A') }}</small>
                                    </div>
                                </td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="action-buttons">
                                        @if (Auth::id() === $user->id)
                                            <button class="btn btn-sm btn-outline-secondary" disabled title="Cannot modify your own account">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @else
                                            <form action="{{ route('admin.users.toggleAdmin', $user) }}" method="POST" class="d-inline toggle-form">
                                                @csrf
                                                @method('PATCH')
                                                @if ($user->is_admin)
                                                    <button type="submit" class="btn btn-sm btn-outline-warning"
                                                            title="Revoke Admin Rights" data-action="revoke" data-user="{{ $user->name }}">
                                                        <i class="fas fa-user-minus"></i>
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-sm btn-outline-success"
                                                            title="Grant Admin Rights" data-action="grant" data-user="{{ $user->name }}">
                                                        <i class="fas fa-user-plus"></i>
                                                    </button>
                                                @endif
                                            </form>

                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" onclick="viewUserDetails({{ $user->id }})">
                                                        <i class="fas fa-eye me-2"></i>View Details
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="sendPasswordReset('{{ $user->email }}')">
                                                        <i class="fas fa-key me-2"></i>Reset Password
                                                    </a></li>
                                                    @if(!$user->email_verified_at)
                                                        <li><a class="dropdown-item" href="#" onclick="resendVerification({{ $user->id }})">
                                                            <i class="fas fa-envelope me-2"></i>Resend Verification
                                                        </a></li>
                                                    @endif
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="suspendUser({{ $user->id }}, '{{ $user->name }}')">
                                                        <i class="fas fa-ban me-2"></i>Suspend User
                                                    </a></li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-users text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                        <h5 class="text-muted">No users found</h5>
                                        <p class="text-muted">Users will appear here as they register</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($users->hasPages())
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- User Details Modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user me-2"></i>User Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="userDetailsContent">
                <!-- User details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<style>
/* User Table Styles */
.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.user-details {
    flex-grow: 1;
    min-width: 0;
}

.user-name {
    color: var(--text-primary);
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
}

.user-email {
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.verified-badge {
    font-size: 0.65rem;
    padding: 0.25rem 0.5rem;
}

.user-id {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    color: var(--text-secondary);
}

/* Role Badge */
.role-badge {
    font-weight: 600;
    padding: 0.5rem 0.75rem;
    border-radius: var(--border-radius-sm);
    font-size: 0.75rem;
}

/* Join Date */
.join-date strong {
    color: var(--text-primary);
}

.join-date small {
    font-size: 0.8rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
    align-items: center;
}

.action-buttons .btn {
    transition: var(--transition);
}

.action-buttons .btn:hover:not(:disabled) {
    transform: scale(1.05);
}

.action-buttons .btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Modal Styles */
.modal-content {
    border: none;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
}

.modal-header {
    border-bottom: 1px solid var(--border-color);
    background: var(--bg-secondary);
}

.modal-title {
    color: var(--text-primary);
    font-weight: 600;
}

/* User Details in Modal */
.user-detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-color);
}

.user-detail-item:last-child {
    border-bottom: none;
}

.user-detail-label {
    font-weight: 600;
    color: var(--text-secondary);
}

.user-detail-value {
    color: var(--text-primary);
    font-weight: 500;
}

/* Dark Mode */
[data-theme="dark"] .user-name {
    color: var(--text-primary) !important;
}

[data-theme="dark"] .join-date strong {
    color: var(--text-primary) !important;
}

[data-theme="dark"] .modal-content {
    background: var(--bg-primary) !important;
    color: var(--text-primary) !important;
}

[data-theme="dark"] .modal-header {
    background: var(--bg-secondary) !important;
    border-color: var(--border-color) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const userRows = document.querySelectorAll('.user-row');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        userRows.forEach(row => {
            const userName = row.querySelector('.user-name').textContent.toLowerCase();
            const userEmail = row.querySelector('.user-email').textContent.toLowerCase();
            const userId = row.querySelector('.user-id').textContent.toLowerCase();

            if (userName.includes(searchTerm) || userEmail.includes(searchTerm) || userId.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Role filter
    const roleFilter = document.getElementById('roleFilter');
    roleFilter.addEventListener('change', function() {
        const selectedRole = this.value;

        userRows.forEach(row => {
            const userRole = row.dataset.role;
            if (!selectedRole || userRole === selectedRole) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Toggle admin confirmation
    const toggleForms = document.querySelectorAll('.toggle-form');
    toggleForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const button = this.querySelector('button');
            const action = button.dataset.action;
            const userName = button.dataset.user;

            let message;
            if (action === 'grant') {
                message = `Are you sure you want to grant administrator privileges to "${userName}"?`;
            } else {
                message = `Are you sure you want to revoke administrator privileges from "${userName}"?`;
            }

            if (confirm(message)) {
                this.submit();
            }
        });
    });
});

// View user details
function viewUserDetails(userId) {
    fetch(`/admin/users/${userId}/details`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.user;
                const content = `
                    <div class="user-details-content">
                        <div class="text-center mb-4">
                            <div class="user-avatar mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                                ${user.name.charAt(0).toUpperCase()}
                            </div>
                            <h4>${user.name}</h4>
                            <p class="text-muted">${user.email}</p>
                        </div>

                        <div class="user-detail-item">
                            <span class="user-detail-label">User ID:</span>
                            <span class="user-detail-value">#${user.id}</span>
                        </div>

                        <div class="user-detail-item">
                            <span class="user-detail-label">Role:</span>
                            <span class="user-detail-value">
                                <span class="badge bg-${user.is_admin ? 'danger' : 'secondary'}">
                                    ${user.is_admin ? 'Administrator' : 'Regular User'}
                                </span>
                            </span>
                        </div>

                        <div class="user-detail-item">
                            <span class="user-detail-label">Email Status:</span>
                            <span class="user-detail-value">
                                <span class="badge bg-${user.email_verified_at ? 'success' : 'warning'}">
                                    ${user.email_verified_at ? 'Verified' : 'Unverified'}
                                </span>
                            </span>
                        </div>

                        <div class="user-detail-item">
                            <span class="user-detail-label">Member Since:</span>
                            <span class="user-detail-value">${new Date(user.created_at).toLocaleDateString()}</span>
                        </div>

                        <div class="user-detail-item">
                            <span class="user-detail-label">Last Updated:</span>
                            <span class="user-detail-value">${new Date(user.updated_at).toLocaleDateString()}</span>
                        </div>

                        ${user.orders_count !== undefined ? `
                        <div class="user-detail-item">
                            <span class="user-detail-label">Total Orders:</span>
                            <span class="user-detail-value">${user.orders_count}</span>
                        </div>
                        ` : ''}
                    </div>
                `;

                document.getElementById('userDetailsContent').innerHTML = content;
                new bootstrap.Modal(document.getElementById('userDetailsModal')).show();
            } else {
                alert('Error loading user details');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading user details');
        });
}

// Send password reset
function sendPasswordReset(email) {
    if (confirm(`Send password reset email to ${email}?`)) {
        fetch('/admin/users/send-password-reset', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Password reset email sent successfully');
            } else {
                alert('Error sending password reset email');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error sending password reset email');
        });
    }
}

// Resend verification email
function resendVerification(userId) {
    if (confirm('Resend verification email to this user?')) {
        fetch(`/admin/users/${userId}/resend-verification`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Verification email sent successfully');
            } else {
                alert('Error sending verification email');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error sending verification email');
        });
    }
}

// Suspend user
function suspendUser(userId, userName) {
    if (confirm(`Are you sure you want to suspend "${userName}"? This action can be reversed later.`)) {
        fetch(`/admin/users/${userId}/suspend`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error suspending user');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error suspending user');
        });
    }
}

// Export users
function exportUsers() {
    window.open('/admin/users/export', '_blank');
}
</script>
@endsection
