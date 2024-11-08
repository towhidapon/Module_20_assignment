@extends('layout')

@section('content')
<h2>Product Details</h2>

<p><strong>Product ID:</strong> {{ $product->product_id }}</p>
<p><strong>Name:</strong> {{ $product->name }}</p>
<p><strong>Price:</strong> ${{ $product->price }}</p>
<p><strong>Description:</strong> {{ $product->description }}</p>
<p><strong>Stock:</strong> {{ $product->stock ?? 'N/A' }}</p>

@if ($product->image)
    <div>
        <strong>Image:</strong><br>
        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" style="max-width: 200px;">
    </div>
@endif

<a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Back to Product List</a>
@endsection
