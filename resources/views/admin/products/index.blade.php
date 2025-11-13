@extends('admin.layout.app')

@section('title', 'Manage Products')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Products</h3>
        <a href="{{ route('admin.products.create') }}" class="rts-btn btn-primary">Add New Product</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($product->image)
                                    @php $src = Str::startsWith($product->image, ['http', 'https']) ? $product->image : asset('storage/' . $product->image); @endphp
                                    <img src="{{ $src }}" alt="{{ $product->name }}" width="50" height="50" style="object-fit:cover;border-radius:5px;">
                                @else
                                    <img src="https://via.placeholder.com/50" alt="No Image" width="50" height="50" style="object-fit:cover;border-radius:5px;">
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}" class="rts-btn btn-sm btn-info">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rts-btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection