@extends('layouts.app')
@section('title', 'My Wishlist — Soochikaari')

@push('styles')
<style>
.wishlist-wrap   { max-width: 960px; margin: 0 auto; }
.wishlist-grid   { display: grid;
                   grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                   gap: 22px; }
.wish-card       { background: white; border: 2.5px solid var(--dark);
                   border-radius: 18px; overflow: hidden;
                   box-shadow: 5px 5px 0 var(--dark);
                   transition: transform 0.15s; }
.wish-card:hover { transform: translate(-2px, -2px);
                   box-shadow: 7px 7px 0 var(--dark); }
.wish-img        { height: 200px; display: flex; align-items: center;
                   justify-content: center; font-size: 4rem;
                   position: relative; overflow: hidden; }
.wish-img img    { width: 100%; height: 100%; object-fit: cover; }
.wish-remove     { position: absolute; top: 10px; right: 10px;
                   background: white; border: 2px solid var(--dark);
                   border-radius: 50%; width: 32px; height: 32px;
                   display: flex; align-items: center; justify-content: center;
                   cursor: pointer; font-size: 0.9rem;
                   box-shadow: 2px 2px 0 var(--dark);
                   transition: all 0.15s; }
.wish-remove:hover { background: var(--p1); color: white; border-color: var(--p1); }
.wish-info       { padding: 16px 18px; }
.wish-cat        { font-size: 0.7rem; font-weight: 800; text-transform: uppercase;
                   letter-spacing: 0.08em; color: var(--p3); margin-bottom: 4px; }
.wish-name       { font-family: 'Playfair Display', serif; font-size: 1.05rem;
                   font-weight: 700; margin-bottom: 10px; line-height: 1.3; }
.wish-footer     { display: flex; align-items: center;
                   justify-content: space-between; gap: 8px; }
.wish-price      { font-size: 1.2rem; font-weight: 800; color: var(--p1); }
.wish-add-btn    { padding: 8px 16px; background: var(--dark); color: white;
                   border: none; border-radius: 50px;
                   font-family: 'Nunito', sans-serif;
                   font-size: 0.8rem; font-weight: 800; cursor: pointer;
                   transition: all 0.15s; }
.wish-add-btn:hover { background: var(--p1); }
.wish-out        { padding: 8px 16px; background: var(--cream); color: var(--mid);
                   border: 2px solid var(--border); border-radius: 50px;
                   font-size: 0.78rem; font-weight: 800; cursor: not-allowed; }
.empty-wrap      { text-align: center; padding: 80px 20px; }
.empty-wrap .big { font-size: 5rem; margin-bottom: 16px; }
.empty-wrap h3   { font-family: 'Playfair Display', serif; font-size: 1.8rem;
                   font-weight: 900; margin-bottom: 12px; }
.empty-wrap p    { color: var(--mid); font-weight: 600; margin-bottom: 28px; }
</style>
@endpush

@section('content')
<div class="section">
    <div class="section-header">
        <div class="section-tag" style="background: var(--bg5);">
            ❤️ My Wishlist
        </div>
        <h2>Saved for Later</h2>
        @if($wishlists->count() > 0)
            <p style="color: var(--mid); font-weight: 600; margin-top: 8px;">
                {{ $wishlists->count() }} item{{ $wishlists->count() !== 1 ? 's' : '' }} saved
            </p>
        @endif
    </div>

    <div class="wishlist-wrap">
        @if($wishlists->isEmpty())
            <div class="empty-wrap">
                <div class="big">🤍</div>
                <h3>Your wishlist is empty</h3>
                <p>Browse the shop and tap the ❤️ on anything you love!</p>
                <a class="btn-primary" href="{{ route('shop') }}">🌸 Browse Shop</a>
            </div>
        @else
            <div class="wishlist-grid">
                @foreach($wishlists as $wish)
                    @if($wish->product)
                        <div class="wish-card">
                            <div class="wish-img"
                                 style="background: {{ $wish->product->color ?? '#FFE8D6' }}">
                                @if($wish->product->image)
                                    <img src="{{ asset('storage/' . $wish->product->image) }}"
                                         alt="{{ $wish->product->name }}"
                                         onerror="this.style.display='none'" />
                                @else
                                    {{ $wish->product->emoji ?? '🧵' }}
                                @endif

                                {{-- Remove button --}}
                                <form action="{{ route('wishlist.remove', $wish->product->id) }}"
                                      method="POST" style="display:contents;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="wish-remove"
                                            title="Remove from wishlist">✕</button>
                                </form>
                            </div>

                            <div class="wish-info">
                                <div class="wish-cat">{{ $wish->product->category }}</div>
                                <a href="{{ route('product.detail', $wish->product->id) }}"
                                   style="text-decoration:none; color:inherit;">
                                    <div class="wish-name">{{ $wish->product->name }}</div>
                                </a>
                                <div class="wish-footer">
                                    <div class="wish-price">
                                        ₹{{ number_format($wish->product->price, 2) }}
                                    </div>
                                    @if($wish->product->stock > 0)
                                        <form action="{{ route('cart.add', $wish->product->id) }}"
                                              method="POST">
                                            @csrf
                                            <button type="submit" class="wish-add-btn">
                                                🛒 Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <span class="wish-out">Sold Out</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Quick action at bottom --}}
            <div style="text-align:center; margin-top: 40px;">
                <a href="{{ route('shop') }}" class="btn-secondary">
                    + Keep Browsing
                </a>
            </div>
        @endif
    </div>
</div>
@endsection