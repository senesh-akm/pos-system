<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">{{ isset($item) ? 'Edit Item' : 'Add Item' }}</h2>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">Whoops! Something went wrong.</strong>
                        <ul class="mt-2">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ isset($item) ? route('items.update', $item->id) : route('items.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
                    @csrf
                    @isset($item)
                        @method('PUT')
                    @endisset

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Item Image</label>
                        <input type="file" name="item_image" accept="image/*" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" onchange="previewImage(event)">

                        @if(isset($item) && $item->item_image)
                            <img id="imagePreview" class="mt-2 max-w-xs rounded-lg shadow-lg" src="{{ asset('storage/' . $item->item_image) }}" style="width: 200px; height: 200px;" />
                        @else
                            <img id="imagePreview" class="mt-2 hidden max-w-xs rounded-lg shadow-lg" style="width: 200px; height: 200px;" />
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Ref. Number</label>
                        <input type="text" name="refnumber" id="refnumber" value="{{ old('refnumber', $refNumber ?? '') }}" readonly class="w-full border rounded-lg px-3 py-2 bg-gray-100">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Product Code</label>
                        <select name="product_code" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required>
                            <option value="" disabled selected>Select Product Code</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ (old('product_code', $item->product_code ?? '') == $product->id) ? 'selected' : '' }}>
                                    {{ $product->product_code }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Item Code</label>
                        <input type="text" name="item_code" value="{{ old('item_code', $item->item_code ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Item Name</label>
                        <input type="text" name="item_name" value="{{ old('item_name', $item->item_name ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Category</label>
                        <select name="category" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('category', $item->category ?? '') == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Barcode</label>
                        <input type="text" name="barcode" id="barcode" value="{{ old('barcode', $item->barcode ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required>
                        <svg class="mt-3" id="barcodeSvg"></svg>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Price (LKR)</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $item->price ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Stock Status</label>
                        <select name="stock" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required>
                            <option value="In Stock" {{ (old('stock', $item->stock ?? '') == 'In Stock') ? 'selected' : '' }}>In Stock</option>
                            <option value="Out of Stock" {{ (old('stock', $item->stock ?? '') == 'Out of Stock') ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('items.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ isset($item) ? 'Update Item' : 'Save Item' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let barcodeInput = document.getElementById("barcode");
            let barcodeSvg = document.getElementById("barcodeSvg");
            let imageInput = document.querySelector("input[name='Item_image']");
            let imagePreview = document.getElementById("imagePreview");

            barcodeInput.addEventListener("input", function () {
                if (barcodeInput.value) {
                    JsBarcode(barcodeSvg, barcodeInput.value, {
                        format: "CODE128",
                        displayValue: true
                    });
                }
            });

            imageInput.addEventListener("change", function (event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove("hidden");
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</x-app-layout>
