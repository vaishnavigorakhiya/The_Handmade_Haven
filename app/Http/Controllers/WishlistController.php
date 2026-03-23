<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('product')
                             ->where('user_id', Auth::id())
                             ->latest()
                             ->get();

        return view('wishlist', compact('wishlists'));
    }

    public function toggle(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $existing = Wishlist::where('user_id', Auth::id())
                            ->where('product_id', $productId)
                            ->first();

        if ($existing) {
            $existing->delete();
            $wishlisted = false;
            $message    = '💔 Removed from wishlist';
        } else {
            Wishlist::create([
                'user_id'    => Auth::id(),
                'product_id' => $productId,
            ]);
            $wishlisted = true;
            $message    = '❤️ Added to wishlist!';
        }

        if ($request->expectsJson()) {
            return response()->json([
                'wishlisted' => $wishlisted,
                'message'    => $message,
                'count'      => Wishlist::where('user_id', Auth::id())->count(),
            ]);
        }

        return back()->with('success', $message);
    }

    public function remove($productId)
    {
        Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();

        return back()->with('success', '💔 Removed from wishlist.');
    }
}
