<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Inventory List</h2>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 px-4 py-2">Product</th>
                                <th class="border border-gray-300 px-4 py-2">Item Price</th>
                                <th class="border border-gray-300 px-4 py-2">Quantity</th>
                                <th class="border border-gray-300 px-4 py-2">Alert</th>
                                <th class="border border-gray-300 px-4 py-2">Status</th>
                                <th class="border border-gray-300 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $uniqueProducts = [];
                            @endphp
                            @foreach($products as $product)
                                @if(!in_array($product->name, $uniqueProducts))
                                    @php
                                        $uniqueProducts[] = $product->name;
                                    @endphp
                                    <tr class="text-center">
                                        <td class="border border-gray-300 px-4 py-2">{{ $product->name }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ number_format($product->price, 2) }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $product->quantity ?? 0 }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $product->quantity > 10 ? 'Good' : 'Low Stock' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $product->status ?? 'Out of Stock' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded view-items" data-product="{{ $product->name }}" data-barcodes="{{ $products->where('name', $product->name)->pluck('barcode')->implode(', ') }}">
                                                View Items
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="barcodeModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 class="text-lg font-semibold mb-4">Barcode List</h3>
            <ul id="barcodeList" class="list-disc pl-5"></ul>
            <button onclick="closeModal()" class="mt-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Close</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.view-items').forEach(button => {
                button.addEventListener('click', function () {
                    let barcodes = this.getAttribute('data-barcodes').split(', ');
                    let listHtml = barcodes.map(barcode => `<li>${barcode}</li>`).join('');
                    document.getElementById('barcodeList').innerHTML = listHtml;
                    document.getElementById('barcodeModal').classList.remove('hidden');
                });
            });
        });

        function closeModal() {
            document.getElementById('barcodeModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
