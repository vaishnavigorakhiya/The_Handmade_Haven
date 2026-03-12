@extends('layouts.app')
@section('title', 'Your Cart — Stitch & Bloom')

@push('styles')
<style>
  .cart-container { max-width: 800px; margin: 0 auto; }
  .cart-item { background: white; border: 3px solid var(--dark); border-radius: 16px; padding: 20px 24px; display: flex; align-items: center; gap: 20px; margin-bottom: 16px; box-shadow: 4px 4px 0 var(--dark); }
  .cart-item-emoji { font-size: 3rem; width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; border-radius: 12px; }
  .cart-item-info { flex: 1; }
  .cart-item-name { font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; margin-bottom: 4px; }
  .cart-item-price { color: var(--coral); font-weight: 800; font-size: 1rem; }
  .qty-controls { display: flex; align-items: center; gap: 10px; }
  .qty-btn { width: 32px; height: 32px; border: 2.5px solid var(--dark); border-radius: 50%; background: var(--cream); font-size: 1rem; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.15s; }
  .qty-btn:hover { background: var(--dark); color: white; }
  .qty-num { font-weight: 800; font-size: 1rem; min-width: 24px; text-align: center; }
  .remove-form button { background: none; border: none; cursor: pointer; color: var(--coral); font-size: 1.3rem; padding: 4px; transition: transform 0.15s; }
  .remove-form button:hover { transform: scale(1.2); }
  .cart-summary { background: white; border: 3px solid var(--dark); border-radius: 16px; padding: 28px; box-shadow: 6px 6px 0 var(--dark); margin-top: 24px; }
  .summary-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; font-weight: 700; }
  .summary-row.total { border-top: 3px solid var(--dark); margin-top: 8px; padding-top: 18px; font-size: 1.3rem; font-family: 'Playfair Display', serif; }
  .summary-row.total span:last-child { color: var(--coral); }
  .checkout-btn { width: 100%; padding: 18px; background: var(--teal); color: var(--dark); border: 3px solid var(--dark); border-radius: 50px; font-family: 'Nunito', sans-serif; font-size: 1.1rem; font-weight: 800; cursor: pointer; margin-top: 20px; box-shadow: 5px 5px 0 var(--dark); transition: all 0.15s; }
  .checkout-btn:hover { transform: translate(-2px, -2px); box-shadow: 7px 7px 0 var(--dark); }
  .free-ship-note { font-size: 0.8rem; color: var(--mid); font-weight: 700; margin-top: -8px; }
  .empty-cart { text-align: center; padding: 80px 20px; }
  .empty-cart .big-emoji { font-size: 5rem; margin-bottom: 20px; }
  .empty-cart h3 { font-family: 'Playfair Display', serif; font-size: 1.8rem; margin-bottom: 12px; }
  .empty-cart p { color: var(--mid); font-weight: 600; margin-bottom: 28px; }
</style>
@endpush

@section('content')

<div class="section">
  <div class="section-header">
    <div class="section-tag" style="background: var(--gold);">🛒 Your Cart</div>
    <h2>Ready to Checkout?</h2>
  </div>

  <div class="cart-container">

    @if(empty($cartItems))
      {{-- Empty Cart --}}
      <div class="empty-cart">
        <div class="big-emoji">🧺</div>
        <h3>Your cart is empty</h3>
        <p>Head to the shop and find something beautiful!</p>
        <a class="btn-primary" href="{{ route('shop') }}">🌸 Browse Shop</a>
      </div>

    @else
      {{-- Cart Items --}}
      @foreach($cartItems as $item)
        <div class="cart-item">
          <div class="cart-item-emoji" style="background: {{ $item['product']->color }}">
            {{ $item['product']->emoji }}
          </div>
          <div class="cart-item-info">
            <div class="cart-item-name">{{ $item['product']->name }}</div>
            <div class="cart-item-price">${{ number_format($item['product']->price * $item['qty'], 2) }}</div>
          </div>

          {{-- Quantity Controls --}}
          <div class="qty-controls">
            <form action="{{ route('cart.add', $item['product']->id) }}" method="POST">
              @csrf
              <input type="hidden" name="action" value="decrease">
              <button type="submit" class="qty-btn">−</button>
            </form>
            <span class="qty-num">{{ $item['qty'] }}</span>
            <form action="{{ route('cart.add', $item['product']->id) }}" method="POST">
              @csrf
              <button type="submit" class="qty-btn">+</button>
            </form>
          </div>

          {{-- Remove --}}
          <form class="remove-form" action="{{ route('cart.remove', $item['product']->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">🗑</button>
          </form>
        </div>
      @endforeach

      {{-- Order Summary --}}
      <div class="cart-summary">
        <div class="summary-row">
          <span>Subtotal</span>
          <span>${{ number_format($subtotal, 2) }}</span>
        </div>
        <div class="summary-row">
          <span>Shipping</span>
          <span>{{ $shipping == 0 ? '🎉 Free!' : '$' . number_format($shipping, 2) }}</span>
        </div>
        @if($shipping > 0)
          <p class="free-ship-note">Free shipping on orders over $60</p>
        @endif
        <div class="summary-row total">
          <span>Total</span>
          <span>${{ number_format($total, 2) }}</span>
        </div>

        <form action="{{ route('cart.checkout') }}" method="POST">
          @csrf
          <button type="submit" class="checkout-btn">
            ✨ Checkout — ${{ number_format($total, 2) }}
          </button>
        </form>
      </div>

    @endif
  </div>
</div>

@endsection
