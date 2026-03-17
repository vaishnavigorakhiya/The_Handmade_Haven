<div class="product-card">
  <a href="{{ route('product.detail', $product->id) }}" style="text-decoration:none; color:inherit;">
    <div class="product-img" style="background: {{ $product->color ?? '#FFE8D6' }}">
      @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-img-photo"
             onerror="this.parentElement.classList.add('img-fallback'); this.style.display='none';" />
      @else
        <div class="product-img-placeholder">
          <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color:rgba(0,0,0,0.25)">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
          </svg>
          <span>No image</span>
        </div>
      @endif
      @if($product->badge)
        <div class="product-badge">{{ $product->badge }}</div>
      @endif
    </div>
    <div class="product-info">
      <div class="product-category">{{ $product->category }}</div>
      <div class="product-name">{{ $product->name }}</div>
      <div class="product-desc">{{ Str::limit($product->description, 80) }}</div>
      <div class="product-footer">
        <div class="product-price">${{ number_format($product->price, 2) }}</div>
        @if($product->stock > 0)
          <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="add-to-cart-btn">+ Add</button>
          </form>
        @else
          <span class="add-to-cart-btn out-of-stock">Sold Out</span>
        @endif
      </div>
    </div>
  </a>
</div>

<style>
.product-img { position: relative; height: 220px; overflow: hidden; display: flex; align-items: center; justify-content: center; }
.product-img-photo { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.4s ease; }
.product-card:hover .product-img-photo { transform: scale(1.05); }
.product-img-placeholder { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; width: 100%; height: 100%; color: rgba(0,0,0,0.3); }
.product-img-placeholder span { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; }
.add-to-cart-btn.out-of-stock { opacity: 0.45; cursor: not-allowed; pointer-events: none; }
</style>
