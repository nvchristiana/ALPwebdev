<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // IZINKAN KOLOM INI DIISI OTOMATIS
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    // Relasi: OrderItem adalah milik satu Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
