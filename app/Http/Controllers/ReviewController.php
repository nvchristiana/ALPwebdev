<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        // Validasi input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        // Cek apakah user sudah pernah review produk ini? (Opsional: agar 1 user 1 review per produk)
        // Jika ingin membolehkan berkali-kali, hapus blok 'if' ini.
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('product_id', $productId)
                                ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk produk ini.');
        }

        // Simpan Review
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Review Anda berhasil dikirim.');
    }
}
