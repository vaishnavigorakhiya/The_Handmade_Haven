@extends('layouts.app')
@section('title', 'Home — Handmade Embroidery')

@push('styles')
<style>
  .hero { min-height: 85vh; display: flex; align-items: center; padding: 60px 40px; position: relative; overflow: hidden; }
  .hero-bg { position: absolute; inset: 0; background: linear-gradient(135deg, #FFE8D6 0%, #FFF0F5 40%, #E8F8F5 100%); z-index: 0; }
  .hero-dots { position: absolute; inset: 0; z-index: 0; background-image: radial-gradient(circle, var(--coral) 1.5px, transparent 1.5px), radial-gradient(circle, var(--teal) 1.5px, transparent 1.5px); background-size: 40px 40px, 40px 40px; background-position: 0 0, 20px 20px; opacity: 0.15; }
  .hero-content { position: relative; z-index: 1; max-width: 600px; }
  .hero-tag { display: inline-block; background: var(--gold); border: 2.5px solid var(--dark); border-radius: 50px; padding: 6px 20px; font-size: 0.85rem; font-weight: 800; margin-bottom: 24px; box-shadow: 3px 3px 0 var(--dark); letter-spacing: 0.05em; text-transform: uppercase; }
  .hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(3rem, 6vw, 5rem); line-height: 1.05; font-weight: 900; margin-bottom: 20px; }
  .hero h1 em { font-style: normal; color: var(--coral); position: relative; }
  .hero h1 em::after { content: ''; position: absolute; bottom: 4px; left: 0; right: 0; height: 8px; background: var(--gold); z-index: -1; border-radius: 4px; }
  .hero p { font-size: 1.15rem; color: var(--mid); margin-bottom: 36px; line-height: 1.7; font-weight: 600; }
  .hero-cta { display: flex; gap: 16px; flex-wrap: wrap; }
  .hero-floaties { position: absolute; right: 5%; top: 50%; transform: translateY(-50%); z-index: 1; display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
  .floaty { width: 130px; height: 130px; border-radius: 24px; border: 3px solid var(--dark); display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 3rem; box-shadow: 5px 5px 0 var(--dark); animation: floatUp 3s ease-in-out infinite; background: white; }
  .floaty:nth-child(1) { background: #FFE8D6; animation-delay: 0s; }
  .floaty:nth-child(2) { background: #E8F5FF; animation-delay: 0.5s; }
  .floaty:nth-child(3) { background: #F0FFE8; animation-delay: 1s; }
  .floaty:nth-child(4) { background: #FFE8F5; animation-delay: 1.5s; }
  .floaty-label { font-size: 0.65rem; font-weight: 800; margin-top: 6px; text-transform: uppercase; letter-spacing: 0.05em; }
  @keyframes floatUp { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

  .features-section { background: white; border-top: 3px solid var(--dark); border-bottom: 3px solid var(--dark); }
  .features-grid { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 28px; }
  .feature-card { text-align: center; padding: 28px; border: 3px solid var(--dark); border-radius: 20px; box-shadow: 5px 5px 0 var(--dark); }
  .feature-icon { font-size: 2.5rem; margin-bottom: 12px; }
  .feature-card h3 { font-family: 'Playfair Display', serif; font-size: 1.2rem; margin-bottom: 8px; }
  .feature-card p { color: var(--mid); font-size: 0.9rem; font-weight: 600; line-height: 1.5; }

  @media (max-width: 900px) { .hero-floaties { display: none; } .hero { padding: 60px 20px; } }
</style>
@endpush

@section('content')

{{-- HERO --}}
<div class="hero">
  <div class="hero-bg"></div>
  <div class="hero-dots"></div>
  <div class="hero-content">
    <div class="hero-tag">✨ Handcrafted with love</div>
    <h1>Every stitch tells a <em>story</em></h1>
    <p>Discover one-of-a-kind hand embroidery — hoops, pillowcases, sofa covers & more. Each piece is made by hand, with love and patience.</p>
    <div class="hero-cta">
      <a class="btn-primary" href="{{ route('shop') }}">🌸 Shop Now</a>
      @guest
        <button class="btn-secondary" onclick="openLoginModal()">Join & Get 10% Off</button>
      @else
        <a class="btn-secondary" href="{{ route('user.dashboard') }}">👤 My Dashboard</a>
      @endguest
    </div>
  </div>
  <div class="hero-floaties">
    <div class="floaty">🪡<div class="floaty-label">Hoops</div></div>
    <div class="floaty">🛋️<div class="floaty-label">Sofa</div></div>
    <div class="floaty">🌸<div class="floaty-label">Pillows</div></div>
    <div class="floaty">✨<div class="floaty-label">Custom</div></div>
  </div>
</div>

{{-- FEATURES --}}
<div class="section features-section">
  <div class="features-grid">
    <div class="feature-card" style="background: #FFE8D6;">
      <div class="feature-icon">🤲</div>
      <h3>100% Handmade</h3>
      <p>Every item is lovingly crafted by hand, no two pieces are exactly alike.</p>
    </div>
    <div class="feature-card" style="background: #E8F8F5;">
      <div class="feature-icon">📦</div>
      <h3>Safe Delivery</h3>
      <p>Carefully packaged to arrive in perfect condition, right to your door.</p>
    </div>
    <div class="feature-card" style="background: #F5E8FF;">
      <div class="feature-icon">🎨</div>
      <h3>Custom Orders</h3>
      <p>Want a unique design? We take custom orders with your vision in mind.</p>
    </div>
    <div class="feature-card" style="background: #FFE8F0;">
      <div class="feature-icon">💛</div>
      <h3>Made with Love</h3>
      <p>Every stitch carries care and passion from our hands to your home.</p>
    </div>
  </div>
</div>

{{-- FEATURED PRODUCTS --}}
<div class="section">
  <div class="section-header">
    <div class="section-tag" style="background: var(--rose);">🌷 Featured</div>
    <h2>Our Bestsellers</h2>
  </div>
  <div class="products-grid">
    @foreach($featured as $product)
      @include('components.product-card', ['product' => $product])
    @endforeach
  </div>
  <div style="text-align:center; margin-top: 48px;">
    <a class="btn-primary" href="{{ route('shop') }}">View All Products →</a>
  </div>
</div>

@endsection
