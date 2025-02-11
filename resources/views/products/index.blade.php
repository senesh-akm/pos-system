@extends('layouts.app')

@section('content')
<h2>Product List</h2>
<a href="{{ route('products.create') }}">Add Product</a>
<table>
    <tr>
        <th>Name</th>
        <th>Barcode</th>
        <th>Price</th>
        <th>Stock</th>
    </tr>
    @foreach($products as $product)
    <tr>
        <td>{{ $product->name }}</td>
        <td>{{ $product->barcode }}</td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->stock }}</td>
    </tr>
    @endforeach
</table>
@endsection
