{{-- resources/views/layouts/partials/category-item.blade.php --}}

<li class="list-group-item border-0 py-2">
    @if ($category->allChildren->isNotEmpty())
        {{-- Category with children - collapsible --}}
        <a class="category-collapse-btn text-decoration-none"
           data-bs-toggle="collapse"
           href="#collapse-{{ $category->id }}"
           role="button"
           aria-expanded="false"
           aria-controls="collapse-{{ $category->id }}">
            <div class="d-flex justify-content-between align-items-center w-100">
                <span class="d-flex align-items-center">
                    <i class="fas fa-folder me-2 text-muted"></i>
                    <span class="fw-medium">{{ $category->name }}</span>
                </span>
                <i class="fas fa-chevron-right chevron text-muted" style="font-size: 0.75rem; transition: transform 0.3s ease;"></i>
            </div>
        </a>

        {{-- Nested children with smooth animation --}}
        <div class="collapse" id="collapse-{{ $category->id }}">
            <ul class="list-group list-group-flush ps-3 mt-2">
                @foreach ($category->allChildren as $child)
                    @include('layouts.partials.category-item', ['category' => $child])
                @endforeach
            </ul>
        </div>
    @else
        {{-- Direct category link --}}
        <a href="{{ route('products.byCategory', $category) }}"
           class="text-decoration-none d-flex align-items-center category-link">
            <i class="fas fa-tag me-2 text-muted"></i>
            <span class="fw-medium text-truncate">{{ $category->name }}</span>
        </a>
    @endif
</li>

<style>
    .category-link {
        color: var(--text-primary);
        transition: var(--transition);
        padding: 0.25rem 0;
        border-radius: var(--border-radius-sm);
        width: 100%;
    }

    .category-link:hover {
        color: var(--primary-color);
        background-color: var(--bg-secondary);
        padding-left: 0.5rem;
        padding-right: 0.5rem;
        margin-left: -0.5rem;
        margin-right: -0.5rem;
    }

    .category-link:hover i {
        color: var(--primary-color);
        transform: scale(1.1);
    }

    .category-collapse-btn {
        color: var(--text-primary);
        transition: var(--transition);
        padding: 0.25rem 0;
        border-radius: var(--border-radius-sm);
    }

    .category-collapse-btn:hover {
        color: var(--primary-color);
        background-color: var(--bg-secondary);
        padding-left: 0.5rem;
        padding-right: 0.5rem;
        margin-left: -0.5rem;
        margin-right: -0.5rem;
    }

    .category-collapse-btn:hover i.fas.fa-folder {
        color: var(--primary-color);
        transform: scale(1.1);
    }

    .category-collapse-btn[aria-expanded="true"] .chevron {
        transform: rotate(90deg);
        color: var(--primary-color);
    }

    .category-collapse-btn[aria-expanded="true"] {
        color: var(--primary-color);
    }

    .category-collapse-btn[aria-expanded="true"] i.fas.fa-folder {
        color: var(--primary-color);
    }

    /* Smooth collapse animation */
    .collapse {
        transition: all 0.35s ease;
    }

    .collapsing {
        transition: height 0.35s ease;
    }

    /* Nested category styling */
    .list-group .list-group {
        background: var(--bg-secondary);
        border-radius: var(--border-radius-sm);
        padding: 0.5rem;
        margin-top: 0.5rem;
    }

    .list-group .list-group .list-group-item {
        background: transparent;
        padding: 0.375rem 0;
    }

    /* Icon animations */
    .category-link i,
    .category-collapse-btn i {
        transition: all 0.3s ease;
    }

    /* Text truncation for long category names */
    .text-truncate {
        max-width: 200px;
    }

    @media (max-width: 768px) {
        .text-truncate {
            max-width: 150px;
        }
    }
</style>
