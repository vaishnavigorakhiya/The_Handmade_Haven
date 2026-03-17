@extends('layouts.app')
@section('title', 'Checkout — Stitch & Bloom')

@push('styles')
<style>
.checkout-wrap { max-width: 960px; margin: 0 auto; display: grid; grid-template-columns: 1fr 380px; gap: 32px; align-items: start; }
.checkout-form-section { background: white; border: 3px solid var(--dark); border-radius: 20px; padding: 32px; box-shadow: 6px 6px 0 var(--dark); }
.checkout-section-title { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 800; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-group { display: flex; flex-direction: column; gap: 5px; }
.form-group.full { grid-column: 1 / -1; }
.form-label { font-size: 0.78rem; font-weight: 800; color: var(--mid); text-transform: uppercase; letter-spacing: 0.05em; }
.form-input { padding: 12px 14px; border: 2.5px solid var(--dark); border-radius: 11px; font-family: 'Nunito', sans-serif; font-size: 0.94rem; font-weight: 600; background: var(--cream); outline: none; transition: border-color 0.2s; width: 100%; }
.form-input:focus { border-color: var(--coral); background: white; }
.form-input.is-invalid { border-color: var(--coral) !important; background: #fff5f5; }
.ferr { color: var(--coral); font-size: 0.77rem; font-weight: 700; min-height: 16px; }
.ferr:not(:empty)::before { content: '⚠ '; }

/* Order Summary */
.order-summary { background: white; border: 3px solid var(--dark); border-radius: 20px; padding: 28px; box-shadow: 6px 6px 0 var(--dark); position: sticky; top: 90px; }
.summary-title { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 800; margin-bottom: 20px; }
.summary-items { border-bottom: 2px solid var(--cream); padding-bottom: 16px; margin-bottom: 16px; }
.summary-item { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
.summary-item:last-child { margin-bottom: 0; }
.summary-item-img { width: 48px; height: 48px; border-radius: 10px; border: 2px solid var(--dark); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; overflow: hidden; }
.summary-item-img img { width: 100%; height: 100%; object-fit: cover; }
.summary-item-info { flex: 1; }
.summary-item-name { font-weight: 800; font-size: 0.88rem; margin-bottom: 2px; }
.summary-item-qty { font-size: 0.78rem; color: var(--mid); font-weight: 600; }
.summary-item-price { font-weight: 800; color: var(--coral); font-size: 0.95rem; }
.summary-row { display: flex; justify-content: space-between; padding: 8px 0; font-weight: 700; font-size: 0.92rem; }
.summary-row.total { border-top: 2.5px solid var(--dark); margin-top: 8px; padding-top: 14px; font-family: 'Playfair Display', serif; font-size: 1.2rem; }
.summary-row.total span:last-child { color: var(--coral); }

/* Place order button */
.place-order-btn { width: 100%; padding: 16px; background: var(--coral); color: white; border: 3px solid var(--dark); border-radius: 50px; font-family: 'Nunito', sans-serif; font-size: 1rem; font-weight: 800; cursor: pointer; box-shadow: 5px 5px 0 var(--dark); transition: all 0.15s; margin-top: 20px; }
.place-order-btn:hover { transform: translate(-2px, -2px); box-shadow: 7px 7px 0 var(--dark); }

/* Secure badges */
.secure-badges { display: flex; gap: 12px; justify-content: center; margin-top: 16px; flex-wrap: wrap; }
.secure-badge { font-size: 0.75rem; font-weight: 700; color: var(--mid); display: flex; align-items: center; gap: 4px; }

@media(max-width: 860px) {
    .checkout-wrap { grid-template-columns: 1fr; }
    .order-summary { position: static; }
    .form-grid { grid-template-columns: 1fr; }
    .form-group.full { grid-column: 1; }
}
</style>
@endpush

@section('content')
<div class="section">
    <a class="back-btn" href="{{ route('cart') }}">← Back to Cart</a>

    <div class="section-header" style="margin-bottom: 36px;">
        <div class="section-tag" style="background: var(--teal);">🛒 Checkout</div>
        <h2>Complete Your Order</h2>
    </div>

    <form action="{{ route('cart.checkout') }}" method="POST" id="checkoutForm" novalidate>
        @csrf
        <div class="checkout-wrap">

            {{-- LEFT: Address Form --}}
            <div class="checkout-form-section">
                <div class="checkout-section-title">📦 Delivery Address</div>

                <div class="form-grid">
                    <div class="form-group full">
                        <label class="form-label">Full Name *</label>
                        <input class="form-input {{ $errors->has('full_name') ? 'is-invalid' : '' }}"
                               name="full_name" id="full_name"
                               value="{{ old('full_name', Auth::user()->name) }}"
                               placeholder="e.g. Priya Sharma" />
                        <div class="ferr">{{ $errors->first('full_name') }}</div>
                    </div>

                    <div class="form-group full">
                        <label class="form-label">Phone Number *</label>
                        <input class="form-input {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                               name="phone" id="phone"
                               value="{{ old('phone', Auth::user()->phone) }}"
                               placeholder="e.g. 9876543210" />
                        <div class="ferr">{{ $errors->first('phone') }}</div>
                    </div>

                    <div class="form-group full">
                        <label class="form-label">Street Address / Flat / House No. *</label>
                        <input class="form-input {{ $errors->has('address_line') ? 'is-invalid' : '' }}"
                               name="address_line" id="address_line"
                               value="{{ old('address_line') }}"
                               placeholder="e.g. 42, Rose Garden, MG Road" />
                        <div class="ferr">{{ $errors->first('address_line') }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">City *</label>
                        <input class="form-input {{ $errors->has('city') ? 'is-invalid' : '' }}"
                               name="city" id="city"
                               value="{{ old('city') }}"
                               placeholder="e.g. Mumbai" />
                        <div class="ferr">{{ $errors->first('city') }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">State *</label>
                        <input class="form-input {{ $errors->has('state') ? 'is-invalid' : '' }}"
                               name="state" id="state"
                               value="{{ old('state') }}"
                               placeholder="e.g. Maharashtra" />
                        <div class="ferr">{{ $errors->first('state') }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">PIN / ZIP Code *</label>
                        <input class="form-input {{ $errors->has('pincode') ? 'is-invalid' : '' }}"
                               name="pincode" id="pincode"
                               value="{{ old('pincode') }}"
                               placeholder="e.g. 400001" />
                        <div class="ferr">{{ $errors->first('pincode') }}</div>
                    </div>
                </div>

                {{-- Payment note --}}
                <div style="margin-top:24px; padding:18px; background:var(--cream); border:2px dashed var(--dark); border-radius:14px;">
                    <div style="font-weight:800; font-size:0.9rem; margin-bottom:6px;">💵 Payment Method</div>
                    <div style="font-weight:700; font-size:0.85rem; color:var(--mid);">
                        Cash on Delivery (COD) — Pay when your order arrives at your door.
                    </div>
                </div>
            </div>

            {{-- RIGHT: Order Summary --}}
            <div class="order-summary">
                <div class="summary-title">🛍 Order Summary</div>

                <div class="summary-items">
                    @foreach($cartItems as $item)
                        <div class="summary-item">
                            <div class="summary-item-img" style="background:{{ $item['product']->color }}">
                                @if($item['product']->image)
                                    <img src="{{ asset('storage/'.$item['product']->image) }}"
                                         alt="{{ $item['product']->name }}"
                                         onerror="this.style.display='none';this.parentElement.innerHTML='{{ $item['product']->emoji }}';" />
                                @else
                                    {{ $item['product']->emoji }}
                                @endif
                            </div>
                            <div class="summary-item-info">
                                <div class="summary-item-name">{{ $item['product']->name }}</div>
                                <div class="summary-item-qty">Qty: {{ $item['qty'] }}</div>
                            </div>
                            <div class="summary-item-price">${{ number_format($item['product']->price * $item['qty'], 2) }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>{{ $shipping == 0 ? '🎉 Free!' : '$'.number_format($shipping, 2) }}</span>
                </div>
                @if($shipping > 0)
                    <div style="font-size:0.77rem; color:var(--mid); font-weight:700; text-align:right;">Free shipping on orders over $60</div>
                @endif
                <div class="summary-row total">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>

                <button type="submit" class="place-order-btn" onclick="return validateCheckout()">
                    ✅ Place Order — ${{ number_format($total, 2) }}
                </button>

                <div class="secure-badges">
                    <span class="secure-badge">🔒 Secure</span>
                    <span class="secure-badge">📦 Fast Delivery</span>
                    <span class="secure-badge">✅ COD Available</span>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function validateCheckout() {
    let ok = true;
    const fields = [
        { id: 'full_name',    msg: 'Please enter your full name.' },
        { id: 'phone',        msg: 'Please enter your phone number.' },
        { id: 'address_line', msg: 'Please enter your street address.' },
        { id: 'city',         msg: 'Please enter your city.' },
        { id: 'state',        msg: 'Please enter your state.' },
        { id: 'pincode',      msg: 'Please enter your PIN / ZIP code.' },
    ];

    fields.forEach(f => {
        const el  = document.getElementById(f.id);
        const err = el.parentElement.querySelector('.ferr');
        if (!el.value.trim()) {
            el.classList.add('is-invalid');
            if (err) err.textContent = f.msg;
            ok = false;
        } else {
            el.classList.remove('is-invalid');
            if (err) err.textContent = '';
        }
    });

    if (!ok) {
        document.querySelector('.is-invalid').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    return ok;
}
</script>
@endpush
