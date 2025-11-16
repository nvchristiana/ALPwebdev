<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
   
    public function index()
    {
        $products = [];

        
        for ($i = 1; $i <= 24; $i++) {
            $products[] = [
                'id'    => $i,
                'name'  => "Produk {$i}",
                'price' => rand(5000, 25000),   
                'image' => $i . '.jpg',         
            ];
        }

        
        return view('products.products', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
   
        return redirect()
            ->route('products.index')
            ->with('success', 'Produk baru berhasil disimpan (dummy).');
    }

    
    public function edit($id)
    {
        
        $product = [
            'id'    => $id,
            'name'  => "Contoh Produk {$id}",
            'price' => 100000,
        ];

        
        return view('products.edit', [
            'product' => $product,
        ]);
    }

    
    public function update(Request $request, $id)
    {

        return redirect()
            ->route('products.index')
            ->with('success', "Produk dengan ID {$id} berhasil diupdate (dummy).");
    }

    public function delete($id)
{
    return redirect()
        ->route('products.index')
        ->with('success', "Produk dengan ID {$id} berhasil dihapus (dummy).");
    }
}
