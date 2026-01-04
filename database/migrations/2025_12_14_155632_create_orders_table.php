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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel users (Siapa yang pesan?)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Status pesanan (default 'unpaid', nanti bisa berubah jadi 'paid')
            $table->string('status')->default('unpaid');
            
            // Poin 7: Alamat pengiriman
            $table->text('address');
            
            // Poin 7: Metode pembayaran
            $table->string('payment_method');
            
            // Poin 6: Total harga seluruh belanjaan
            $table->decimal('total_price', 10, 2);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};