<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        $lastItem = Item::latest()->first();
        $nextNumber = '001';

        if ($lastItem && preg_match('/POS(\d{6})(\d{3})/', $lastItem->refnumber, $matches)) {
            $lastCount = intval($matches[3]);
            $nextNumber = str_pad($lastCount + 1, 3, '0', STR_PAD_LEFT);
        }

        $today = now();
        $refNumber = 'POS' . $today->format('ymd') . $nextNumber;

        $categories = Category::all();
        $products = Product::all();

        return view('items.create', compact('refNumber', 'categories', 'products'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'item_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'refnumber' => 'required|string',
            'product_code' => 'nullable|string|max:255',
            'item_code' => 'nullable|string|max:255',
            'item_name' => 'required|string|max:255',
            'category' => 'required|string',
            'barcode' => 'required|string|max:255|unique:items,barcode',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|string|in:In Stock,Out of Stock',
        ]);

        if ($request->hasFile('item_image')) {
            $imagePath = $request->file('item_image')->store('item_images', 'public');
            $validatedData['item_image'] = $imagePath;
        }

        Item::create($validatedData);

        return redirect()->route('items.index')->with('success', 'Item added successfully!');
    }

    public function edit(Item $item)
    {
        $products = Product::all();
        $categories = Category::all();
        $refNumber = $item->refnumber;
        return view('items.create', compact('item', 'products', 'categories', 'refNumber'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'item_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'refnumber' => 'required|string',
            'product_code' => 'nullable|string|max:255',
            'item_code' => 'nullable|string|max:255',
            'item_name' => 'required|string|max:255',
            'category' => 'required|string',
            'barcode' => 'required|string|max:255|unique:items,barcode,' . $item->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|string|in:In Stock,Out of Stock',
        ]);

        if ($request->hasFile('item_image')) {
            if ($item->item_image) {
                Storage::disk('public')->delete($item->item_image);
            }
            $imagePath = $request->file('item_image')->store('item_images', 'public');
            $validatedData['item_image'] = $imagePath;
        }

        $item->update($request->all());

        return redirect()->route('items.index')->with('success', 'Item updated successfully!');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }

    public function getProductDetails($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $category = Category::find($product->category_id);

        return response()->json([
            'product_image' => asset('storage/' . $product->product_image),
            'category_id' => $category ? $category->id : null,
            'category' => $category ? $category->name : 'N/A',
            'price' => $product->price
        ]);
    }
}
