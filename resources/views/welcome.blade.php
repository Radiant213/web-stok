<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Web Stok Barang</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans antialiased text-gray-900 bg-white">
    

        <!-- Navbar -->
        <header class="border-b border-gray-100 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="mr-10">
                        <a href="{{ route('home') }}" class="text-2xl font-bold flex items-center">
                            <span class="bg-[#3BB77E] text-white rounded-full px-2 py-1 mr-2 text-sm">S</span> Web Stok Barang
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                     @auth
                        <div class="relative ml-3" x-data="{ open: false }">
                            <div>
                                <button @click="open = ! open" type="button" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </div>
                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" style="display: none;">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Panel</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log Out</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-[#3BB77E]">Log in</a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <!-- Hero Title -->
            <div class="bg-gray-50 py-12 text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Web Stok Barang</h1>
                <p class="text-gray-500 text-sm">Home / Web Stok Barang</p>
                <div class="mt-4 flex justify-center space-x-2">
                    <!-- Dots decoration -->
                    <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                    <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                </div>
            </div>

            <!-- Product Table -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="grid grid-cols-12 gap-4 bg-[#FFC43F] p-4 font-semibold text-gray-800">
                        <div class="col-span-6">Product</div>
                        <div class="col-span-2 text-center">Price</div>
                        <div class="col-span-2 text-center">Quantity (Stock)</div>
                        <div class="col-span-2 text-center">Status</div>
                    </div>

                    @forelse ($products as $product)
                        <div class="grid grid-cols-12 gap-4 p-4 border-b border-gray-100 items-center hover:bg-gray-50">
                            <div class="col-span-6 flex items-center space-x-4">
                                <!-- Numbering -->
                                <span class="text-gray-500 font-medium w-8 text-center">{{ $loop->iteration }}</span>
                                <div class="w-20 h-20 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                    @if ($product->image)
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Img</div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</p>
                                </div>
                            </div>
                            <div class="col-span-2 text-center text-gray-700 font-medium">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                            <div class="col-span-2 text-center flex justify-center items-center">
                                <div class="border rounded px-3 py-1 bg-white text-gray-700">
                                    {{ $product->stock }}
                                </div>
                            </div>
                            <div class="col-span-2 text-center font-bold text-gray-800">
                                @if($product->status == 'available')
                                    <span class="text-green-600">Available</span>
                                @else
                                    <span class="text-red-500">Out of Stock</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            Belum ada barang yang tersedia.
                        </div>
                    @endforelse
                </div>

                <div class="mt-8 flex justify-end items-center">
                    <div>
                        <a href="{{ route('home') }}" class="text-gray-600 underline text-sm hover:text-[#3BB77E]">Refresh Stock List</a>
                    </div>
                </div>
            </div>

            <!-- Features removed -->
        </main>

        <!-- Footer -->
        <footer class="bg-[#1e4c35] text-white pt-16 pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                    <div>
                        <h3 class="text-xl font-bold mb-4 flex items-center">
                            <span class="bg-[#FFC43F] text-[#1e4c35] rounded-full px-2 py-1 mr-2 text-sm">S</span> Web Stok Barang
                        </h3>
                        <p class="text-gray-300 text-sm mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </div>
                    <div>
                        <h4 class="font-bold mb-4">Company</h4>
                        <ul class="text-sm text-gray-300 space-y-2">
                            <li>About Us</li>
                            <li>Blog</li>
                            <li>Contact Us</li>
                            <li>Career</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold mb-4">Customer Services</h4>
                        <ul class="text-sm text-gray-300 space-y-2">
                            <li>My Account</li>
                            <li>Track Your Order</li>
                            <li>Return</li>
                            <li>FAQ</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold mb-4">Contact Info</h4>
                        <ul class="text-sm text-gray-300 space-y-2">
                            <li>+0123-456-789</li>
                            <li>example@gmail.com</li>
                            <li>8502 Preston Rd, Inglewood, Maine 98380</li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-white/10 pt-8 flex justify-between items-center text-xs text-gray-400">
                    <p>&copy; <span id="year"></span> Web Stok Barang. All Rights Reserved.</p>
                    <div class="flex space-x-4">
                        <span>English</span>
                        <span>USD</span>
                    </div>
                </div>
            </div>
        </footer>
        <script>
            document.getElementById('year').textContent = new Date().getFullYear();
        </script>
    </body>
</html>
