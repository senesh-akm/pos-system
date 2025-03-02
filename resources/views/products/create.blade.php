<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">{{ isset($products) ? 'Edit Product' : 'Add Product' }}</h2>

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

                <form action="{{ isset($products) ? route('products.update', $product->id) : route('products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
                    @csrf
                    @isset($product)
                        @method('PUT')
                    @endisset

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Product Image</label>
                        <input type="file" name="product_image" accept="image/*" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100">
                        <img id="imagePreview" class="mt-2 hidden max-w-xs rounded-lg shadow-lg" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Product Code</label>
                        <input type="text" name="product_code" value="{{ old('product_code', $product->product_code ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Category</label>
                        <select name="category" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('category', $product->category ?? '') == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Price (LKR)</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Stock Status</label>
                        <select name="stock" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required>
                            <option value="In Stock" {{ (old('stock', $product->stock ?? '') == 'In Stock') ? 'selected' : '' }}>In Stock</option>
                            <option value="Out of Stock" {{ (old('stock', $product->stock ?? '') == 'Out of Stock') ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ isset($products) ? 'Update Product' : 'Save Product' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('productImageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imagePreview = document.getElementById('imagePreview');
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
