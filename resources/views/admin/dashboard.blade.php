@extends('admin.layout.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Welcome to the Admin Dashboard!</h4>
                <p>This is your central hub for managing all the data on your website. Use the sidebar to navigate through different management sections.</p>
                <div class="d-flex gap-3 mt-3">
                    <div class="badge bg-primary p-3">Categories: <strong>{{ $stats['categories'] ?? 0 }}</strong></div>
                    <div class="badge bg-info p-3">Products: <strong>{{ $stats['products'] ?? 0 }}</strong></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-circle bg-primary text-white me-3">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h5 class="card-title mb-0">Manage Categories</h5>
                </div>
                <p class="card-text">Organize your product categories. Add, edit, or delete categories that will be displayed on your site.</p>
                <div class="mt-auto">
                    <a href="{{ route('admin.categories.index') }}" class="rts-btn btn-primary">Go to Categories</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-circle bg-info text-white me-3">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h5 class="card-title mb-0">Manage Products</h5>
                </div>
                <p class="card-text">Add new products, update existing stock and prices, and manage product details.</p>
                <div class="mt-auto">
                    <a href="{{ route('admin.products.index') }}" class="rts-btn btn-info">Go to Products</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-circle bg-warning text-white me-3">
                        <i class="fas fa-percent"></i>
                    </div>
                    <h5 class="card-title mb-0">Manage Promos</h5>
                </div>
                <p class="card-text">Create and manage promotional offers, discounts, and special deals for your customers.</p>
                <div class="mt-auto">
                    <a href="#" class="rts-btn btn-warning">Go to Promos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .badge { font-size: 14px; }
</style>
@endpush

