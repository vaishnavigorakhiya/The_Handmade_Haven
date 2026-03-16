<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
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
        $category   = $request->get('category');
        $products   = $category ? Product::where('category', $category)->get() : Product::all();
        $categories = Category::orderBy('name')->pluck('name');
        return view('shop', compact('products', 'categories', 'category'));
    }

    public function detail($id)
    {
        $product = Product::findOrFail($id);
        return view('product-detail', compact('product'));
    }

    public function about()
    {
        return view('about');
    }

    public function adminDashboard()
    {
        $products     = Product::all();
        $categories   = Category::orderBy('name')->get();
        $totalOrders  = Order::count();
        $totalRevenue = Order::sum('total');
        $lowStock     = Product::where('stock', '>', 0)->where('stock', '<=', 3)->count();
        return view('admin', compact('products', 'categories', 'totalOrders', 'totalRevenue', 'lowStock'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|min:3|max:255',
            'price'       => 'required|numeric|min:0',
            'category'    => 'required|string',
            'stock'       => 'required|integer|min:0',
            'description' => 'required|string|min:10',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required'        => 'Product name is required.',
            'name.min'             => 'Name must be at least 3 characters.',
            'price.required'       => 'Price is required.',
            'price.numeric'        => 'Enter a valid price.',
            'price.min'            => 'Price cannot be negative.',
            'category.required'    => 'Please select a category.',
            'stock.required'       => 'Stock quantity is required.',
            'stock.integer'        => 'Stock must be a whole number.',
            'stock.min'            => 'Stock cannot be negative.',
            'description.required' => 'Product description is required.',
            'description.min'      => 'Description must be at least 10 characters.',
            'image.image'          => 'The file must be an image.',
            'image.mimes'          => 'Only JPG, PNG, and WEBP images are allowed.',
            'image.max'            => 'Image file size must not exceed 2 MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'category'    => $request->category,
            'stock'       => $request->stock,
            'emoji'       => '🧵',
            'color'       => $request->color ?? '#FFE8D6',
            'description' => $request->description,
            'image'       => $imagePath,
            'tags'        => json_encode([$request->category]),
            'badge'       => $request->badge ?: null,
            'featured'    => false,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', '✨ Product "' . $request->name . '" added successfully!');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|min:3|max:255',
            'price'       => 'required|numeric|min:0',
            'category'    => 'required|string',
            'stock'       => 'required|integer|min:0',
            'description' => 'required|string|min:10',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required'        => 'Product name is required.',
            'name.min'             => 'Name must be at least 3 characters.',
            'price.required'       => 'Price is required.',
            'price.numeric'        => 'Enter a valid price.',
            'price.min'            => 'Price cannot be negative.',
            'category.required'    => 'Please select a category.',
            'stock.required'       => 'Stock quantity is required.',
            'stock.integer'        => 'Stock must be a whole number.',
            'stock.min'            => 'Stock cannot be negative.',
            'description.required' => 'Product description is required.',
            'description.min'      => 'Description must be at least 10 characters.',
            'image.image'          => 'The file must be an image.',
            'image.mimes'          => 'Only JPG, PNG, and WEBP images are allowed.',
            'image.max'            => 'Image file size must not exceed 2 MB.',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'        => $request->name,
            'price'       => $request->price,
            'category'    => $request->category,
            'stock'       => $request->stock,
            'color'       => $request->color ?? $product->color,
            'description' => $request->description,
            'image'       => $imagePath,
            'badge'       => $request->badge ?: null,
            'tags'        => json_encode([$request->category]),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', '✅ Product "' . $product->name . '" updated!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) Storage::disk('public')->delete($product->image);
        $name = $product->name;
        $product->delete();
        return redirect()->route('admin.dashboard')
            ->with('success', '🗑 Product "' . $name . '" deleted.');
    }

    public function restock($id)
    {
        $product = Product::findOrFail($id);
        $product->increment('stock', 5);
        return redirect()->route('admin.dashboard')
            ->with('success', '📦 "' . $product->name . '" restocked +5 units!');
    }
}
