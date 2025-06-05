<header class="bg-white shadow-md">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-800">GO-BLOCK</a>

        <nav>
            <ul class="flex space-x-6 text-lg">
                <li><a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600 font-semibold">Home</a></li>
                <li><a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600 font-semibold">Produk</a></li>
                <li><a href="#" class="text-gray-700 hover:text-blue-600 font-semibold">Tentang Kami</a></li>
            </ul>
        </nav>

        <div class="relative">
            <input type="text" placeholder="Cari barang..." class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </div>
</header>