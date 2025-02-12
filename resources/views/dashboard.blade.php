<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />

                <h2>POS Dashboard</h2>
                <div id="productUpdates"></div>
            </div>
        </div>
    </div>

    <script>
        window.Echo.channel('product-updates')
            .listen('.ProductUpdated', (e) => {
                document.getElementById('productUpdates').innerHTML =
                    `Product ${e.product.name} stock updated!`;
            });
    </script>
</x-app-layout>
