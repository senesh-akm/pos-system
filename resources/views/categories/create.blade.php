<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">{{ isset($category) ? 'Edit Category' : 'Add Category' }}</h2>

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

                <form action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
                    @csrf
                    @isset($category)
                        @method('PUT')
                    @endisset

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Category Name</label>
                        <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-100" required>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('categories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ isset($category) ? 'Update Category' : 'Save Category' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
