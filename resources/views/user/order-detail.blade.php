@extends('layouts.app')
@section('title', 'Order #' . $order->id . ' — Soochikaari')

@push('styles')
<style>
/* ── Layout ── */
.od-wrap   { max-width: 780px; margin: 0 auto; }
.od-card   { background: white; border: 2.5px solid var(--dark);
             border-radius: 20px; padding: 28px;
             box-shadow: 5px 5px 0 var(--dark); margin-bottom: 22px; }
.od-title  { font-family: 'Playfair Display', serif; font-size: 1.15rem;
             font-weight: 800; margin-bottom: 20px;
             display: flex; align-items: center; gap: 8px; }

/* ── Timeline ── */
.timeline        { display: flex; align-items: flex-start;
                   gap: 0; position: relative; }
.timeline-step   { flex: 1; display: flex; flex-direction: column;
                   align-items: center; position: relative; }
/* horizontal line between steps */
.timeline-step:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 19px; left: 50%;
    width: 100%; height: 3px;
    background: var(--cream);
    z-index: 0;
}
.timeline-step.done:not(:last-child)::after { background: var(--p3); }

.timeline-dot    { width: 40px; height: 40px; border-radius: 50%;
                   border: 3px solid var(--dark); background: var(--cream);
                   display: flex; align-items: center; justify-content: center;
                   font-size: 1.1rem; position: relative; z-index: 1;
                   box-shadow: 3px 3px 0 var(--dark);
                   transition: all 0.2s; }
.timeline-step.done  .timeline-dot { background: var(--p3); border-color: var(--p3); box-shadow: 3px 3px 0 var(--dark); }
.timeline-step.active .timeline-dot { background: var(--p1); border-color: var(--p1); box-shadow: 3px 3px 0 var(--dark); }
.timeline-label  { font-size: 0.72rem; font-weight: 800; text-align: center;
                   margin-top: 10px; color: var(--mid); text-transform: uppercase;
                   letter-spacing: 0.04em; }
.timeline-step.done   .timeline-label  { color: var(--p3); }
.timeline-step.active .timeline-label  { color: var(--p1); }
.timeline-time   { font-size: 0.65rem; font-weight: 600; color: var(--mid);
                   text-align: center; margin-top: 3px; }

/* ── Items ── */
.od-item         { display: flex; align-items: center; gap: 16px;
                   padding: 14px 0; border-bottom: 2px solid var(--cream); }
.od-item:last-child { border-bottom: none; }
.od-item-thumb   { width: 58px; height: 58px; border-radius: 12px;
                   border: 2px solid var(--dark);
                   display: flex; align-items: center; justify-content: center;
                   font-size: 1.5rem; flex-shrink: 0; overflow: hidden; }
.od-item-thumb img { width: 100%; height: 100%; object-fit: cover; }
.od-item-name    { font-weight: 800; font-size: 0.95rem; }
.od-item-qty     { font-size: 0.78rem; color: var(--mid); font-weight: 600; margin-top: 2px; }
.od-item-price   { margin-left: auto; font-weight: 800; color: var(--p1); font-size: 1rem; white-space: nowrap; }

/* ── Totals ── */
.od-row          { display: flex; justify-content: space-between;
                   padding: 8px 0; font-weight: 700; font-size: 0.92rem; }
.od-row.grand    { border-top: 2.5px solid var(--dark); margin-top: 8px;
                   padding-top: 14px; font-family: 'Playfair Display', serif;
                   font-size: 1.2rem; }
.od-row.grand span:last-child { color: var(--p1); }

/* ── Meta grid ── */
.od-meta         { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.od-meta-item label { font-size: 0.68rem; font-weight: 800; text-transform: uppercase;
                       letter-spacing: 0.07em; color: var(--mid); display: block; margin-bottom: 3px; }
.od-meta-item p  { font-weight: 700; font-size: 0.9rem; }
.od-meta-item.full { grid-column: 1 / -1; }

/* ── Status pill ── */
.status-pill     { display: inline-block; padding: 4px 14px; border-radius: 50px;
                   font-size: 0.75rem; font-weight: 800;
                   border: 2px solid var(--dark); }
.pill-placed     { background: var(--bg4); }
.pill-processing { background: #FFE8D6; }
.pill-shipped    { background: var(--bg2); }
.pill-delivered  { background: #B2D8D0; }
.pill-completed  { background: #B2D8D0; }

@media(max-width: 600px) {
    .od-meta { grid-template-columns: 1fr; }
    .od-meta-item.full { grid-column: 1; }
    .timeline-label { font-size: 0.6rem; }
}
</style>
@endpush

@section('content')
<div class="section">
    <a class="back-btn" href="{{ route('user.dashboard') }}">← Back to Dashboard</a>

    <div class="section-header" style="margin-bottom: 32px;">
        <div class="section-tag" style="background: var(--bg2);">📦 Order Tracking</div>
        <h2>Order #{{ $order->id }}</h2>
    </div>

    <div class="od-wrap">

        {{-- ── TIMELINE ── --}}
        <div class="od-card">
            <div class="od-title">🚚 Order Status</div>

            <div class="timeline">
                @php
                    $statuses    = \App\Models\Order::allStatuses();
                    $currentIdx  = $order->statusIndex();
                    $statusKeys  = array_keys($statuses);
                @endphp

                @foreach($statuses as $key => $info)
                    @php
                        $stepIdx   = array_search($key, $statusKeys);
                        $isDone    = $stepIdx < $currentIdx;
                        $isActive  = $stepIdx === $currentIdx;
                        $timestamp = $order->statusTimestamp($key);
                        $classes   = $isDone ? 'done' : ($isActive ? 'active' : '');
                    @endphp

                    <div class="timeline-step {{ $classes }}">
                        <div class="timeline-dot">
                            @if($isDone) ✓
                            @else {{ $info['icon'] }}
                            @endif
                        </div>
                        <div class="timeline-label">{{ $info['label'] }}</div>
                        <div class="timeline-time">
                            @if($timestamp)
                                {{ \Carbon\Carbon::parse($timestamp)->format('d M, h:i A') }}
                            @elseif($isActive)
                                In Progress
                            @else
                                Pending
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ── ORDER META ── --}}
        <div class="od-card">
            <div class="od-title">📋 Order Details</div>

            <div class="od-meta">
                <div class="od-meta-item">
                    <label>Order Number</label>
                    <p>#{{ $order->id }}</p>
                </div>
                <div class="od-meta-item">
                    <label>Status</label>
                    <p>
                        <span class="status-pill pill-{{ $order->status }}">
                            {{ $order->statusLabel() }}
                        </span>
                    </p>
                </div>
                <div class="od-meta-item">
                    <label>Order Date</label>
                    <p>{{ $order->created_at->format('d M Y, h:i A') }}</p>
                </div>
                <div class="od-meta-item">
                    <label>Payment</label>
                    <p>💵 Cash on Delivery</p>
                </div>
                <div class="od-meta-item">
                    <label>Delivered To</label>
                    <p>{{ $order->full_name ?? Auth::user()->name }}</p>
                </div>
                <div class="od-meta-item">
                    <label>Phone</label>
                    <p>{{ $order->phone ?? '—' }}</p>
                </div>
                @if($order->address)
                    <div class="od-meta-item full">
                        <label>Delivery Address</label>
                        <p>{{ $order->address }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── ITEMS ── --}}
        <div class="od-card">
            <div class="od-title">🧵 Items Ordered</div>

            @foreach($order->items as $item)
                <div class="od-item">
                    <div class="od-item-thumb"
                         style="background: {{ $item->product?->color ?? '#FFE8D6' }}">
                        @if($item->product?->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                 alt="{{ $item->product->name }}"
                                 onerror="this.style.display='none'" />
                        @else
                            {{ $item->product?->emoji ?? '🧵' }}
                        @endif
                    </div>
                    <div style="flex: 1;">
                        <div class="od-item-name">
                            {{ $item->product?->name ?? 'Product no longer available' }}
                        </div>
                        <div class="od-item-qty">Qty: {{ $item->quantity }}</div>
                    </div>
                    <div class="od-item-price">
                        ₹{{ number_format($item->price * $item->quantity, 2) }}
                    </div>
                </div>
            @endforeach

            <div style="margin-top: 16px; padding-top: 4px;">
                <div class="od-row">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($order->total - $order->shipping, 2) }}</span>
                </div>
                <div class="od-row">
                    <span>Shipping</span>
                    <span>
                        {{ $order->shipping == 0
                            ? '🎉 Free'
                            : '₹' . number_format($order->shipping, 2) }}
                    </span>
                </div>
                <div class="od-row grand">
                    <span>Total Paid</span>
                    <span>₹{{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- ── ACTIONS ── --}}
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('shop') }}" class="btn-primary">🌸 Shop Again</a>
            <a href="{{ route('user.dashboard') }}" class="btn-secondary">
                ← My Dashboard
            </a>
        </div>

    </div>
</div>
@endsection














{{-- @extends('layouts.app')
@section('title', 'Order #' . $order->id . ' — Soochikaari')

@push('styles')
<style>
.order-detail-wrap { max-width: 760px; margin: 0 auto; }
.od-card { background: white; border: 2.5px solid var(--dark); border-radius: 20px;
           padding: 28px; box-shadow: 5px 5px 0 var(--dark); margin-bottom: 20px; }
.od-title { font-family: 'Playfair Display', serif; font-size: 1.2rem;
            font-weight: 800; margin-bottom: 18px; display: flex;
            align-items: center; gap: 10px; }
.od-item { display: flex; align-items: center; gap: 16px;
           padding: 14px 0; border-bottom: 2px solid var(--cream); }
.od-item:last-child { border-bottom: none; padding-bottom: 0; }
.od-item-img { width: 56px; height: 56px; border-radius: 12px;
               border: 2px solid var(--dark); display: flex;
               align-items: center; justify-content: center;
               font-size: 1.5rem; flex-shrink: 0; overflow: hidden; }
.od-item-img img { width: 100%; height: 100%; object-fit: cover; }
.od-item-name { font-weight: 800; font-size: 0.95rem; }
.od-item-qty { font-size: 0.8rem; color: var(--mid); font-weight: 600; margin-top: 2px; }
.od-item-price { margin-left: auto; font-weight: 800;
                 color: var(--p1); font-size: 1rem; }
.od-row { display: flex; justify-content: space-between;
          padding: 8px 0; font-weight: 700; font-size: 0.92rem; }
.od-row.total { border-top: 2.5px solid var(--dark); margin-top: 8px;
                padding-top: 14px; font-family: 'Playfair Display', serif;
                font-size: 1.2rem; }
.od-row.total span:last-child { color: var(--p1); }
.status-badge { display: inline-block; padding: 5px 16px; border-radius: 50px;
                font-size: 0.78rem; font-weight: 800;
                border: 2px solid var(--dark); }
.status-completed { background: #B2D8D0; }
.status-pending { background: var(--gold); }
.od-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.od-meta-item label { font-size: 0.7rem; font-weight: 800; text-transform: uppercase;
                      letter-spacing: 0.07em; color: var(--mid); display: block;
                      margin-bottom: 3px; }
.od-meta-item p { font-weight: 700; font-size: 0.9rem; color: var(--dark); }
</style>
@endpush

@section('content') --}}
{{-- <div class="section">
    <a class="back-btn" href="{{ route('user.dashboard') }}">← Back to Dashboard</a>

    <div class="section-header" style="margin-bottom: 32px;">
        <div class="section-tag" style="background: var(--bg2);">📦 Order Details</div>
        <h2>Order #{{ $order->id }}</h2>
    </div>

    <div class="order-detail-wrap"> --}}

        {{-- Status & Date --}}
        {{-- <div class="od-card">
            <div class="od-title">📋 Order Summary</div>
            <div class="od-meta">
                <div class="od-meta-item">
                    <label>Order Date</label>
                    <p>{{ $order->created_at->format('d M Y, h:i A') }}</p>
                </div>
                <div class="od-meta-item">
                    <label>Status</label>
                    <p>
                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                </div>
                <div class="od-meta-item">
                    <label>Delivered To</label>
                    <p>{{ $order->full_name ?? Auth::user()->name }}</p>
                </div>
                <div class="od-meta-item">
                    <label>Phone</label>
                    <p>{{ $order->phone ?? '—' }}</p>
                </div>
                @if($order->address)
                <div class="od-meta-item" style="grid-column: 1 / -1;">
                    <label>Delivery Address</label>
                    <p>{{ $order->address }}</p>
                </div>
                @endif
            </div>
        </div> --}}

        {{-- Items --}}
        {{-- <div class="od-card">
            <div class="od-title">🧵 Items Ordered</div>
            @foreach($order->items as $item)
                <div class="od-item">
                    <div class="od-item-img"
                         style="background: {{ $item->product?->color ?? '#FFE8D6' }}">
                        @if($item->product?->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                 alt="{{ $item->product->name }}" />
                        @else
                            {{ $item->product?->emoji ?? '🧵' }}
                        @endif
                    </div>
                    <div>
                        <div class="od-item-name">
                            {{ $item->product?->name ?? 'Product no longer available' }}
                        </div>
                        <div class="od-item-qty">Qty: {{ $item->quantity }}</div>
                    </div>
                    <div class="od-item-price">
                        ₹{{ number_format($item->price * $item->quantity, 2) }}
                    </div>
                </div>
            @endforeach

            <div style="margin-top: 16px;">
                <div class="od-row">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($order->total - $order->shipping, 2) }}</span>
                </div>
                <div class="od-row">
                    <span>Shipping</span>
                    <span>{{ $order->shipping == 0 ? '🎉 Free' : '₹' . number_format($order->shipping, 2) }}</span>
                </div>
                <div class="od-row total">
                    <span>Total Paid</span>
                    <span>₹{{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div> --}}

        {{-- Actions --}}
        {{-- <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('shop') }}" class="btn-primary">🌸 Shop Again</a>
            <a href="{{ route('user.dashboard') }}" class="btn-secondary">← My Dashboard</a>
        </div>
    </div>
</div> --}}
{{-- @endsection --}}