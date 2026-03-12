<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
   public function home()
    {
        $featured = Product::where('featured', true)->take(4)->get();
        return view('home', compact('featured'));
    }

    public function shop(Request $request)
    {
        $category = $request->get('category');
        $products = $category
            ? Product::where('category', $category)->get()
            : Product::all();
        $categories = Product::distinct()->pluck('category');
        return view('shop', compact('products', 'categories', 'category'));
    }

    public function detail($id)
    {
        $product = Product::findOrFail($id);
        return view('product-detail', compact('product'));
    }

    public function adminDashboard()
    {
        $products = Product::all();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total');
        $lowStock = Product::where('stock', '>', 0)->where('stock', '<=', 3)->count();
        return view('admin', compact('products', 'totalOrders', 'totalRevenue', 'lowStock'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'category'    => 'required|string',
            'stock'       => 'required|integer|min:0',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'category'    => $request->category,
            'stock'       => $request->stock,
            'emoji'       => $request->emoji ?? '🧵',
            'color'       => $request->color ?? '#FFE8D6',
            'description' => $request->description,
            'image'       => $imagePath,
            'tags'        => json_encode([$request->category]),
            'badge'       => 'New',
            'featured'    => false,
        ]);

        return redirect()->route('admin.dashboard')
                         ->with('success', '✨ Product "' . $request->name . '" added successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete image from storage if it exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.dashboard')
                         ->with('success', '🗑 Product deleted successfully.');
    }

    public function restock($id)
    {
        $product = Product::findOrFail($id);
        $product->increment('stock', 5);
        return redirect()->route('admin.dashboard')
                         ->with('success', '📦 "' . $product->name . '" restocked +5 units!');
    }
}
