<div class="product-card">
  <a href="{{ route('product.detail', $product->id) }}" style="text-decoration:none; color:inherit;">
    <div class="product-img" style="background: {{ $product->color }}">

      @if($product->image)
        {{-- Real uploaded image --}}
        <img src="{{ asset('storage/' . $product->image) }}"
             alt="{{ $product->name }}"
             style="width:100%; height:100%; object-fit:cover; display:block;" />
      @else
        {{-- Fallback emoji --}}
        <span>{{ $product->emoji }}</span>
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
          <span class="add-to-cart-btn" style="opacity:0.5; cursor:not-allowed;">Sold Out</span>
        @endif
      </div>
    </div>
  </a>
</div>
