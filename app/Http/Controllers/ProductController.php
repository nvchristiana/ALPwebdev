<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Product::with('category');

        
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('category', function ($subQuery) use ($search) {
                      $subQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }
        // -------------------------------------------

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int) $request->max_price);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->orderBy('id', 'asc');
            }
        } else {
            $query->orderBy('id', 'asc');
        }

        $products = $query->get();

        return view('products.products', compact('products'));
    }

    // --- FITUR BARU: Detail Produk & Review ---
    public function show($id)
    {
        // Ambil produk beserta kategori dan review (termasuk user yg me-review)
        $product = Product::with(['category', 'reviews.user'])->findOrFail($id);
        
        return view('products.show', compact('product'));
    }
    // ------------------------------------------

    
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer',
            'stock'       => 'required|integer|min:0', // Fitur Stok
            'description' => 'nullable|string',
            'image'       => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk baru berhasil disimpan.');
    }


    public function edit($id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer',
            'stock'       => 'required|integer|min:0', // Fitur Stok
            'description' => 'nullable|string',
            'image'       => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', "Produk berhasil diupdate.");
    }


    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', "Produk berhasil dihapus.");
    }
}