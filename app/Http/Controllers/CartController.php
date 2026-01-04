<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product; // <--- PENTING: Jangan lupa import Model Product
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Mengambil item keranjang milik user beserta data produknya
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();
        
        return view('cart.index', compact('cartItems'));
    }

    
    public function addToCart($productId)
    {
        $userId = Auth::id();
        $product = Product::findOrFail($productId); // Ambil data produk untuk cek stok

        // Cek apakah user sudah punya produk ini di keranjang?
        $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->first();

        // --- LOGIC PENGECEKAN STOK (SATPAM) ---
        
        // Hitung jumlah yang akan ada di keranjang nanti
        $currentQuantity = $cartItem ? $cartItem->quantity : 0;
        $newQuantity = $currentQuantity + 1;

        // Jika jumlah baru melebihi stok database, tolak!
        if ($newQuantity > $product->stock) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi! Sisa stok: ' . $product->stock);
        }

        // ---------------------------------------

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    
    public function update(Request $request, $id)
    {
        $cartItem = Cart::where('id', $id)->where('user_id', Auth::id())->with('product')->first();
        
        if ($cartItem) {
            // --- LOGIC PENGECEKAN STOK SAAT UPDATE ---
            
            // Cek apakah jumlah yang diinput user melebihi stok produk asli
            if ($request->quantity > $cartItem->product->stock) {
                return redirect()->back()->with('error', 'Jumlah melebihi stok yang tersedia! Stok cuma: ' . $cartItem->product->stock);
            }

            // Jika aman, update
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    
    public function destroy($id)
    {
        $cartItem = Cart::where('id', $id)->where('user_id', Auth::id())->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Item removed!');
    }
}