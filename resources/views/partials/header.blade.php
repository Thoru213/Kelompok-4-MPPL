<header class="bg-white shadow-lg">
    <div class="container mx-auto px-4 py-5 flex justify-between items-center relative">
        <a href="{{ url('/') }}" class="text-3xl font-extrabold text-blue-800 tracking-tight">GO-BLOCK</a>
        
        <form method="GET" action="{{ url('/') }}" class="relative w-full max-w-xs flex items-center ml-auto">
            <input type="text" name="search" placeholder="Cari barang..." value="{{ request('search') }}"
                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700 placeholder-gray-500 text-base">
            <button type="submit" class="absolute left-4 text-gray-400 h-6 w-6">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>

        <div class="flex items-center ml-4">
            <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
                <svg class="h-8 w-8 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="fixed inset-0 z-50 hidden">
        <div id="mobile-overlay-bg" class="absolute inset-0 bg-gray-800 opacity-75"></div>
        <div id="mobile-menu-panel" class="bg-white w-64 absolute right-0 top-0 h-full shadow-lg p-6 transform translate-x-full transition-transform duration-300 ease-in-out">
            <div class="flex justify-end mb-6">
                <button id="close-mobile-menu" class="text-gray-700 focus:outline-none mr-6 mt-2">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <ul class="flex flex-col space-y-4 text-xl font-medium">
                <li><a href="{{ url('/') }}" class="block text-gray-700 hover:text-blue-600">Home</a></li>
                <li><a href="{{ route('cart.index') }}" class="block text-gray-700 hover:text-blue-600">Keranjang</a></li>
                <li><a href="#" class="block text-gray-700 hover:text-blue-600">Akun</a></li>
                <li>
                    <a href="{{ route('products.create') }}" class="block bg-green-600 text-white rounded-lg text-lg font-bold hover:bg-green-700 text-center py-3 mt-4">
                        + Tambah Produk
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>
