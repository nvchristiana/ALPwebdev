<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'stock',       // Pastikan stock tetap ada (dari fitur sebelumnya)
        'description',
        'image',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // --- RELASI BARU: Produk punya banyak Review ---
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}