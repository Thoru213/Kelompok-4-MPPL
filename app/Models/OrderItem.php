<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'price',
        'quantity',
    ];

    // Relasi ke order induk
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke produk yang sebenarnya
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}