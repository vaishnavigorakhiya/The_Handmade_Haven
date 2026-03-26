<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Soochikaari — @yield('title', 'The Art of Indian Embroidery')</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
  :root {
    --p1:#D4956A; --p2:#C9A96E; --p3:#6FA89A; --p4:#8B7BB5; --p5:#C49BA0;
    --bg:#FAF7F4; --bg1:#FBF3EE; --bg2:#EEF6F5; --bg3:#F3F1F9; --bg4:#FBF7EE; --bg5:#F9F1F2;
    --card:#FFFFFF; --dark:#3A3A3A; --mid:#9A9A9A; --border:#E2D9D0;
    /* legacy aliases */
    --cream:#FAF7F4; --coral:#D4956A; --gold:#C9A96E; --teal:#6FA89A;
    --lavender:#8B7BB5; --rose:#C49BA0; --green:#B2D8D0; --white:#FFFFFF;
  }
  *{margin:0;padding:0;box-sizing:border-box;}
  body{font-family:'Nunito',sans-serif;background:var(--bg);color:var(--dark);overflow-x:hidden;}

  /* NAV */
  nav{position:sticky;top:0;z-index:100;background:var(--white);border-bottom:2px solid var(--border);display:flex;align-items:center;justify-content:space-between;padding:0 40px;height:70px;box-shadow:0 2px 12px rgba(0,0,0,0.06);}
  .nav-logo{font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:900;color:var(--dark);text-decoration:none;display:flex;align-items:center;gap:10px;white-space:nowrap;flex-shrink:0;}
  .nav-logo-accent{color:var(--p1);}
  .nav-logo-tag{font-family:'Nunito',sans-serif;font-size:0.67rem;font-weight:700;color:var(--mid);letter-spacing:0.04em;display:block;margin-top:-3px;}
  .nav-links{display:flex;gap:7px;align-items:center;}
  .nav-btn{padding:7px 16px;border:1.5px solid var(--border);border-radius:50px;background:transparent;font-family:'Nunito',sans-serif;font-weight:700;font-size:0.85rem;cursor:pointer;transition:all 0.2s;color:var(--dark);text-decoration:none;display:inline-flex;align-items:center;gap:5px;white-space:nowrap;}
  .nav-btn:hover,.nav-btn.active{background:var(--dark);color:var(--white);border-color:var(--dark);}
  .nav-btn.cart-btn{background:var(--p1);border-color:var(--p1);color:white;position:relative;}
  .nav-btn.cart-btn:hover{background:#c0834f;border-color:#c0834f;}
  .nav-btn.login-btn{background:var(--p3);border-color:var(--p3);color:white;}
  .nav-btn.login-btn:hover{background:#5a9489;}
  .nav-btn.admin-btn{background:var(--bg3);border-color:var(--p4);color:var(--dark);}
  .nav-btn.admin-btn:hover{background:var(--dark);color:white;}
  .cart-badge{background:var(--dark);color:white;border-radius:50%;width:18px;height:18px;font-size:0.65rem;display:inline-flex;align-items:center;justify-content:center;font-weight:800;flex-shrink:0;}
  .nav-hamburger{display:none;flex-direction:column;justify-content:space-between;width:26px;height:18px;cursor:pointer;background:none;border:none;padding:0;flex-shrink:0;}
  .nav-hamburger span{display:block;width:100%;height:2.5px;background:var(--dark);border-radius:2px;transition:all 0.3s;}
  .nav-hamburger.open span:nth-child(1){transform:translateY(7.75px) rotate(45deg);}
  .nav-hamburger.open span:nth-child(2){opacity:0;}
  .nav-hamburger.open span:nth-child(3){transform:translateY(-7.75px) rotate(-45deg);}
  .nav-drawer{display:none;position:fixed;top:70px;left:0;right:0;background:var(--white);border-bottom:2px solid var(--border);box-shadow:0 8px 20px rgba(0,0,0,0.08);flex-direction:column;gap:8px;padding:16px 20px 20px;z-index:99;transform:translateY(-10px);opacity:0;transition:all 0.25s ease;}
  .nav-drawer.open{display:flex;transform:translateY(0);opacity:1;}
  .nav-drawer .nav-btn{width:100%;justify-content:center;padding:12px 18px;font-size:1rem;}
  @media(max-width:768px){nav{padding:0 16px;}.nav-links{display:none;}.nav-hamburger{display:flex;}.nav-logo{font-size:1.2rem;}}
  @media(min-width:769px){.nav-drawer{display:none !important;}}

  /* RANGOLI STRIP */
  .rangoli-strip{height:5px;background:linear-gradient(90deg,var(--p1),var(--p2),var(--p3),var(--p4),var(--p5));opacity:0.6;}

  /* ALERTS */
  .alert{padding:13px 24px;border:1.5px solid var(--border);border-radius:12px;margin:16px 40px;font-weight:700;box-shadow:0 2px 8px rgba(0,0,0,0.06);}
  .alert-success{background:var(--bg2);color:#2D6B5E;border-color:var(--p3);}
  .alert-error{background:var(--bg5);color:#7A3A40;border-color:var(--p5);}
  .alert-warning{background:var(--bg4);color:#7A5A1A;border-color:var(--p2);}
  @media(max-width:768px){.alert{margin:12px 16px;}}

  /* BUTTONS */
  .btn-primary{padding:14px 32px;background:var(--p1);color:white;border:1.5px solid transparent;border-radius:50px;font-family:'Nunito',sans-serif;font-size:0.95rem;font-weight:800;cursor:pointer;box-shadow:0 3px 10px rgba(212,149,106,0.35);transition:all 0.2s;text-decoration:none;display:inline-flex;align-items:center;gap:8px;}
  .btn-primary:hover{background:#c0834f;box-shadow:0 5px 16px rgba(212,149,106,0.45);color:white;transform:translateY(-1px);}
  .btn-secondary{padding:14px 32px;background:var(--white);color:var(--dark);border:1.5px solid var(--border);border-radius:50px;font-family:'Nunito',sans-serif;font-size:0.95rem;font-weight:800;cursor:pointer;box-shadow:0 2px 8px rgba(0,0,0,0.06);transition:all 0.2s;text-decoration:none;display:inline-flex;align-items:center;gap:8px;}
  .btn-secondary:hover{background:var(--dark);color:white;border-color:var(--dark);transform:translateY(-1px);}

  /* SECTION */
  .section{padding:80px 40px;}
  .section-header{text-align:center;margin-bottom:56px;}
  .section-tag{display:inline-block;padding:5px 16px;border-radius:50px;font-size:0.75rem;font-weight:800;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:14px;border:1.5px solid var(--border);}
  .section-header h2{font-family:'Playfair Display',serif;font-size:clamp(1.8rem,4vw,2.8rem);font-weight:900;line-height:1.1;}

  /* PRODUCT CARD */
  .products-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(270px,1fr));gap:24px;max-width:1200px;margin:0 auto;}
  .product-card{background:white;border:1.5px solid var(--border);border-radius:18px;overflow:hidden;box-shadow:0 3px 12px rgba(0,0,0,0.06);transition:all 0.2s;}
  .product-card:hover{transform:translateY(-4px);box-shadow:0 8px 24px rgba(0,0,0,0.1);}
  .product-img{height:220px;display:flex;align-items:center;justify-content:center;font-size:5rem;position:relative;overflow:hidden;}
  .product-badge{position:absolute;top:12px;right:12px;background:var(--p5);color:white;border-radius:50px;padding:3px 11px;font-size:0.7rem;font-weight:800;}
  .product-info{padding:18px;}
  .product-category{font-size:0.72rem;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:var(--p3);margin-bottom:5px;}
  .product-name{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;margin-bottom:7px;line-height:1.3;}
  .product-desc{font-size:0.83rem;color:var(--mid);margin-bottom:14px;line-height:1.5;font-weight:600;}
  .product-footer{display:flex;align-items:center;justify-content:space-between;}
  .product-price{font-size:1.3rem;font-weight:800;color:var(--p1);}
  .add-to-cart-btn{padding:9px 18px;background:var(--dark);color:white;border:none;border-radius:50px;font-family:'Nunito',sans-serif;font-weight:800;font-size:0.82rem;cursor:pointer;transition:all 0.15s;box-shadow:0 2px 6px rgba(0,0,0,0.15);text-decoration:none;}
  .add-to-cart-btn:hover{background:var(--p1);color:white;}

  /* BACK BTN */
  .back-btn{display:inline-flex;align-items:center;gap:8px;padding:9px 18px;background:white;border:1.5px solid var(--border);border-radius:50px;font-family:'Nunito',sans-serif;font-weight:800;font-size:0.88rem;cursor:pointer;margin-bottom:32px;transition:all 0.15s;text-decoration:none;color:var(--dark);box-shadow:0 2px 6px rgba(0,0,0,0.06);}
  .back-btn:hover{background:var(--dark);color:white;border-color:var(--dark);}

  /* FOOTER */
  .footer-topline{height:4px;background:linear-gradient(90deg,var(--p1),var(--p2),var(--p3),var(--p4),var(--p5));opacity:0.7;}
  footer{background:linear-gradient(135deg,#2A1A3E 0%,#1E1430 60%,#2A1A3E 100%);color:#fff;padding:48px 40px 0;}
  .footer-grid{display:grid;grid-template-columns:1.3fr 1.4fr 1fr 1.3fr;gap:36px;margin-bottom:40px;}
  .footer-col-title{display:flex;align-items:center;gap:9px;font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:#fff;margin-bottom:18px;}
  .footer-col-icon{width:26px;height:26px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:0.8rem;flex-shrink:0;}
  .fci-about{background:rgba(212,149,106,0.2);border:1px solid rgba(212,149,106,0.35);}
  .fci-news{background:rgba(111,168,154,0.2);border:1px solid rgba(111,168,154,0.35);}
  .fci-info{background:rgba(139,123,181,0.2);border:1px solid rgba(139,123,181,0.35);}
  .fci-insta{background:rgba(196,155,160,0.2);border:1px solid rgba(196,155,160,0.35);}
  .footer-about-item{display:flex;align-items:flex-start;gap:9px;margin-bottom:11px;font-size:0.78rem;color:rgba(255,255,255,0.6);line-height:1.5;}
  .footer-about-icon{color:var(--p1);font-size:0.85rem;margin-top:1px;flex-shrink:0;}
  .footer-about-link{color:var(--p1);text-decoration:none;font-weight:700;}
  .footer-newsletter{display:flex;margin-top:16px;}
  .footer-newsletter input{flex:1;padding:9px 13px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-right:none;border-radius:8px 0 0 8px;color:#fff;font-family:'Nunito',sans-serif;font-size:0.76rem;outline:none;}
  .footer-newsletter input::placeholder{color:rgba(255,255,255,0.3);}
  .footer-newsletter button{padding:9px 13px;background:var(--p1);border:none;border-radius:0 8px 8px 0;cursor:pointer;color:#fff;font-size:0.82rem;}
  .footer-news-item{display:flex;gap:11px;margin-bottom:14px;padding-bottom:14px;border-bottom:1px solid rgba(255,255,255,0.07);}
  .footer-news-item:last-child{border-bottom:none;margin-bottom:0;padding-bottom:0;}
  .footer-news-thumb{width:58px;height:52px;border-radius:8px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:1.4rem;}
  .footer-news-title{font-size:0.76rem;font-weight:700;color:rgba(255,255,255,0.82);line-height:1.4;margin-bottom:4px;}
  .footer-news-meta{font-size:0.66rem;color:rgba(255,255,255,0.32);}
  .footer-info-links{display:flex;flex-direction:column;gap:9px;}
  .footer-info-link{font-size:0.78rem;color:rgba(255,255,255,0.58);text-decoration:none;display:flex;align-items:center;gap:6px;transition:color 0.2s;}
  .footer-info-link::before{content:'›';color:var(--p3);font-size:1rem;font-weight:700;}
  .footer-info-link:hover{color:var(--p1);}
  .footer-insta-grid{display:grid;grid-template-columns:1fr 1fr;gap:6px;}
  .footer-insta-thumb{height:64px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;border:1px solid rgba(255,255,255,0.07);}
  .footer-bottom{border-top:1px solid rgba(255,255,255,0.08);padding:16px 0;display:flex;align-items:center;justify-content:space-between;}
  .footer-bottom-copy{font-size:0.73rem;color:rgba(255,255,255,0.32);}
  .footer-bottom-logo{font-family:'Playfair Display',serif;font-size:0.98rem;font-weight:900;color:var(--p1);}
  .footer-bottom-love{font-size:0.73rem;color:rgba(255,255,255,0.32);}
  .footer-bottom-love span{color:var(--p1);}
  @media(max-width:900px){footer{padding:36px 20px 0;}.footer-grid{grid-template-columns:1fr 1fr;gap:28px;}.section{padding:60px 20px;}}
  @media(max-width:560px){.footer-grid{grid-template-columns:1fr;}.footer-bottom{flex-direction:column;gap:6px;text-align:center;}}
  @media(max-width:600px){.btn-primary,.btn-secondary{padding:13px 22px;font-size:0.9rem;}}
</style>
@stack('styles')
</head>
<body>

<div class="rangoli-strip"></div>

<nav>
  <a class="nav-logo" href="{{ route('home') }}">
    <span class="nav-logo-accent">🪡</span>
    <div>Soochikaari<span class="nav-logo-tag">The Art of Indian Embroidery</span></div>
  </a>
  <div class="nav-links">
        {{-- Search Form --}}
    <form action="{{ route('search') }}" method="GET"
          style="display:flex; align-items:center; gap:0; margin: 0 8px;">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Search products…"
            style="padding: 7px 14px;
                  border: 1.5px solid var(--border);
                  border-right: none;
                  border-radius: 50px 0 0 50px;
                  font-family: 'Nunito', sans-serif;
                  font-size: 0.82rem;
                  font-weight: 600;
                  background: var(--bg);
                  outline: none;
                  width: 180px;
                  color: var(--dark);"
            onfocus="this.style.borderColor='var(--p1)'"
            onblur="this.style.borderColor='var(--border)'"
        />
        <button type="submit"
                style="padding: 7px 13px;
                      background: var(--p1);
                      color: white;
                      border: 1.5px solid var(--p1);
                      border-radius: 0 50px 50px 0;
                      font-size: 0.85rem;
                      cursor: pointer;
                      font-family: 'Nunito', sans-serif;
                      font-weight: 700;">
            🔍
        </button>
    </form>
    <a class="nav-btn {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
    <a class="nav-btn {{ request()->routeIs('shop') ? 'active' : '' }}" href="{{ route('shop') }}">Shop</a>
    <a class="nav-btn {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
    <a class="nav-btn {{ request()->routeIs('blog.*') || request()->routeIs('blog.index') ? 'active' : '' }}" href="{{ route('blog.index') }}">Blog</a>
    <a class="nav-btn {{ request()->routeIs('contact.index') ? 'active' : '' }}" href="{{ route('contact.index') }}">Contact</a>
    <a class="nav-btn cart-btn" href="{{ route('cart') }}">
      🛒 Cart
      @php $cartCount = collect(session('cart', []))->sum(); @endphp
      @if($cartCount > 0)<span class="cart-badge">{{ $cartCount }}</span>@endif
    </a>
    @auth
      @if(Auth::user()->isAdmin())
        <a class="nav-btn admin-btn {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">⚙ Admin</a>
        <a class="nav-btn {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">👥 Users</a>
        <a class="nav-btn {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">
          📬 Contacts
          @php
            try 
            {
              $newContacts = \App\Models\Contact::where('status', 'new')->count();
            } 
            catch (\Exception $e) 
            {
              $newContacts = 0;
            }            
          @endphp
          @if($newContacts > 0)
            <span class="cart-badge">{{ $newContacts }}</span>
          @endif
        </a>
      @else
        <a class="nav-btn {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">👤 My Account</a>
      @endif
      <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit" class="nav-btn">Sign Out</button>
      </form>
    @else
      <button class="nav-btn login-btn" onclick="openLoginModal()">🌸 Login / Join</button>
    @endauth
  </div>
  <button class="nav-hamburger" id="navHamburger" onclick="toggleMobileNav()" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>
</nav>

<div class="nav-drawer" id="navDrawer">
  <form action="{{ route('search') }}" method="GET"
      style="display:flex; gap:0; width:100%;">
    <input type="text" name="q" value="{{ request('q') }}"
           placeholder="Search products…"
           style="flex:1; padding:11px 16px; border:1.5px solid var(--border);
                  border-right:none; border-radius:50px 0 0 50px;
                  font-family:'Nunito',sans-serif; font-size:0.95rem;
                  font-weight:600; background:var(--bg); outline:none;" />
    <button type="submit"
            style="padding:11px 16px; background:var(--p1); color:white;
                   border:1.5px solid var(--p1); border-radius:0 50px 50px 0;
                   font-size:1rem; cursor:pointer;">🔍</button>
  </form>
  <a class="nav-btn {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" onclick="closeMobileNav()">🏠 Home</a>
  <a class="nav-btn {{ request()->routeIs('shop') ? 'active' : '' }}" href="{{ route('shop') }}" onclick="closeMobileNav()">🪡 Shop</a>
  <a class="nav-btn {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}" onclick="closeMobileNav()">📖 About</a>
  <a class="nav-btn {{ request()->routeIs('blog.*') || request()->routeIs('blog.index') ? 'active' : '' }}" href="{{ route('blog.index') }}" onclick="closeMobileNav()">📝 Blog</a>
  <a class="nav-btn {{ request()->routeIs('contact.index') ? 'active' : '' }}" href="{{ route('contact.index') }}" onclick="closeMobileNav()">📬 Contact</a>
  <a class="nav-btn cart-btn" href="{{ route('cart') }}" onclick="closeMobileNav()">
    🛒 Cart
    @php $cartCount = collect(session('cart', []))->sum(); @endphp
    @if($cartCount > 0)<span class="cart-badge">{{ $cartCount }}</span>@endif
  </a>
  @auth
    @if(Auth::user()->isAdmin())
      <a class="nav-btn admin-btn" href="{{ route('admin.dashboard') }}" onclick="closeMobileNav()">⚙ Admin Dashboard</a>
      <a class="nav-btn" href="{{ route('admin.users.index') }}" onclick="closeMobileNav()">👥 Users</a>
      <a class="nav-btn" href="{{ route('admin.contacts.index') }}" onclick="closeMobileNav()">
        📬 Contacts
        @php $newContacts = \App\Models\Contact::where('status','new')->count(); @endphp
        @if($newContacts > 0)
          <span class="cart-badge">{{ $newContacts }}</span>
        @endif
      </a>
    @else
      <a class="nav-btn {{ request()->routeIs('wishlist') ? 'active' : '' }}"
        href="{{ route('wishlist') }}">
          ❤️ Wishlist
          @php
              $wCount = Auth::user()->wishlists()->count();
          @endphp
          @if($wCount > 0)
              <span class="cart-badge">{{ $wCount }}</span>
          @endif
      </a>
      <a class="nav-btn {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"
        href="{{ route('user.dashboard') }}">👤 My Account</a>
    @endif
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="nav-btn" style="width:100%;justify-content:center;">Sign Out</button>
    </form>
  @else
    <button class="nav-btn login-btn" onclick="openLoginModal(); closeMobileNav();">🌸 Login / Join</button>
  @endauth
</div>

@if(session('success'))
  <div class="alert alert-success">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-error">❌ {{ session('error') }}</div>
@endif
@if(session('warning'))
  <div class="alert alert-warning">⚠️ {{ session('warning') }}</div>
@endif

@yield('content')

<div class="footer-topline"></div>
<footer>
  <div class="footer-grid">

    <div>
      <div class="footer-col-title"><div class="footer-col-icon fci-about">🪡</div>About</div>
      <div class="footer-about-item"><span class="footer-about-icon">📍</span><span>Surat, Gujarat, India — where every thread finds its home</span></div>
      <div class="footer-about-item"><span class="footer-about-icon">📞</span><span>Contact us through the form for order-specific help</span></div>
      <div class="footer-about-item"><span class="footer-about-icon">✉️</span><a class="footer-about-link" href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a></div>
      <div class="footer-newsletter">
        <input type="email" placeholder="Enter email address" />
        <button>➤</button>
      </div>
    </div>

    <div>
      <div class="footer-col-title"><div class="footer-col-icon fci-news">📰</div>Latest News</div>
      <div class="footer-news-item">
        <div class="footer-news-thumb" style="background:rgba(212,149,106,0.12);">🌸</div>
        <div>
          <div class="footer-news-title">New Phulkari collection drops this Diwali season</div>
          <div class="footer-news-meta">Oct 10, 2025 · Admin</div>
        </div>
      </div>
      <div class="footer-news-item">
        <div class="footer-news-thumb" style="background:rgba(111,168,154,0.12);">🧵</div>
        <div>
          <div class="footer-news-title">Custom wedding embroidery — how to place your order</div>
          <div class="footer-news-meta">Sep 28, 2025 · Admin</div>
        </div>
      </div>
    </div>

    <div>
      <div class="footer-col-title"><div class="footer-col-icon fci-info">ℹ️</div>Information</div>
      <div class="footer-info-links">
        <a class="footer-info-link" href="{{ route('about') }}">About Us</a>
        <a class="footer-info-link" href="{{ route('shop') }}">Shop</a>
        <a class="footer-info-link" href="{{ route('blog.index') }}">Blog</a>
        <a class="footer-info-link" href="{{ route('contact.index') }}">Contact</a>
        <a class="footer-info-link" href="#">Help & Support</a>
        <a class="footer-info-link" href="{{ route('cart') }}">Track My Order</a>
      </div>
    </div>

    <div>
      <div class="footer-col-title"><div class="footer-col-icon fci-insta">📸</div>Instagram</div>
      <div class="footer-insta-grid">
        <div class="footer-insta-thumb" style="background:rgba(212,149,106,0.12);">🌸</div>
        <div class="footer-insta-thumb" style="background:rgba(111,168,154,0.12);">🧵</div>
        <div class="footer-insta-thumb" style="background:rgba(139,123,181,0.12);">🪡</div>
        <div class="footer-insta-thumb" style="background:rgba(196,155,160,0.12);">🌺</div>
        <div class="footer-insta-thumb" style="background:rgba(201,181,110,0.12);">🦋</div>
        <div class="footer-insta-thumb" style="background:rgba(212,149,106,0.12);">✨</div>
      </div>
    </div>

  </div>
  <div class="footer-bottom">
    <div class="footer-bottom-copy">Copyright © 2025 Soochikaari · All rights reserved.</div>
    <div class="footer-bottom-logo">🪡 Soochikaari</div>
    <div class="footer-bottom-love">Made with <span>♥</span> for Indian craft</div>
  </div>
</footer>

@guest
  @include('auth.login')
@endguest

<script>
@if(session('open_login_modal'))
  document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() { if(typeof openLoginModal==='function') openLoginModal(); }, 100);
  });
@endif
function toggleMobileNav(){const d=document.getElementById('navDrawer'),b=document.getElementById('navHamburger');if(d.classList.contains('open')){d.classList.remove('open');b.classList.remove('open');}else{d.classList.add('open');b.classList.add('open');}}
function closeMobileNav(){document.getElementById('navDrawer').classList.remove('open');document.getElementById('navHamburger').classList.remove('open');}
document.addEventListener('click',function(e){const d=document.getElementById('navDrawer'),b=document.getElementById('navHamburger');if(!d||!b)return;if(!d.contains(e.target)&&!b.contains(e.target))closeMobileNav();});
</script>
@stack('scripts')
</body>
</html>
