{{-- resources/views/admin/categories/edit.blade.php --}}

@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Category: {{ $category->name }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Use PUT for updates --}}

        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="parent_id" class="form-label">Parent Category</label>
                    <select class="form-control" id="parent_id" name="parent_id">
                        <option value="">-- None (Top Level) --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Category Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    @if ($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="img-thumbnail mt-2" width="150">
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Update Category</button>
            </div>
        </div>
    </form>
</div>
@endsection
