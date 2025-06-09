<header class="bg-white shadow-lg">
    <div class="container mx-auto px-4 py-5 flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-3xl font-extrabold text-blue-800 tracking-tight">GO-BLOCK</a>

        <nav class="hidden md:block">
            <ul class="flex space-x-8 text-lg font-medium">
                <li><a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">Home</a></li>
                <li><a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">Produk</a></li>
                <li><a href="#" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">Tentang Kami</a></li>
            </ul>
        </nav>

        <div class="relative w-full max-w-xs md:max-w-md">
    <form action="{{ url('/') }}" method="GET">
        <input type="text" name="search" placeholder="Cari barang..." value="{{ request('search') }}" class="w-full pl-12 pr-4 py-3 rounded-full border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700 placeholder-gray-500 text-base">
        <button type="submit" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 h-6 w-6">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </button>
    </form>
</div>

        <button class="md:hidden text-gray-700 focus:outline-none">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>
</header>
