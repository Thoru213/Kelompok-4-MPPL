<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GO-BLOCK - Bahan Bangunan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-poppins antialiased">
    @include('partials.header')

    <main class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        {{-- Notifikasi Sukses/Error --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none';">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.15a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.029a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.15 2.758 3.15a1.2 1.2 0 0 1 0 1.697z"/></svg>
                </span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none';">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.15a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.029a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.15 2.758 3.15a1.2 1.2 0 0 1 0 1.697z"/></svg>
                </span>
            </div>
        @endif

        @yield('content')
    </main>

    @include('partials.footer')

    <div id="addToCartModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-4 transform transition-all duration-300 scale-95 opacity-0 border border-black">
            <div class="flex justify-end items-center mb-4">
                <button id="closeModalButton" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="mb-6 border-b border-gray-200 pb-4">
                <img id="modalProductImage" src="" alt="Produk" class="w-full h-48 object-contain object-center rounded-lg mb-4 border border-gray-300">
                <h3 id="modalProductName" class="text-xl font-bold text-gray-900 mb-1"></h3>
                <p id="modalProductPrice" class="text-lg text-blue-600 font-bold"></p>
                {{-- STOK TERSEDIA - Ini sudah ada di sini --}}
                <p class="text-sm text-gray-500 mt-2">Stok Tersedia: <span id="modalProductStock"></span></p>
            </div>

            <form id="modalAddToCartForm" method="POST" action="">
                @csrf
                <input type="hidden" name="product_id" id="modalProductId">
                <input type="hidden" name="variant" value="Unit"> {{-- Hidden input untuk varian default --}}

                
                <div class="w-full flex justify-center items-center my-6">
                    <button type="button" id="decrementQuantity" class="bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-full w-10 h-10 flex items-center justify-center text-2xl font-bold transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-gray-300">-</button>
                    <span id="displayQuantity" class="text-3xl font-bold text-gray-800 mx-4">1</span>
                    <input type="hidden" name="quantity" id="modalQuantity" value="1">
                    <button type="button" id="incrementQuantity" class="bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-full w-10 h-10 flex items-center justify-center text-2xl font-bold transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-gray-300">+</button>
                </div>
                <p class="text-sm text-gray-500 mt-2 text-center">Stok Tersedia: <span id="modalProductStock"></span></p>


                <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg text-xl font-bold hover:bg-blue-700 transition duration-300 shadow-md flex items-center justify-center mt-6">
                    ADD TO CART <svg class="inline-block h-6 w-6 ml-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.6 8h12.8l-1.6-8M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.6 8h12.8l-1.6-8z"/></svg>
                </button>
            </form>
        </div>
    </div>

    @vite('resources/js/app.js')
</body>
</html>
