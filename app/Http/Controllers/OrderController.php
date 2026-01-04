<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product; // Pastikan import Product jika dibutuhkan eksplisit

class OrderController extends Controller
{
    
    public function checkout()
    {
        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }
        
        $total = 0;
        foreach ($cartItems as $item) {
            $total += ($item->product->price * $item->quantity);
        }

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    
    public function processCheckout(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('products.index');
        }

        // 1. SAFETY CHECK: Cek apakah stok mencukupi sebelum membuat order
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->back()->with('error', 'Stok produk "' . $item->product->name . '" tidak mencukupi! Sisa: ' . $item->product->stock);
            }
        }

        // Hitung total
        $total = 0;
        foreach ($cartItems as $item) {
            $total += ($item->product->price * $item->quantity);
        }

        // Buat Order
        $order = Order::create([
            'user_id' => $userId,
            'status' => 'paid',
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'total_price' => $total,
        ]);

        // Pindahkan item ke OrderItem & KURANGI STOK
        foreach ($cartItems as $item) {
            // Simpan detail order
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

            // --- FITUR UTAMA: Update Stok Produk ---
            $product = $item->product;
            $product->stock = $product->stock - $item->quantity;
            $product->save(); 
            // ---------------------------------------
        }

        // Kosongkan keranjang
        Cart::where('user_id', $userId)->delete();

        return redirect()->route('orders.history')->with('success', 'Checkout berhasil! Terima kasih.');
    }

    
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())->with('items.product')->latest()->get();
        return view('orders.history', compact('orders'));
    }
}