<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->latest()->get();
        $totalSpent = $orders->sum('total');
        $wishlistCount = $user->wishlists()->count();

        return view('user.dashboard', compact(
            'user', 'orders', 'totalSpent', 'wishlistCount'
        ));
    }

    public function updateProfile(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);
        Auth::user()->update([
            'name' => trim($request->name),
        ]);
        return back()->with('success', '✅ Profile updated!');
    }

    public function orderDetail(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 404);
        $order->load('items.product');

        return view('user.order-detail', compact('order'));
    }

}
