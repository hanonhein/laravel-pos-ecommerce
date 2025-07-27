{{-- resources/views/admin/products/create.blade.php --}}

@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Add New Product</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand') }}">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">


                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="sale_price" class="form-label">Sale Price (Optional)</label>
                            <input type="number" class="form-control" id="sale_price" name="sale_price" step="0.01" value="{{ old('sale_price') }}">
                        </div>




                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', 0) }}" required>
                        </div>

                        {{-- This is the container where our dynamic dropdowns will be added --}}
                        <div id="category-dropdown-container">
                             <div class="mb-3">
                                <label for="category-level-0" class="form-label">Main Category</label>
                                <select class="form-control category-select" id="category-level-0" data-level="0">
                                    <option value="">Select a Category</option>
                                    @foreach ($parentCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- This hidden input will hold the final selected category ID --}}
                        <input type="hidden" name="category_id" id="category_id_hidden">

                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary w-100">Save Product</button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- New, more advanced JavaScript for recursive dropdowns --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('category-dropdown-container');
        const finalCategoryInput = document.getElementById('category_id_hidden');

        container.addEventListener('change', async function(e) {
            // Ensure the event was triggered by one of our category dropdowns
            if (!e.target.classList.contains('category-select')) {
                return;
            }

            const selectedDropdown = e.target;
            const selectedCategoryId = selectedDropdown.value;
            const level = parseInt(selectedDropdown.dataset.level, 10);

            // Remove all dropdowns that are deeper than the one that was just changed
            let nextLevel = level + 1;
            let nextDropdown = document.getElementById(`category-level-${nextLevel}`);
            while(nextDropdown) {
                nextDropdown.parentElement.remove();
                nextLevel++;
                nextDropdown = document.getElementById(`category-level-${nextLevel}`);
            }

            // Update the hidden input with the most specific category selected
            finalCategoryInput.value = selectedCategoryId;

            // If a valid category is selected, try to fetch its children
            if (selectedCategoryId) {
                try {
                    const response = await fetch(`/api/subcategories/${selectedCategoryId}`);
                    const subcategories = await response.json();

                    // If there are subcategories, create and append a new dropdown
                    if (subcategories.length > 0) {
                        const newLevel = level + 1;
                        const newDropdownDiv = document.createElement('div');
                        newDropdownDiv.classList.add('mb-3');

                        const newLabel = document.createElement('label');
                        newLabel.setAttribute('for', `category-level-${newLevel}`);
                        newLabel.classList.add('form-label');
                        newLabel.textContent = `Sub-Category (Level ${newLevel})`;

                        const newSelect = document.createElement('select');
                        newSelect.classList.add('form-control', 'category-select');
                        newSelect.id = `category-level-${newLevel}`;
                        newSelect.dataset.level = newLevel;

                        let options = '<option value="">Select a Sub-Category</option>';
                        subcategories.forEach(sub => {
                            options += `<option value="${sub.id}">${sub.name}</option>`;
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
        });
    });
</script>
@endsection
