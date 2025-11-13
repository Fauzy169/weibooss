@extends('admin.layout.app')

@section('title', isset($product) ? 'Edit Product' : 'Create Product')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>{{ isset($product) ? 'Edit Product' : 'Create New Product' }}</h3>
        <a href="{{ route('admin.products.index') }}" class="rts-btn btn-secondary">Back to List</a>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id ?? '') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Price (Rp)</label>
                    <input type="number" name="price" class="form-control" step="0.01" value="{{ old('price', $product->price ?? '') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" {{ isset($product) ? '' : 'required' }}>
                    @if(isset($product) && $product->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" width="120" style="object-fit:cover;border-radius:6px;">
                        </div>
                    @endif
                </div>
            </div>
            <button type="submit" class="rts-btn btn-primary">{{ isset($product) ? 'Update Product' : 'Save Product' }}</button>
        </form>
    </div>
</div>
@endsection