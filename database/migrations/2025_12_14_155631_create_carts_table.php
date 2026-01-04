<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            // Menambahkan kolom relasi ke user (User siapa yang punya keranjang)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            // Menambahkan kolom relasi ke produk (Produk apa yang dimasukkan)
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); 
            
            // Menambahkan kolom jumlah barang (Default 1)
            $table->integer('quantity')->default(1); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};