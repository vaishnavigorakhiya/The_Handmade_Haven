<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function cart()
    {
        $cartData = session('cart', []);
        $cartItems = [];
        $subtotal = 0;

        foreach ($cartData as $id => $qty) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = ['product' => $product, 'qty' => $qty];
                $subtotal += $product->price * $qty;
            }
        }

        $shipping = $subtotal > 60 ? 0 : ($subtotal > 0 ? 5.99 : 0);
        $total = $subtotal + $shipping;

        return view('cart', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if ($product->stock === 0) {
            return back()->with('error', 'Sorry, this item is out of stock!');
        }

        $cart = session('cart', []);
        $action = $request->input('action');

        if ($action === 'decrease') {
            if (isset($cart[$id]) && $cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        } else {
            $currentQty = $cart[$id] ?? 0;
            if ($currentQty >= $product->stock) {
                return back()->with('error', 'Maximum stock reached for this item!');
            }
            $cart[$id] = $currentQty + 1;
        }

        session(['cart' => $cart]);
        return back()->with('success', '"' . $product->name . '" updated in cart!');
    }

    public function removeFromCart($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
        return back()->with('success', 'Item removed from cart.');
    }

    public function checkout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        $subtotal = 0;
        foreach ($cart as $id => $qty) {
            $product = Product::find($id);
            if ($product) $subtotal += $product->price * $qty;
        }
        $shipping = $subtotal > 60 ? 0 : 5.99;
        $total = $subtotal + $shipping;

        // Create Order
        $order = Order::create([
            'user_id'  => Auth::id(),
            'total' => $total,
            'shipping' => $shipping,
            'status' => 'completed',
        ]);

        // Create Order Items & reduce stock
        foreach ($cart as $id => $qty) {
            $product = Product::find($id);
            if ($product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $qty,
                    'price' => $product->price,
                ]);
                $product->decrement('stock', $qty);
            }
        }

        session()->forget('cart');
        return redirect()->route('home')->with('success', '🎉 Order placed! Thank you for your purchase!');
    }
}
