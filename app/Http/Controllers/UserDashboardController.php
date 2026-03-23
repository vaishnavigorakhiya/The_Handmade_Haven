<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user       = Auth::user();
        $orders     = Order::where('user_id', $user->id)->latest()->get();
        $totalSpent = $orders->sum('total');
        $wishlistCount = 0;
        try {
            $wishlistCount = $user->wishlists()->count();
        } catch (\Exception $e) {
        }

        return view('user.dashboard', compact(
            'user', 'orders', 'totalSpent', 'wishlistCount'
        ));
    }

    public function updateProfile(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);
        Auth::user()->update(['name' => $request->name]);
        return back()->with('success', '✅ Profile updated!');
    }

    public function orderDetail($id)
    {
        $order = Order::with('items.product')
                      ->where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        return view('user.order-detail', compact('order'));
    }

}
