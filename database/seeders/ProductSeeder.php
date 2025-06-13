<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::truncate();

        Product::create([
            'name' => 'Semen Tiga Roda 50kg',
            'description' => 'Semen berkualitas tinggi untuk konstruksi kokoh dengan daya rekat sempurna. Cocok untuk pondasi hingga plesteran.',
            'image' => 'semen.jpg',
            'price' => 75000,
            'stock' => 100,
        ]);

        Product::create([
            'name' => 'Pasir Cor Kualitas A',
            'description' => 'Pasir pilihan dengan butiran seragam, bebas lumpur. Ideal untuk adukan beton yang kuat dan plesteran.',
            'image' => 'pasir.jpg',
            'price' => 30000,
            'stock' => 250,
        ]);

        Product::create([
            'name' => 'Batu Split 1/2 Inci',
            'description' => 'Batu pecah ukuran 1/2 inci, bersih dan padat. Sangat baik untuk campuran beton dan pondasi.',
            'image' => 'batu_split.jpg',
            'price' => 25000,
            'stock' => 500,
        ]);

        Product::create([
            'name' => 'Paku Beton 5cm',
            'description' => 'Paku baja kuat untuk kebutuhan pemasangan material berat pada beton dan kayu keras.',
            'image' => 'paku.jpg',
            'price' => 5000,
            'stock' => 1000,
        ]);

        Product::create([
            'name' => 'Cat Tembok Putih 5kg',
            'description' => 'Cat interior premium warna putih cerah, tahan lama dan anti jamur. Mudah dibersihkan.',
            'image' => 'cat.jpg',
            'price' => 120000,
            'stock' => 50,
        ]);

        Product::create([
            'name' => 'Pipa PVC 2 Inci SNI',
            'description' => 'Pipa PVC standar SNI, kuat dan tahan tekanan. Ideal untuk instalasi air bersih dan pembuangan.',
            'image' => 'pipa.jpg',
            'price' => 45000,
            'stock' => 120,
        ]);
    }
}
