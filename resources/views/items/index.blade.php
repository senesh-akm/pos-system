<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Item List</h2>
                <div class="flex justify-end mb-4">
                    <a href="{{ route('items.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Add Item
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border" style="text-align: left">Name</th>
                                <th class="px-4 py-2 border" style="text-align: left">Product Code</th>
                                <th class="px-4 py-2 border" style="text-align: left">Price (LKR)</th>
                                <th class="px-4 py-2 border" style="text-align: left">Stock</th>
                                <th class="px-4 py-2 border" style="text-align: left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $item->item_name }}</td>
                                    <td class="px-4 py-2 border">{{ $item->barcode }}</td>
                                    <td class="px-4 py-2 border">{{ number_format($item->price, 2) }}</td>
                                    <td class="px-4 py-2 border">{{ $item->stock }}</td>
                                    <td class="px-4 py-2 border">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('items.edit', $item->id) }}" class="bg-yellow-400 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded">
                                                Edit
                                            </a>
                                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-2 border text-center text-gray-500">No Item Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
