{{-- resources/views/admin/categories/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="admin-card-title mb-2">
            <i class="fas fa-tags me-3"></i>Category Management
        </h1>
        <p class="text-muted mb-0">Organize your products with categories and subcategories</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn-admin-primary">
        <i class="fas fa-plus me-2"></i>Add New Category
    </a>
</div>

<!-- Categories Table -->
<div class="admin-card">
    <div class="admin-card-header">
        <h4 class="admin-card-title mb-0">
            <i class="fas fa-list me-2"></i>All Categories
        </h4>
        <div class="card-actions">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" placeholder="Search categories..." id="searchInput">
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
                        <th>Category Name</th>
                        <th style="width: 200px;">Parent Category</th>
                        <th style="width: 120px;">Products</th>
                        <th style="width: 200px;" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        {{-- Parent Category Row --}}
                        <tr class="category-parent">
                            <td><span class="category-id">#{{ $category->id }}</span></td>
                            <td>
                                <div class="category-info">
                                    <div class="category-icon">
                                        <i class="fas fa-folder text-primary"></i>
                                    </div>
                                    <div class="category-details">
                                        <strong class="category-name">{{ $category->name }}</strong>
                                        @if($category->description)
                                            <small class="category-desc">{{ Str::limit($category->description, 50) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">Root Category</span>
                            </td>
                            <td>
                                <span class="product-count">{{ $category->products_count ?? 0 }}</span>
                            </td>
                            <td class="text-end">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}"
                                          method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                title="Delete" data-category="{{ $category->name }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Child Categories Rows --}}
                        @foreach ($category->children as $child)
                            <tr class="category-child">
                                <td><span class="category-id">#{{ $child->id }}</span></td>
                                <td>
                                    <div class="category-info">
                                        <div class="category-icon ms-4">
                                            <i class="fas fa-folder-open text-secondary"></i>
                                        </div>
                                        <div class="category-details">
                                            <span class="category-name">{{ $child->name }}</span>
                                            @if($child->description)
                                                <small class="category-desc">{{ Str::limit($child->description, 50) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $category->name }}</span>
                                </td>
                                <td>
                                    <span class="product-count">{{ $child->products_count ?? 0 }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.categories.edit', $child) }}"
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $child) }}"
                                              method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    title="Delete" data-category="{{ $child->name }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-tags text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                    <h5 class="text-muted">No categories found</h5>
                                    <p class="text-muted">Create your first category to get started</p>
                                    <a href="{{ route('admin.categories.create') }}" class="btn-admin-primary">
                                        <i class="fas fa-plus me-2"></i>Add Category
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($categories->hasPages())
        <div class="card-footer bg-transparent">
            <div class="d-flex justify-content-center">
                {{ $categories->links() }}
            </div>
        </div>
    @endif
</div>

<style>
/* Category Table Styles */
.category-parent {
    background: var(--bg-secondary);
    border-left: 4px solid var(--admin-primary);
}

.category-child {
    background: var(--bg-primary);
}

.category-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.category-icon {
    flex-shrink: 0;
}

.category-details {
    flex-grow: 1;
}

.category-name {
    display: block;
    font-weight: 600;
    color: var(--text-primary);
}

.category-desc {
    display: block;
    color: var(--text-secondary);
    margin-top: 0.25rem;
}

.category-id {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    color: var(--text-secondary);
}

.product-count {
    font-weight: 600;
    color: var(--admin-primary);
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
}

.action-buttons .btn {
    transition: var(--transition);
}

.action-buttons .btn:hover {
    transform: scale(1.1);
}

.empty-state {
    padding: 2rem;
}

/* Search Input */
.input-group-sm .form-control,
.input-group-sm .btn {
    border-radius: var(--border-radius-sm);
}

.card-actions {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

/* Dark Mode */
[data-theme="dark"] .category-parent {
    background: var(--bg-secondary) !important;
}

[data-theme="dark"] .category-child {
    background: var(--bg-primary) !important;
}

[data-theme="dark"] .category-name {
    color: var(--text-primary) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        tableRows.forEach(row => {
            const categoryName = row.querySelector('.category-name');
            if (categoryName) {
                const text = categoryName.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });

    // Delete confirmation
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const categoryName = this.querySelector('button').dataset.category;

            if (confirm(`Are you sure you want to delete "${categoryName}"? This action cannot be undone and will also delete all subcategories.`)) {
                this.submit();
            }
        });
    });
});
</script>
@endsection
