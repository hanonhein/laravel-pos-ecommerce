{{-- resources/views/admin/products/edit.blade.php --}}

@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Product: {{ $product->name }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand', $product->brand) }}">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="sale_price" class="form-label">Sale Price (Optional)</label>
                            <input type="number" class="form-control" id="sale_price" name="sale_price" step="0.01" value="{{ old('sale_price', $product->sale_price) }}">
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                        </div>

                        {{-- This is the container where our dynamic dropdowns will be added --}}
                        <div id="category-dropdown-container">
                            {{-- The first dropdown is always visible --}}
                             <div class="mb-3">
                                <label for="category-level-0" class="form-label">Main Category</label>
                                <select class="form-control category-select" id="category-level-0" data-level="0">
                                    <option value="">Select a Category</option>
                                    @foreach ($parentCategories as $category)
                                        {{-- Pre-select the top-level category from our path --}}
                                        <option value="{{ $category->id }}" {{ isset($categoryPath[0]) && $categoryPath[0]->id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- This hidden input will hold the final selected category ID --}}
                        <input type="hidden" name="category_id" id="category_id_hidden" value="{{ $product->category_id }}">

                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                             @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail mt-2" width="150">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary w-100">Update Product</button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- JavaScript for recursive dropdowns on the edit page --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('category-dropdown-container');
        const finalCategoryInput = document.getElementById('category_id_hidden');
        const categoryPath = @json($categoryPath); // Get the category path from PHP

        // Function to create and append a new dropdown
        async function createDropdown(parentId, level, selectedId = null) {
            try {
                const response = await fetch(`/api/subcategories/${parentId}`);
                const subcategories = await response.json();

                if (subcategories.length > 0) {
                    const newDropdownDiv = document.createElement('div');
                    newDropdownDiv.classList.add('mb-3');

                    const newLabel = document.createElement('label');
                    newLabel.setAttribute('for', `category-level-${level}`);
                    newLabel.classList.add('form-label');
                    newLabel.textContent = `Sub-Category (Level ${level})`;

                    const newSelect = document.createElement('select');
                    newSelect.classList.add('form-control', 'category-select');
                    newSelect.id = `category-level-${level}`;
                    newSelect.dataset.level = level;

                    let options = '<option value="">Select a Sub-Category</option>';
                    subcategories.forEach(sub => {
                        const isSelected = selectedId && sub.id == selectedId ? 'selected' : '';
                        options += `<option value="${sub.id}" ${isSelected}>${sub.name}</option>`;
                    });
                    newSelect.innerHTML = options;

                    newDropdownDiv.appendChild(newLabel);
                    newDropdownDiv.appendChild(newSelect);
                    container.appendChild(newDropdownDiv);
                }
            } catch (error) {
                console.error('Error fetching subcategories:', error);
            }
        }

        // On page load, build the initial dropdown chain based on the product's category path
        async function initializePath() {
            for (let i = 0; i < categoryPath.length - 1; i++) {
                const parentId = categoryPath[i].id;
                const childId = categoryPath[i+1].id;
                await createDropdown(parentId, i + 1, childId);
            }
        }

        container.addEventListener('change', async function(e) {
            if (!e.target.classList.contains('category-select')) return;

            const selectedDropdown = e.target;
            const selectedCategoryId = selectedDropdown.value;
            const level = parseInt(selectedDropdown.dataset.level, 10);

            let nextLevel = level + 1;
            let nextDropdown = document.getElementById(`category-level-${nextLevel}`);
            while(nextDropdown) {
                nextDropdown.parentElement.remove();
                nextLevel++;
                nextDropdown = document.getElementById(`category-level-${nextLevel}`);
            }

            finalCategoryInput.value = selectedCategoryId;

            if (selectedCategoryId) {
                await createDropdown(selectedCategoryId, level + 1);
            }
        });

        // Initialize the form when the page loads
        initializePath();
    });
</script>
@endsection
