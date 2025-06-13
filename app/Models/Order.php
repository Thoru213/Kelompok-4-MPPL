<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'total_amount',
        'status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
    ];

    // Relasi ke pengguna yang membuat order (jika login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke item-item dalam order ini
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}