@extends('layouts.app')
@section('title', 'My Dashboard — Stitch & Bloom')

@push('styles')
<style>
  .dash-page { max-width: 960px; margin: 0 auto; }
  .dash-hero { background: linear-gradient(135deg, #FFE8D6, #FFD6F0, #E8F8F5); border: 3px solid var(--dark); border-radius: 24px; padding: 36px; margin-bottom: 28px; box-shadow: 7px 7px 0 var(--dark); display: flex; align-items: center; gap: 24px; flex-wrap: wrap; }
  .dash-avatar { width: 72px; height: 72px; border-radius: 50%; background: white; border: 3px solid var(--dark); display: flex; align-items: center; justify-content: center; font-size: 2rem; box-shadow: 4px 4px 0 var(--dark); flex-shrink: 0; }
  .dash-greeting { flex: 1; }
  .dash-greeting-sub { font-size: 0.82rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--mid); margin-bottom: 4px; }
  .dash-greeting-name { font-family: 'Playfair Display', serif; font-size: 1.9rem; font-weight: 900; margin-bottom: 4px; }
  .dash-greeting-info { font-size: 0.88rem; font-weight: 700; color: var(--mid); }
  .dash-vip-badge { background: var(--gold); border: 2.5px solid var(--dark); border-radius: 50px; padding: 8px 20px; font-weight: 800; font-size: 0.88rem; box-shadow: 3px 3px 0 var(--dark); white-space: nowrap; }
  .dash-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 28px; }
  .dash-stat { background: white; border: 3px solid var(--dark); border-radius: 18px; padding: 22px; text-align: center; box-shadow: 5px 5px 0 var(--dark); }
  .dash-stat-icon { font-size: 1.8rem; margin-bottom: 8px; }
  .dash-stat-val { font-family: 'Playfair Display', serif; font-size: 1.7rem; font-weight: 900; color: var(--coral); }
  .dash-stat-label { font-size: 0.75rem; font-weight: 800; color: var(--mid); text-transform: uppercase; letter-spacing: 0.05em; margin-top: 3px; }
  .dash-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px; }
  .dash-card { background: white; border: 3px solid var(--dark); border-radius: 20px; padding: 24px; box-shadow: 5px 5px 0 var(--dark); }
  .dash-card-title { font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 800; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
  .coupon-box { background: linear-gradient(135deg, #FFE8D6, #FFD6F0); border: 2.5px dashed var(--dark); border-radius: 14px; padding: 18px; display: flex; align-items: center; gap: 14px; }
  .coupon-code-big { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: var(--coral); flex: 1; letter-spacing: 0.05em; }
  .copy-btn { padding: 8px 16px; background: var(--dark); color: white; border: none; border-radius: 50px; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 0.82rem; cursor: pointer; transition: all 0.15s; }
  .copy-btn:hover { background: var(--coral); }
  .profile-input { width: 100%; padding: 12px 14px; border: 2.5px solid var(--dark); border-radius: 12px; font-family: 'Nunito', sans-serif; font-size: 0.95rem; font-weight: 600; background: var(--cream); outline: none; margin-bottom: 12px; }
  .profile-input:focus { border-color: var(--coral); background: white; }
  .profile-save { padding: 10px 24px; background: var(--teal); color: var(--dark); border: 2.5px solid var(--dark); border-radius: 50px; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 0.88rem; cursor: pointer; box-shadow: 3px 3px 0 var(--dark); transition: all 0.15s; }
  .profile-save:hover { transform: translate(-1px,-1px); box-shadow: 5px 5px 0 var(--dark); }
  .orders-table { width: 100%; border-collapse: collapse; }
  .orders-table th { font-size: 0.78rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; color: var(--mid); padding: 0 0 10px; text-align: left; }
  .orders-table td { padding: 12px 0; border-top: 2px solid var(--cream); font-weight: 600; font-size: 0.9rem; vertical-align: top; }
  .order-status { padding: 3px 10px; border-radius: 50px; font-size: 0.75rem; font-weight: 800; border: 2px solid var(--dark); display: inline-block; }
  .status-completed { background: var(--green); }
  .status-pending { background: var(--gold); }
  .no-orders { text-align: center; padding: 28px 0; color: var(--mid); font-weight: 700; }
  .no-orders .emoji { font-size: 2.5rem; margin-bottom: 8px; }
  .dash-actions-row { display: flex; gap: 12px; flex-wrap: wrap; }
  .dash-action-link { flex: 1; min-width: 140px; padding: 14px; text-align: center; background: var(--coral); color: white; border: 2.5px solid var(--dark); border-radius: 50px; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 0.9rem; cursor: pointer; box-shadow: 4px 4px 0 var(--dark); transition: all 0.15s; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 6px; }
  .dash-action-link:hover { transform: translate(-2px,-2px); box-shadow: 6px 6px 0 var(--dark); color: white; }
  .dash-action-link.secondary { background: white; color: var(--dark); }
  .dash-action-link.secondary:hover { background: var(--dark); color: white; }
  .order-address { font-size: 0.78rem; color: var(--mid); margin-top: 3px; }
  @media(max-width:700px){ .dash-stats{grid-template-columns:1fr 1fr;} .dash-grid{grid-template-columns:1fr;} }
</style>
@endpush

@section('content')
<div class="section">
  <div class="dash-page">

    <div class="dash-hero">
      <div class="dash-avatar">🌸</div>
      <div class="dash-greeting">
        <div class="dash-greeting-sub">My Dashboard</div>
        <div class="dash-greeting-name">Hi, {{ $user->name ?? 'Welcome!' }} 👋</div>
        <div class="dash-greeting-info">
          {{ $user->phone ? '📱 +91 '.$user->phone : '' }}
          {{ $user->email ? '📧 '.$user->email : '' }}
          · Member since {{ $user->created_at->format('M Y') }}
        </div>
      </div>
      <div class="dash-vip-badge">✨ VIP Member</div>
    </div>

    <div class="dash-stats">
      <div class="dash-stat" style="background:#FFE8D6;">
        <div class="dash-stat-icon">🛒</div>
        <div class="dash-stat-val">{{ $orders->count() }}</div>
        <div class="dash-stat-label">Total Orders</div>
      </div>
      <div class="dash-stat" style="background:#E8F8F5;">
        <div class="dash-stat-icon">💰</div>
        <div class="dash-stat-val">${{ number_format($totalSpent, 2) }}</div>
        <div class="dash-stat-label">Total Spent</div>
      </div>
      <div class="dash-stat" style="background:#F5E8FF;">
        <div class="dash-stat-icon">🎁</div>
        <div class="dash-stat-val">10%</div>
        <div class="dash-stat-label">Welcome Offer</div>
      </div>
    </div>

    <div class="dash-grid">
      <div class="dash-card">
        <div class="dash-card-title">🎉 Your Welcome Coupon</div>
        <div class="coupon-box">
          <div>
            <div style="font-size:0.78rem;font-weight:800;color:var(--mid);margin-bottom:3px;">USE AT CHECKOUT</div>
            <div class="coupon-code-big">STITCH10</div>
          </div>
          <button class="copy-btn" onclick="copyCoupon()">Copy</button>
        </div>
        <div style="font-size:0.8rem;font-weight:700;color:var(--mid);margin-top:12px;">🏷 10% off your first order · Valid for 30 days</div>
      </div>

      <div class="dash-card">
        <div class="dash-card-title">👤 My Profile</div>
        <form method="POST" action="{{ route('user.profile.update') }}">
          @csrf
          <label style="font-size:0.8rem;font-weight:800;color:var(--mid);text-transform:uppercase;letter-spacing:0.06em;">Name</label>
          <input class="profile-input" name="name" value="{{ $user->name }}" placeholder="Your name" />
          <label style="font-size:0.8rem;font-weight:800;color:var(--mid);text-transform:uppercase;letter-spacing:0.06em;display:block;margin-bottom:6px;">{{ $user->phone ? 'Phone' : 'Email' }}</label>
          <input class="profile-input" value="{{ $user->phone ?? $user->email }}" disabled style="opacity:0.6;cursor:not-allowed;" />
          <button type="submit" class="profile-save">Save Changes</button>
        </form>
      </div>
    </div>

    <div class="dash-card" style="margin-bottom:24px;">
      <div class="dash-card-title">📦 My Orders</div>
      @if($orders->isEmpty())
        <div class="no-orders">
          <div class="emoji">🧺</div>
          <div>No orders yet!</div>
          <a href="{{ route('shop') }}" style="color:var(--coral);font-weight:800;">Start shopping →</a>
        </div>
      @else
        <table class="orders-table">
          <thead><tr>
            <th>Order #</th><th>Date</th><th>Delivered To</th><th>Amount</th><th>Status</th>
          </tr></thead>
          <tbody>
            @foreach($orders as $order)
              <tr>
                {{-- <td><strong>#{{ $order->id }}</strong></td> --}}
                <td>
                  <a href="{{ route('user.order.detail', $order->id) }}"
                    style="color: var(--p1); font-weight: 800; text-decoration: none;">
                      #{{ $order->id }} →
                  </a>
                </td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
                <td>
                  <div style="font-weight:700;">{{ $order->full_name ?? Auth::user()->name }}</div>
                  @if($order->address)
                    <div class="order-address">{{ \Illuminate\Support\Str::limit($order->address, 50) }}</div>                  
                  @endif
                </td>
                <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                <td><span class="order-status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>

    <div class="dash-actions-row">
      <a class="dash-action-link" href="{{ route('shop') }}">🌸 Browse Shop</a>
      <a class="dash-action-link" href="{{ route('cart') }}">🛒 My Cart</a>
      <form method="POST" action="{{ route('logout') }}" style="flex:1;min-width:140px;">
        @csrf
        <button type="submit" class="dash-action-link secondary" style="width:100%;">Sign Out</button>
      </form>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
function copyCoupon() {
  navigator.clipboard.writeText('STITCH10').then(() => {
    const btn = document.querySelector('.copy-btn');
    btn.textContent = '✓ Copied!'; btn.style.background = 'var(--teal)';
    setTimeout(() => { btn.textContent = 'Copy'; btn.style.background = ''; }, 2000);
  });
}
</script>
@endpush
