<?php

namespace App\Http\Controllers;

// use App\Events\ProductUpdated;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', ['products' => $products]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'barcode' => 'required|string|max:255|unique:products,barcode',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|string|in:In Stock,Out of Stock',
        ]);

        Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        // $product->update($request->all());
        // broadcast(new ProductUpdated($product));
        // return response()->json(['message' => 'Product updated successfully!']);
    }

    public function destroy(Product $product)
    {
        //
    }
}
