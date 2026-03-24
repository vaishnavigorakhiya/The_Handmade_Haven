@php
    // Check if this product is in the current user's wishlist
    $isWishlisted = false;
    if (auth()->check()) {
        $isWishlisted = \App\Models\Wishlist::where('user_id', auth()->id())
                                            ->where('product_id', $product->id)
                                            ->exists();
    }
@endphp

<div class="product-card">
    {{-- Wishlist heart button --}}
    <div style="position: relative;">
        @auth
            <button
                class="heart-btn {{ $isWishlisted ? 'wishlisted' : '' }}"
                data-product-id="{{ $product->id }}"
                data-wishlisted="{{ $isWishlisted ? 'true' : 'false' }}"
                onclick="toggleWishlist(this, {{ $product->id }})"
                title="{{ $isWishlisted ? 'Remove from wishlist' : 'Save to wishlist' }}">
                {{ $isWishlisted ? '❤️' : '🤍' }}
            </button>
        @else
            {{-- Guest sees heart but clicking opens login modal --}}
            <button class="heart-btn"
                    onclick="openLoginModal()"
                    title="Login to save to wishlist">
                🤍
            </button>
        @endauth
    </div>

    <a href="{{ route('product.detail', $product->id) }}"
       style="text-decoration:none; color:inherit;">
        <div class="product-img"
             style="background: {{ $product->color ?? '#FFE8D6' }}">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="product-img-photo"
                     onerror="this.parentElement.classList.add('img-fallback');
                              this.style.display='none';" />
            @else
                <div class="product-img-placeholder">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round"
                         style="color:rgba(0,0,0,0.25)">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
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
            <div class="product-desc">
                {{ \Illuminate\Support\Str::limit($product->description, 80) }}            
            </div>
            <div class="product-footer">
                <div class="product-price">
                    ₹{{ number_format($product->price, 2) }}
                </div>
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product->id) }}"
                          method="POST">
                        @csrf
                        <button type="submit" class="add-to-cart-btn">
                            + Add
                        </button>
                    </form>
                @else
                    <span class="add-to-cart-btn out-of-stock">Sold Out</span>
                @endif
            </div>
        </div>
    </a>
</div>

<style>
.product-img          { position: relative; height: 220px; overflow: hidden;
                        display: flex; align-items: center; justify-content: center; }
.product-img-photo    { width: 100%; height: 100%; object-fit: cover;
                        display: block; transition: transform 0.4s ease; }
.product-card:hover .product-img-photo { transform: scale(1.05); }
.product-img-placeholder { display: flex; flex-direction: column;
                            align-items: center; justify-content: center;
                            gap: 8px; width: 100%; height: 100%;
                            color: rgba(0,0,0,0.3); }
.product-img-placeholder span { font-size: 0.75rem; font-weight: 700;
                                 letter-spacing: 0.05em; text-transform: uppercase; }
.add-to-cart-btn.out-of-stock { opacity: 0.45; cursor: not-allowed;
                                 pointer-events: none; }

/* Heart button */
.heart-btn            { position: absolute; top: 10px; right: 10px;
                        background: white; border: 2px solid var(--dark);
                        border-radius: 50%; width: 34px; height: 34px;
                        display: flex; align-items: center; justify-content: center;
                        font-size: 0.9rem; cursor: pointer;
                        box-shadow: 2px 2px 0 var(--dark);
                        transition: all 0.2s; z-index: 2; }
.heart-btn:hover      { transform: scale(1.15); }
.heart-btn.wishlisted { background: #FFE8E8; border-color: var(--p1); }
</style>

<script>
function toggleWishlist(btn, productId) {
    const token = document.querySelector('meta[name="csrf-token"]').content;

    fetch('/wishlist/toggle/' + productId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept':       'application/json',
            'Content-Type': 'application/json',
        },
    })
    .then(r => r.json())
    .then(data => {
        // Update the button instantly — no page reload needed
        btn.textContent      = data.wishlisted ? '❤️' : '🤍';
        btn.dataset.wishlisted = data.wishlisted ? 'true' : 'false';
        btn.classList.toggle('wishlisted', data.wishlisted);
        btn.title = data.wishlisted ? 'Remove from wishlist' : 'Save to wishlist';
    })
    .catch(() => {
        // Silently fail — don't break the page
    });
}
</script>