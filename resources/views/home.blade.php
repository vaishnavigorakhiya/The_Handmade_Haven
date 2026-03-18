@extends('layouts.app')
@section('title', 'Home — The Art of Indian Embroidery')

@push('styles')
<style>
  .hero{min-height:85vh;display:flex;align-items:center;padding:60px 40px;position:relative;overflow:hidden;}
  .hero-bg{position:absolute;inset:0;background:linear-gradient(135deg,var(--bg1) 0%,var(--bg) 45%,var(--bg2) 100%);z-index:0;}
  .hero-dots{position:absolute;inset:0;z-index:0;background-image:radial-gradient(circle,var(--p1) 1px,transparent 1px),radial-gradient(circle,var(--p3) 1px,transparent 1px);background-size:40px 40px,40px 40px;background-position:0 0,20px 20px;opacity:0.08;}
  .hero-content{position:relative;z-index:1;max-width:580px;}
  .hero-tag{display:inline-block;background:var(--bg4);border:1.5px solid var(--border);color:var(--p2);border-radius:50px;padding:5px 18px;font-size:0.8rem;font-weight:800;margin-bottom:20px;letter-spacing:0.05em;text-transform:uppercase;}
  .hero h1{font-family:'Playfair Display',serif;font-size:clamp(2.6rem,5.5vw,4.5rem);line-height:1.05;font-weight:900;margin-bottom:18px;}
  .hero h1 em{font-style:normal;color:var(--p1);}
  .hero p{font-size:1.05rem;color:var(--mid);margin-bottom:32px;line-height:1.7;font-weight:600;}
  .hero-cta{display:flex;gap:14px;flex-wrap:wrap;}
  .hero-floaties{position:absolute;right:5%;top:50%;transform:translateY(-50%);z-index:1;display:grid;grid-template-columns:1fr 1fr;gap:14px;}
  .floaty{width:118px;height:118px;border-radius:20px;border:1.5px solid var(--border);display:flex;flex-direction:column;align-items:center;justify-content:center;font-size:2.6rem;box-shadow:0 4px 16px rgba(0,0,0,0.08);animation:floatUp 3s ease-in-out infinite;}
  .floaty:nth-child(1){background:var(--bg1);animation-delay:0s;}
  .floaty:nth-child(2){background:var(--bg2);animation-delay:0.5s;}
  .floaty:nth-child(3){background:var(--bg3);animation-delay:1s;}
  .floaty:nth-child(4){background:var(--bg4);animation-delay:1.5s;}
  .floaty-label{font-size:0.63rem;font-weight:800;margin-top:5px;text-transform:uppercase;letter-spacing:0.05em;color:var(--mid);}
  @keyframes floatUp{0%,100%{transform:translateY(0);}50%{transform:translateY(-10px);}}

  /* rangoli divider */
  .rangoli-section-border{height:5px;background:linear-gradient(90deg,var(--p1),var(--p2),var(--p3),var(--p4),var(--p5));opacity:0.4;margin:0;}

  .features-section{background:white;border-top:1px solid var(--border);border-bottom:1px solid var(--border);}
  .features-grid{max-width:1100px;margin:0 auto;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:24px;}
  .feature-card{text-align:center;padding:26px 18px;border:1.5px solid var(--border);border-radius:18px;box-shadow:0 2px 10px rgba(0,0,0,0.05);}
  .feature-icon{font-size:2.2rem;margin-bottom:10px;}
  .feature-card h3{font-family:'Playfair Display',serif;font-size:1.1rem;margin-bottom:7px;}
  .feature-card p{color:var(--mid);font-size:0.86rem;font-weight:600;line-height:1.5;}

  /* section divider title */
  .div-title{font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:900;text-align:center;margin:0 0 14px;}
  .div-title::before,.div-title::after{content:'✦';color:var(--p2);font-size:0.85rem;margin:0 10px;}

  @media(max-width:900px){.hero-floaties{display:none;}.hero{padding:60px 20px;}}
</style>
@endpush

@section('content')

{{-- HERO --}}
<div class="hero">
  <div class="hero-bg"></div>
  <div class="hero-dots"></div>
  <div class="hero-content">
    <div class="hero-tag">✨ Handcrafted with love from India</div>
    <h1>Every stitch tells an <em>Indian story</em></h1>
    <p>Discover authentic Indian hand embroidery — hoops, cushion covers, sofa covers & more. Each piece is a labour of love, made to last a lifetime.</p>
    <div class="hero-cta">
      <a class="btn-primary" href="{{ route('shop') }}">🌸 Shop Now</a>
      @guest
        <button class="btn-secondary" onclick="openLoginModal()">Join & Save 10%</button>
      @else
        <a class="btn-secondary" href="{{ route('user.dashboard') }}">👤 My Dashboard</a>
      @endguest
    </div>
  </div>
  <div class="hero-floaties">
    <div class="floaty">🪡<div class="floaty-label">Hoops</div></div>
    <div class="floaty">🛋️<div class="floaty-label">Sofa</div></div>
    <div class="floaty">🌸<div class="floaty-label">Cushions</div></div>
    <div class="floaty">✨<div class="floaty-label">Custom</div></div>
  </div>
</div>

<div class="rangoli-section-border"></div>

{{-- FEATURES --}}
<div class="section features-section">
  <div class="features-grid">
    <div class="feature-card" style="background:var(--bg1);">
      <div class="feature-icon">🤲</div>
      <h3>100% Handmade</h3>
      <p>Every item lovingly crafted by hand — no two pieces are ever exactly alike.</p>
    </div>
    <div class="feature-card" style="background:var(--bg2);">
      <div class="feature-icon">📦</div>
      <h3>Safe Delivery</h3>
      <p>Carefully packaged to arrive in perfect condition, right to your door.</p>
    </div>
    <div class="feature-card" style="background:var(--bg3);">
      <div class="feature-icon">🎨</div>
      <h3>Custom Orders</h3>
      <p>Want a unique design? We take custom orders with your vision in mind.</p>
    </div>
    <div class="feature-card" style="background:var(--bg4);">
      <div class="feature-icon">💛</div>
      <h3>Made with Love</h3>
      <p>Authentic Indian craft — every stitch carries care and passion.</p>
    </div>
  </div>
</div>

<div class="rangoli-section-border"></div>

{{-- FEATURED PRODUCTS --}}
<div class="section">
  <div class="section-header">
    <div class="section-tag" style="background:var(--bg5);color:var(--p5);">🌸 Featured</div>
    <div class="div-title">Our Bestsellers</div>
  </div>
  <div class="products-grid">
    @foreach($featured as $product)
      @include('components.product-card', ['product' => $product])
    @endforeach
  </div>
  <div style="text-align:center;margin-top:44px;">
    <a class="btn-primary" href="{{ route('shop') }}">View All Products →</a>
  </div>
</div>

@endsection
