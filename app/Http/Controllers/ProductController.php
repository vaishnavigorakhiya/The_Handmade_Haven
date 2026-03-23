<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private const PRODUCT_VALIDATION_RULES = [
        'name' => 'required|string|min:3|max:255',
        'price' => 'required|numeric|min:0',
        'category' => 'required|string',
        'stock' => 'required|integer|min:0',
        'description' => 'required|string|min:10',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ];

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

    public function search(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (!$query) {
            return redirect()->route('shop');
        }

        $products = Product::where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->orWhere('category', 'like', '%' . $query . '%')
            ->get();

        $categories = Category::orderBy('name')->pluck('name');

        return view('search', compact('products', 'query', 'categories'));
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

        return view('admin.admin', compact('products', 'categories', 'totalOrders', 'totalRevenue', 'lowStock'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);
        $imagePath = $this->storeProductImage($request);

        Product::create($this->buildProductAttributes($validated, $imagePath));

        return redirect()->route('admin.dashboard')
            ->with('success', '✨ Product "' . $validated['name'] . '" added successfully!');    
        }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $this->validateProduct($request);
        $imagePath = $this->storeProductImage($request, $product->image);

        $product->update($this->buildProductAttributes($validated, $imagePath, $product));

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

     private function validateProduct(Request $request): array
    {
        return $request->validate(self::PRODUCT_VALIDATION_RULES);
    }

    private function storeProductImage(Request $request, ?string $currentImage = null): ?string
    {
        if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
            return $currentImage;
        }

        if ($currentImage) {
            Storage::disk('public')->delete($currentImage);
        }

        return $request->file('image')->store('products', 'public');
    }

    private function buildProductAttributes(array $validated, ?string $imagePath, ?Product $product = null): array
    {
        return [
            'name' => $validated['name'],
            'price' => $validated['price'],
            'category' => $validated['category'],
            'stock' => $validated['stock'],
            'emoji' => $product?->emoji ?? '🧵',
            'color' => request('color') ?? $product?->color ?? '#FFE8D6',
            'description' => $validated['description'],
            'image' => $imagePath,
            'tags' => json_encode([$validated['category']]),
            'badge' => request('badge') ?: null,
            'featured' => $product?->featured ?? false,
        ];
    }

}
