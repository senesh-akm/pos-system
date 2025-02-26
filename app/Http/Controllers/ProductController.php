<?php

namespace App\Http\Controllers;

// use App\Events\ProductUpdated;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $lastProduct = Product::latest()->first();
        $nextNumber = '001';

        if ($lastProduct && preg_match('/POS(\d{6})(\d{3})/', $lastProduct->refnumber, $matches)) {
            $lastCount = intval($matches[3]); // Extract last two digits
            $nextNumber = str_pad($lastCount + 1, 3, '0', STR_PAD_LEFT);
        }

        $today = now();
        $refNumber = 'POS' . $today->format('ymd') . $nextNumber;

        return view('products.create', compact('refNumber'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'refnumber' => 'required|string',
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'barcode' => 'required|string|max:255|unique:products,barcode',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|string|in:In Stock,Out of Stock',
        ]);

        if ($request->hasFile('product_image')) {
            $imagePath = $request->file('product_image')->store('product_images', 'public');
            $validatedData['product_image'] = $imagePath;
        }

        Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function edit(Product $product)
    {
        return view('products.create', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'refnumber' => 'required|string',
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'barcode' => 'required|string|unique:products,barcode,' . $product->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|in:In Stock,Out of Stock',
        ]);

        if ($request->hasFile('product_image')) {
            if ($product->product_image) {
                Storage::disk('public')->delete($product->product_image);
            }
            $imagePath = $request->file('product_image')->store('product_images', 'public');
            $validatedData['product_image'] = $imagePath;
        }

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
