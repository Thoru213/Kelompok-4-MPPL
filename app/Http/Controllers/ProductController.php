<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Fitur Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%'); // Boleh juga cari di deskripsi
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
                default: // <-- Tambahkan default case ini
                    $query->orderBy('name', 'asc'); // Default: urutkan berdasarkan nama A-Z
                    break;
            }
        } else {
            // Default sorting jika tidak ada parameter sort sama sekali
            $query->orderBy('name', 'asc');
        }

        $products = $query->get();

        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        // Ambil data produk dari database berdasarkan ID
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
            $imagePath = $imageName; // Kita hanya simpan nama file di DB
        }

        // 3. Buat Produk Baru di Database
        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'image' => $imagePath, // Simpan nama file gambar
        ]);

        // 4. Redirect dengan Pesan Sukses
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }
}
