<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Untuk Str::slug

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Fitur Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }

        // Fitur Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'stock_desc':
                    $query->orderBy('stock', 'desc');
                    break;
                default:
                    $query->orderBy('name', 'asc');
                    break;
            }
        } else {
            $query->orderBy('name', 'asc');
        }

        $products = $query->get();

        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi file gambar
        ]);

        $imagePath = null;
        // 2. Unggah Gambar (jika ada)
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $imagePath = $imageName;
        }

        // 3. Buat Produk Baru di Database
        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'image' => $imagePath,
        ]);

        // 4. Redirect dengan Pesan Sukses
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menambahkan produk ke keranjang (menggunakan Session).
     * Sekarang juga menangani 'variant'.
     */
    public function addToCart($id, Request $request)
    {
        $product = Product::findOrFail($id);

        $quantity = $request->input('quantity', 1);
        $variant = $request->input('variant', 'Unit'); // Akan selalu 'Unit' karena input varian dihilangkan

        // Validasi: pastikan kuantitas tidak melebihi stok
        if ($quantity <= 0) {
            return redirect()->back()->with('error', 'Kuantitas harus lebih dari 0!');
        }
        if ($quantity > $product->stock) {
            return redirect()->back()->with('error', 'Kuantitas melebihi stok yang tersedia!');
        }

        $cart = session()->get('cart', []);
        
        // Buat kunci unik untuk item keranjang (product_id + variant)
        $cartKey = $product->id . '_' . Str::slug($variant);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $quantity,
                'variant' => $variant,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->back()->with('success', 'Item berhasil dimasukkan ke keranjang!');
    }

    
    //Menampilkan isi keranjang belanja.
    public function viewCart()
    {
        $cart = session('cart', []);
        $items = [];
        $total = 0;

        $productIdsInCart = collect($cart)->pluck('product_id')->unique()->toArray();
        $productsFromDb = Product::whereIn('id', $productIdsInCart)->get()->keyBy('id');

        foreach ($cart as $cartKey => $item) {
            $product = $productsFromDb->get($item['product_id']);

            if ($product) {
                $qty = $item['quantity'];
                $subtotal = $product->price * $qty;
                $items[] = [
                    'product' => $product,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                    'variant' => $item['variant'] ?? 'Unit',
                    'cartKey' => $cartKey,
                ];
                $total += $subtotal;
            } else {
                unset($cart[$cartKey]);
                session(['cart' => $cart]);
            }
        }

        return view('cart.index', compact('items', 'total'));
    }

    //Memperbarui kuantitas produk di keranjang.
    public function updateCart($cartKey, Request $request)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$cartKey])) {
            return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan di keranjang!');
        }

        $productId = $cart[$cartKey]['product_id'];
        $product = Product::findOrFail($productId);

        $quantity = max(1, (int)$request->input('quantity', 1));

        if ($quantity > $product->stock) {
            return redirect()->back()->with('error', 'Kuantitas melebihi stok yang tersedia!');
        }

        $cart[$cartKey]['quantity'] = $quantity;
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Jumlah produk diperbarui!');
    }

    //Menghapus produk dari keranjang.
    public function removeFromCart($cartKey)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session(['cart' => $cart]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang!');
    }
}
