@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Product List</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Create New Product</a>
    </div>

    <form action="{{ route('products.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Product ID or Description" value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-secondary" type="submit">Search</button>
            </div>
        </div>
    </form>


    <div class="mb-3">
        <strong>Sort By:</strong>
        <a href="{{ route('products.index', ['sort' => 'name_asc'] + request()->except('page')) }}" class="btn btn-link">Name (A-Z)</a>
        <a href="{{ route('products.index', ['sort' => 'name_desc'] + request()->except('page')) }}" class="btn btn-link">Name (Z-A)</a>
        <a href="{{ route('products.index', ['sort' => 'price_asc'] + request()->except('page')) }}" class="btn btn-link">Price (Low to High)</a>
        <a href="{{ route('products.index', ['sort' => 'price_desc'] + request()->except('page')) }}" class="btn btn-link">Price (High to Low)</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100px; height: auto;">
                        @else
                            <span>No Image</span>
                        @endif
                    </td>
                    <td>{{ $product->product_id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description ?? 'N/A' }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->appends(['search' => request('search'), 'sort' => request('sort')])->links('pagination::bootstrap-4') }}
    </div>
@endsection
