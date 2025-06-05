<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Pastikan ini diimpor

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Untuk demo tampilan Figma, kita pakai data dummy
        // Di aplikasi nyata, Anda akan mengambil dari database
        $products = [
            (object)['id' => 1, 'name' => 'Semen Tiga Roda 50kg', 'price' => 75000, 'image' => 'semen.jpg', 'description' => 'Semen berkualitas tinggi untuk konstruksi kokoh.'],
            (object)['id' => 2, 'name' => 'Pasir Cor Kualitas A', 'price' => 30000, 'image' => 'pasir.jpg', 'description' => 'Pasir pilihan untuk adukan beton dan plesteran.'],
            (object)['id' => 3, 'name' => 'Batu Split 1/2', 'price' => 25000, 'image' => 'batu_split.jpg', 'description' => 'Batu pecah untuk campuran beton dan pondasi.'],
            (object)['id' => 4, 'name' => 'Paku Beton 5cm', 'price' => 5000, 'image' => 'paku.jpg', 'description' => 'Paku kuat untuk kebutuhan pemasangan material berat.'],
            (object)['id' => 5, 'name' => 'Cat Tembok Putih 5kg', 'price' => 120000, 'image' => 'cat.jpg', 'description' => 'Cat interior berkualitas dengan daya tutup sempurna.'],
            (object)['id' => 6, 'name' => 'Pipa PVC 2 Inci', 'price' => 45000, 'image' => 'pipa.jpg', 'description' => 'Pipa PVC standar SNI untuk instalasi air bersih.'],
        ];

        // Contoh sorting dan search sederhana (implementasi penuh butuh query DB)
        $query = collect($products);

        if ($request->has('search')) {
            $search = strtolower($request->search);
            $query = $query->filter(function($product) use ($search) {
                return str_contains(strtolower($product->name), $search);
            });
        }

        if ($request->has('sort')) {
            if ($request->sort == 'name_asc') {
                $query = $query->sortBy('name');
            } elseif ($request->sort == 'price_asc') {
                $query = $query->sortBy('price');
            } elseif ($request->sort == 'stock_desc') { // asumsi ada stock di data dummy
                $query = $query->sortByDesc('stock');
            }
        }

        $products = $query->values()->all(); // Reset keys after filtering/sorting

        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        // Untuk demo tampilan Figma, kita pakai data dummy
        // Di aplikasi nyata, Anda akan mengambil dari database: Product::findOrFail($id);
        $allProducts = [
            (object)['id' => 1, 'name' => 'Semen Tiga Roda 50kg', 'description' => 'Semen berkualitas tinggi dengan campuran khusus untuk kekuatan maksimal pada struktur beton. Cocok untuk semua jenis konstruksi, dari rumah tinggal hingga bangunan bertingkat. Daya rekat tinggi dan hasil akhir yang halus.', 'price' => 75000, 'stock' => 100, 'image' => 'semen.jpg'],
            (object)['id' => 2, 'name' => 'Pasir Cor Kualitas A', 'description' => 'Pasir cor pilihan dengan butiran seragam, bebas dari lumpur dan kotoran. Ideal untuk adukan beton yang kuat, plesteran, dan pasangan bata. Menghasilkan permukaan yang rata dan kokoh.', 'price' => 30000, 'stock' => 50, 'image' => 'pasir.jpg'],
            (object)['id' => 3, 'name' => 'Batu Split 1/2', 'description' => 'Batu pecah ukuran 1/2 inci yang bersih dan padat, cocok untuk campuran beton K-225 hingga K-350. Sangat baik untuk pondasi bangunan, pengecoran lantai, dan pembuatan jalan.', 'price' => 25000, 'stock' => 200, 'image' => 'batu_split.jpg'],
            (object)['id' => 4, 'name' => 'Paku Beton 5cm', 'description' => 'Paku beton dengan kekuatan tinggi dan lapisan anti karat. Dirancang khusus untuk menembus material keras seperti beton, bata, dan kayu keras. Sangat awet dan tidak mudah bengkok.', 'price' => 5000, 'stock' => 500, 'image' => 'paku.jpg'],
            (object)['id' => 5, 'name' => 'Cat Tembok Putih 5kg', 'description' => 'Cat interior berkualitas premium dengan warna putih cerah yang tahan lama dan daya tutup sempurna. Formulanya anti jamur dan mudah dibersihkan, cocok untuk memberikan kesan luas dan bersih pada ruangan.', 'price' => 120000, 'stock' => 30, 'image' => 'cat.jpg'],
            (object)['id' => 6, 'name' => 'Pipa PVC 2 Inci', 'description' => 'Pipa PVC standar SNI berukuran 2 inci yang kuat dan tahan terhadap tekanan air. Ideal untuk sistem saluran air bersih, pembuangan, dan irigasi. Mudah dipasang dan tidak mudah berkarat.', 'price' => 45000, 'stock' => 80, 'image' => 'pipa.jpg'],
        ];

        $product = collect($allProducts)->firstWhere('id', $id);

        if (!$product) {
            abort(404); // Produk tidak ditemukan
        }

        return view('products.show', compact('product'));
    }
}