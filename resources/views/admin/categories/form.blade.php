@extends('admin.layout.app')

@section('title', isset($category) ? 'Edit Category' : 'Create Category')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>{{ isset($category) ? 'Edit Category' : 'Create New Category' }}</h3>
        <a href="{{ route('admin.categories.index') }}" class="rts-btn btn-secondary">Back to List</a>
    </div>
    <div class="card-body">
        <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif

            <div class="form-group mb-3">
                <label for="name">Category Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required>
                @error('name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="image">Category Image</label>
                <input type="file" id="image" name="image" class="form-control">
                @if(isset($category) && $category->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" width="100">
                        <p class="text-muted">Current Image</p>
                    </div>
                @endif
                 @error('image')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="rts-btn btn-primary">{{ isset($category) ? 'Update Category' : 'Save Category' }}</button>
        </form>
    </div>
</div>
@endsection
