<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Add Product</h2>
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
                <form action="{{ route('products.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Product Name</label>
                        <input type="text" name="name" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Barcode</label>
                        <input type="text" name="barcode" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Price (LKR)</label>
                        <input type="number" step="0.01" name="price" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Stock Status</label>
                        <select name="stock" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required>
                            <option>In Stock</option>
                            <option>Out of Stock</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
