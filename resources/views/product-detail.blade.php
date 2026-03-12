@extends('layouts.app')
@section('title', $product->name . ' — Stitch & Bloom')

@push('styles')
<style>
  .detail-container { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: start; }
  .detail-img-box { border: 3px solid var(--dark); border-radius: 24px; height: 420px; display: flex; align-items: center; justify-content: center; font-size: 8rem; box-shadow: 8px 8px 0 var(--dark); }
  .detail-info { padding-top: 20px; }
  .detail-info .product-category { font-size: 0.85rem; margin-bottom: 10px; }
  .detail-info h1 { font-family: 'Playfair Display', serif; font-size: 2.4rem; font-weight: 900; line-height: 1.15; margin-bottom: 16px; }
  .detail-price { font-size: 2rem; font-weight: 800; color: var(--coral); margin-bottom: 24px; }
  .detail-desc { color: var(--mid); font-weight: 600; line-height: 1.7; font-size: 1rem; margin-bottom: 28px; }
  .detail-tags { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 32px; }
  .detail-tag { padding: 6px 16px; border: 2px solid var(--dark); border-radius: 50px; font-size: 0.8rem; font-weight: 800; background: var(--cream); box-shadow: 2px 2px 0 var(--dark); }
  .stock-status { margin-bottom: 20px; font-weight: 700; font-size: 1rem; }
  .detail-add-btn { width: 100%; padding: 18px; background: var(--coral); color: white; border: 3px solid var(--dark); border-radius: 50px; font-family: 'Nunito', sans-serif; font-size: 1.1rem; font-weight: 800; cursor: pointer; box-shadow: 5px 5px 0 var(--dark); transition: all 0.15s; }
  .detail-add-btn:hover { transform: translate(-2px, -2px); box-shadow: 7px 7px 0 var(--dark); }
  .detail-add-btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
  @media (max-width: 900px) { .detail-container { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

<div class="section">
  <a class="back-btn" href="{{ route('shop') }}">← Back to Shop</a>

  <div class="detail-container">

    {{-- Product Image --}}
    <div class="detail-img-box" style="background: {{ $product->color }}">
      {{ $product->emoji }}
    </div>

    {{-- Product Info --}}
    <div class="detail-info">
      <div class="product-category">{{ $product->category }}</div>
      <h1>{{ $product->name }}</h1>
      <div class="detail-price">${{ number_format($product->price, 2) }}</div>
      <div class="detail-desc">{{ $product->description }}</div>

      {{-- Tags --}}
      @if($product->tags)
        <div class="detail-tags">
          @foreach(json_decode($product->tags) as $tag)
            <span class="detail-tag">{{ $tag }}</span>
          @endforeach
        </div>
      @endif

      {{-- Stock Status --}}
      <div class="stock-status">
        @if($product->stock === 0)
          <span style="color: var(--coral);">❌ Out of Stock</span>
        @elseif($product->stock <= 3)
          <span style="color: #e67e22;">⚠️ Only {{ $product->stock }} left!</span>
        @else
          <span style="color: var(--teal);">✅ In Stock ({{ $product->stock }} available)</span>
        @endif
      </div>

      {{-- Add to Cart --}}
      <form action="{{ route('cart.add', $product->id) }}" method="POST">
        @csrf
        <button type="submit" class="detail-add-btn" {{ $product->stock === 0 ? 'disabled' : '' }}>
          🛒 Add to Cart
        </button>
      </form>
    </div>

  </div>
</div>

@endsection
