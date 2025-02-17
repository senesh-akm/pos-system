<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">POS Dashboard</h2>

                <!-- Dashboard Stats -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-blue-500 text-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold">Total Sales</h3>
                        <p class="text-2xl font-bold">LKR 120,500</p>
                    </div>
                    <div class="bg-green-500 text-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold">Total Products</h3>
                        <p class="text-2xl font-bold">250</p>
                    </div>
                    <div class="bg-yellow-500 text-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold">Total Customers</h3>
                        <p class="text-2xl font-bold">320</p>
                    </div>
                </div>

                <!-- Real-time Product Updates -->
                <div class="mt-6">
                    <h3 class="text-xl font-bold">Product Updates</h3>
                    <div id="productUpdates" class="bg-gray-100 p-4 rounded shadow mt-2"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Laravel Echo Script -->
    <script>
        window.Echo.channel('product-updates')
            .listen('.ProductUpdated', (e) => {
                let updateDiv = document.getElementById('productUpdates');
                updateDiv.innerHTML = `<p class="text-green-600 font-bold">Product ${e.product.name} stock updated! New Quantity: ${e.product.stock}</p>`;
            });
    </script>
</x-app-layout>
