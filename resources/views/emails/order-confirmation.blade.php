<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmed — Soochikaari</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Arial, sans-serif;
               background: #FAF7F4; color: #3A3A3A; padding: 40px 20px; }
        .wrapper { max-width: 600px; margin: 0 auto; }
        .strip { height: 5px; background: linear-gradient(90deg,#D4956A,#C9A96E,#6FA89A,#8B7BB5,#C49BA0); border-radius: 4px 4px 0 0; }
        .header { background: linear-gradient(135deg,#FFE8D6,#FFD6E8,#E8D6FF);
                  border: 3px solid #3A3A3A; border-top: none;
                  padding: 32px 36px 24px; }
        .brand { font-family: Georgia, serif; font-size: 1.4rem;
                 font-weight: 900; color: #3A3A3A; margin-bottom: 4px; }
        .brand span { color: #D4956A; }
        .brand-sub { font-size: 0.72rem; color: #9A9A9A; text-transform: uppercase;
                     letter-spacing: 0.06em; }
        .body { background: white; border: 3px solid #3A3A3A;
                border-top: none; padding: 32px 36px;
                box-shadow: 6px 6px 0 #3A3A3A; }
        .tag { display: inline-block; padding: 4px 14px; border-radius: 50px;
               font-size: 0.72rem; font-weight: 800; text-transform: uppercase;
               letter-spacing: 0.1em; border: 1.5px solid #E2D9D0;
               background: rgba(212,149,106,0.08); color: #D4956A; margin-bottom: 10px; }
        h1 { font-family: Georgia, serif; font-size: 1.6rem; font-weight: 900;
             color: #3A3A3A; margin-bottom: 6px; }
        .subtitle { font-size: 0.88rem; color: #9A9A9A; font-weight: 600;
                    margin-bottom: 24px; line-height: 1.5; }
        .divider { height: 2px; background: #FAF7F4; margin: 20px 0; }
        .meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
        .meta-item label { font-size: 0.7rem; font-weight: 800; text-transform: uppercase;
                           letter-spacing: 0.07em; color: #9A9A9A; display: block; margin-bottom: 3px; }
        .meta-item p { font-size: 0.9rem; font-weight: 700; color: #3A3A3A; }
        .item-row { display: flex; align-items: center; justify-content: space-between;
                    padding: 12px 0; border-bottom: 1.5px solid #FAF7F4; font-size: 0.88rem; }
        .item-row:last-child { border-bottom: none; }
        .item-name { font-weight: 800; }
        .item-qty { color: #9A9A9A; font-size: 0.78rem; margin-top: 2px; }
        .item-price { font-weight: 800; color: #D4956A; }
        .total-row { display: flex; justify-content: space-between; padding: 8px 0;
                     font-size: 0.9rem; font-weight: 700; }
        .total-row.grand { border-top: 2.5px solid #3A3A3A; margin-top: 8px;
                           padding-top: 14px; font-size: 1.1rem; }
        .total-row.grand span:last-child { color: #D4956A; }
        .cta-wrap { margin-top: 28px; text-align: center; }
        .cta-btn { display: inline-block; padding: 14px 32px; background: #D4956A;
                   color: white; text-decoration: none; font-size: 0.95rem;
                   font-weight: 800; border-radius: 50px; border: 2px solid #3A3A3A;
                   box-shadow: 4px 4px 0 #3A3A3A; }
        .footer { margin-top: 28px; text-align: center; }
        .footer-logo { font-family: Georgia, serif; font-size: 1rem;
                       font-weight: 900; color: #D4956A; margin-bottom: 4px; }
        .footer-copy { font-size: 0.72rem; color: #9A9A9A; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="strip"></div>

    <div class="header">
        <div class="brand">🪡 <span>Soochi</span>kaari</div>
        <div class="brand-sub">The Art of Indian Embroidery</div>
    </div>

    <div class="body">
        <div class="tag">✅ Order Confirmed</div>
        <h1>Thank you, {{ $order->full_name ?? 'dear customer' }}! 🎉</h1>
        <p class="subtitle">
            Your order <strong>#{{ $order->id }}</strong> has been placed successfully.
            We'll start preparing it with love — expect delivery within 5–7 working days.
        </p>

        <div class="divider"></div>

        {{-- Order meta --}}
        <div class="meta-grid">
            <div class="meta-item">
                <label>Order Number</label>
                <p>#{{ $order->id }}</p>
            </div>
            <div class="meta-item">
                <label>Order Date</label>
                <p>{{ $order->created_at->format('d M Y') }}</p>
            </div>
            <div class="meta-item">
                <label>Payment</label>
                <p>Cash on Delivery</p>
            </div>
            <div class="meta-item">
                <label>Status</label>
                <p>{{ ucfirst($order->status) }}</p>
            </div>
            @if($order->address)
            <div class="meta-item" style="grid-column: 1/-1;">
                <label>Delivery Address</label>
                <p>{{ $order->address }}</p>
            </div>
            @endif
        </div>

        <div class="divider"></div>

        {{-- Items --}}
        <div style="margin-bottom: 4px;">
            @foreach($order->items as $item)
                <div class="item-row">
                    <div>
                        <div class="item-name">
                            {{ $item->product?->name ?? 'Item' }}
                        </div>
                        <div class="item-qty">Qty: {{ $item->quantity }}</div>
                    </div>
                    <div class="item-price">
                        ₹{{ number_format($item->price * $item->quantity, 2) }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="total-row">
            <span>Subtotal</span>
            <span>₹{{ number_format($order->total - $order->shipping, 2) }}</span>
        </div>
        <div class="total-row">
            <span>Shipping</span>
            <span>{{ $order->shipping == 0 ? 'Free 🎉' : '₹' . number_format($order->shipping, 2) }}</span>
        </div>
        <div class="total-row grand">
            <span>Total</span>
            <span>₹{{ number_format($order->total, 2) }}</span>
        </div>

        <div class="cta-wrap">
            <a href="{{ route('user.dashboard') }}" class="cta-btn">View My Orders →</a>
        </div>
    </div>

    <div class="footer">
        <div class="footer-logo">🪡 Soochikaari</div>
        <div class="footer-copy">
            © {{ date('Y') }} Soochikaari · Surat, Gujarat, India<br>
            Made with ♥ for Indian craft
        </div>
    </div>
</div>
</body>
</html>