<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Tambahkan properti fillable jika Anda ingin menggunakan Mass Assignment
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];
}