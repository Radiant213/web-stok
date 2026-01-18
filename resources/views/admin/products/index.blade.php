<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Management') }}
            </h2>
            <a href="{{ route('admin.products.create') }}"
                class="inline-flex items-center px-4 py-2 bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-800 focus:bg-gray-800 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Product
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-green-700">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Products Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Table Container -->
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <!-- Table Header -->
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <div
                                class="grid grid-cols-12 gap-4 text-sm font-medium text-gray-600 uppercase tracking-wider">
                                <div class="col-span-1 text-center">No</div>
                                <div class="col-span-3">Product</div>
                                <div class="col-span-2 text-center">Status</div>
                                <div class="col-span-2 text-center">Price</div>
                                <div class="col-span-2 text-center">Stock</div>
                                <div class="col-span-2 text-center">Actions</div>
                            </div>
                        </div>

                        <!-- Products List -->
                        @forelse ($products as $product)
                                            <div class="px-6 py-4 border-b border-gray-100 hover:bg-gray-50 transition-colors duration-150">
                                                <div class="grid grid-cols-12 gap-4 items-center">
                                                    <!-- Numbering -->
                                                    <div class="col-span-1 text-center font-medium text-gray-500">
                                                        {{ $loop->iteration }}
                                                    </div>

                                                    <!-- Product Info -->
                                                    <div class="col-span-3 flex items-center space-x-4">
                                                        <div
                                                            class="relative w-20 h-20 bg-gray-100 rounded-md overflow-hidden flex-shrink-0">
                                                            @if ($product->image)
                                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                                                    class="w-full h-full object-cover">
                                                            @else
                                                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <h3 class="font-semibold text-gray-900 text-sm">{{ $product->name }}</h3>
                                                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                                                {{ $product->description ? Str::limit($product->description, 60) : 'No description' }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <!-- Status -->
                                                    <div class="col-span-2 text-center">
                                                        @if($product->status == 'available')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                Available
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                Out Stock
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <!-- Price -->
                                                    <div class="col-span-2">
                                                        <div class="text-center">
                                                            <span class="font-semibold text-gray-900">
                                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Stock -->
                                                    <div class="col-span-2">
                                                        <div class="text-center">
                                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                                                                                                                {{ $product->stock > 10 ? 'bg-green-100 text-green-800' :
                            ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                                {{ $product->stock }} units
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Actions -->
                                                    <div class="col-span-2">
                                                        <div class="flex items-center justify-center space-x-3">
                                                            <a href="{{ route('admin.products.edit', $product) }}"
                                                                class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-150">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                                Edit
                                                            </a>

                                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-150">
                                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                        @empty
                            <!-- Empty State -->
                            <div class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <h3 class="mt-4 text-sm font-medium text-gray-900">No products</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new product.</p>
                                <div class="mt-6">
                                    <a href="{{ route('admin.products.create') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                        Add Product
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="mt-6 px-4 py-3 border-t border-gray-200">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>