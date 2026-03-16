@extends('layouts.app')
@section('title', $product->name . ' — Stitch & Bloom')

@push('styles')
<style>
  /* ── Detail layout ── */
  .detail-container {
    max-width: 1100px; margin: 0 auto;
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 60px; align-items: start;
  }

  /* ── Image box ── */
  .detail-img-box {
    border: 3px solid var(--dark); border-radius: 24px;
    height: 460px; overflow: hidden;
    box-shadow: 8px 8px 0 var(--dark); position: relative;
    background: {{ $product->color ?? '#FFE8D6' }};
    display: flex; align-items: center; justify-content: center;
  }
  .detail-img-box img {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform 0.4s ease;
  }
  .detail-img-box:hover img { transform: scale(1.04); }

  /* Placeholder when no image */
  .detail-img-placeholder {
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; gap: 16px; padding: 40px;
    text-align: center; color: rgba(0,0,0,0.3);
  }
  .detail-img-placeholder svg { width: 80px; height: 80px; }
  .detail-img-placeholder p { font-size: 0.9rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; }

  /* Badge overlay on image */
  .detail-img-badge {
    position: absolute; top: 18px; right: 18px;
    background: var(--gold); border: 2.5px solid var(--dark);
    border-radius: 50px; padding: 5px 16px;
    font-size: 0.8rem; font-weight: 800;
    box-shadow: 3px 3px 0 var(--dark);
  }

  /* ── Info panel ── */
  .detail-info { padding-top: 12px; }
  .detail-info .product-category {
    font-size: 0.82rem; font-weight: 800; text-transform: uppercase;
    letter-spacing: 0.1em; color: var(--mid); margin-bottom: 10px;
  }
  .detail-info h1 {
    font-family: 'Playfair Display', serif; font-size: 2.2rem;
    font-weight: 900; line-height: 1.15; margin-bottom: 16px;
  }
  .detail-price { font-size: 2rem; font-weight: 800; color: var(--coral); margin-bottom: 20px; }
  .detail-desc {
    color: var(--mid); font-weight: 600; line-height: 1.75;
    font-size: 1rem; margin-bottom: 28px;
    padding-bottom: 24px; border-bottom: 2px solid var(--cream);
  }
  .detail-tags { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 28px; }
  .detail-tag {
    padding: 6px 16px; border: 2px solid var(--dark); border-radius: 50px;
    font-size: 0.8rem; font-weight: 800; background: var(--cream);
    box-shadow: 2px 2px 0 var(--dark);
  }
  .stock-status { margin-bottom: 24px; font-weight: 700; font-size: 0.95rem; }
  .stock-status span { display: inline-flex; align-items: center; gap: 6px; }

  /* ── Add to cart button ── */
  .detail-add-btn {
    width: 100%; padding: 18px;
    background: var(--coral); color: white;
    border: 3px solid var(--dark); border-radius: 50px;
    font-family: 'Nunito', sans-serif; font-size: 1.1rem; font-weight: 800;
    cursor: pointer; box-shadow: 5px 5px 0 var(--dark);
    transition: all 0.15s;
  }
  .detail-add-btn:hover:not(:disabled) { transform: translate(-2px, -2px); box-shadow: 7px 7px 0 var(--dark); }
  .detail-add-btn:disabled { opacity: 0.5; cursor: not-allowed; }

  /* ── Meta row ── */
  .detail-meta {
    display: flex; gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
  }
  .detail-meta-chip {
    display: flex; align-items: center; gap: 6px;
    padding: 6px 14px; background: white;
    border: 2px solid var(--dark); border-radius: 50px;
    font-size: 0.82rem; font-weight: 700;
    box-shadow: 2px 2px 0 var(--dark);
  }

  @media (max-width: 900px) {
    .detail-container { grid-template-columns: 1fr; gap: 32px; }
    .detail-img-box { height: 320px; }
    .detail-info h1 { font-size: 1.7rem; }
  }
</style>
@endpush

@section('content')

<div class="section">
  <a class="back-btn" href="{{ route('shop') }}">← Back to Shop</a>

  <div class="detail-container">

    {{-- ── Product Image ── --}}
    <div class="detail-img-box">
      @if($product->image)
        <img
          src="{{ asset('storage/' . $product->image) }}"
          alt="{{ $product->name }}"
          onerror="this.closest('.detail-img-box').classList.add('show-placeholder'); this.style.display='none';"
        />
      @else
        <div class="detail-img-placeholder">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
            <circle cx="8.5" cy="8.5" r="1.5"/>
            <polyline points="21 15 16 10 5 21"/>
          </svg>
          <p>No image uploaded yet</p>
        </div>
      @endif

      @if($product->badge)
        <div class="detail-img-badge">{{ $product->badge }}</div>
      @endif
    </div>

    {{-- ── Product Info ── --}}
    <div class="detail-info">

      <div class="product-category">{{ $product->category }}</div>
      <h1>{{ $product->name }}</h1>
      <div class="detail-price">${{ number_format($product->price, 2) }}</div>

      {{-- Meta chips --}}
      <div class="detail-meta">
        <div class="detail-meta-chip">
          📦
          @if($product->stock === 0) Out of stock
          @elseif($product->stock <= 3) Only {{ $product->stock }} left
          @else {{ $product->stock }} in stock
          @endif
        </div>
        <div class="detail-meta-chip">🏷 {{ $product->category }}</div>
      </div>

      <div class="detail-desc">{{ $product->description }}</div>

      {{-- Tags --}}
      @if($product->tags)
        @php $tags = json_decode($product->tags, true); @endphp
        @if(is_array($tags) && count($tags))
          <div class="detail-tags">
            @foreach($tags as $tag)
              <span class="detail-tag">{{ $tag }}</span>
            @endforeach
          </div>
        @endif
      @endif

      {{-- Stock Status --}}
      <div class="stock-status">
        @if($product->stock === 0)
          <span style="color:var(--coral);">❌ Out of Stock</span>
        @elseif($product->stock <= 3)
          <span style="color:#e67e22;">⚠️ Only {{ $product->stock }} left — order soon!</span>
        @else
          <span style="color:var(--teal);">✅ In Stock</span>
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
