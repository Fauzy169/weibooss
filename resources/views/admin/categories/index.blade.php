@extends('admin.layout.app')

@section('title', 'Manage Categories')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Categories</h3>
        <a href="{{ route('admin.categories.create') }}" class="rts-btn btn-primary">Add New Category</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($category->image)
                                    @php $src = Str::startsWith($category->image, ['http', 'https']) ? $category->image : asset('storage/' . $category->image); @endphp
                                    <img src="{{ $src }}" alt="{{ $category->name }}" width="50" height="50" style="object-fit: cover; border-radius: 5px;">
                                @else
                                    <img src="https://via.placeholder.com/50" alt="No Image" width="50" height="50" style="object-fit: cover; border-radius: 5px;">
                                @endif
                            </td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="rts-btn btn-sm btn-info">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rts-btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
