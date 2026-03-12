<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Stitch & Bloom — @yield('title', 'Handmade Embroidery')</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
  :root {
    --cream: #FFF8F0; --coral: #FF6B6B; --gold: #FFB347;
    --teal: #4ECDC4; --lavender: #C3B1E1; --rose: #FF8FAB;
    --green: #95D5B2; --dark: #2D2D2D; --mid: #6B6B6B; --white: #FFFFFF;
  }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Nunito', sans-serif; background: var(--cream); color: var(--dark); overflow-x: hidden; }
  body::before { content: ''; position: fixed; inset: 0; background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E"); pointer-events: none; z-index: 9999; }

  /* NAV */
  nav { position: sticky; top: 0; z-index: 100; background: var(--white); border-bottom: 3px solid var(--dark); display: flex; align-items: center; justify-content: space-between; padding: 0 40px; height: 70px; box-shadow: 0 4px 0 var(--dark); }
  .nav-logo { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 900; color: var(--dark); text-decoration: none; display: flex; align-items: center; gap: 10px; }
  .nav-logo span { color: var(--coral); }
  .nav-links { display: flex; gap: 8px; align-items: center; }
  .nav-btn { padding: 8px 18px; border: 2.5px solid var(--dark); border-radius: 50px; background: transparent; font-family: 'Nunito', sans-serif; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: all 0.2s; color: var(--dark); text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
  .nav-btn:hover, .nav-btn.active { background: var(--dark); color: var(--white); }
  .nav-btn.cart-btn { background: var(--coral); border-color: var(--coral); color: white; position: relative; }
  .nav-btn.cart-btn:hover { background: #e55a5a; border-color: #e55a5a; }
  .nav-btn.login-btn { background: var(--teal); border-color: var(--teal); color: white; }
  .nav-btn.login-btn:hover { background: #3ab8b0; }
  .cart-badge { background: var(--dark); color: white; border-radius: 50%; width: 20px; height: 20px; font-size: 0.7rem; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; }

  /* ALERTS */
  .alert { padding: 14px 24px; border: 3px solid var(--dark); border-radius: 12px; margin: 20px 40px; font-weight: 700; box-shadow: 4px 4px 0 var(--dark); }
  .alert-success { background: var(--green); }
  .alert-error { background: var(--rose); }

  /* BUTTONS */
  .btn-primary { padding: 16px 36px; background: var(--coral); color: white; border: 3px solid var(--dark); border-radius: 50px; font-family: 'Nunito', sans-serif; font-size: 1rem; font-weight: 800; cursor: pointer; box-shadow: 5px 5px 0 var(--dark); transition: all 0.15s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
  .btn-primary:hover { transform: translate(-2px, -2px); box-shadow: 7px 7px 0 var(--dark); color: white; }
  .btn-secondary { padding: 16px 36px; background: var(--white); color: var(--dark); border: 3px solid var(--dark); border-radius: 50px; font-family: 'Nunito', sans-serif; font-size: 1rem; font-weight: 800; cursor: pointer; box-shadow: 5px 5px 0 var(--dark); transition: all 0.15s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
  .btn-secondary:hover { transform: translate(-2px, -2px); box-shadow: 7px 7px 0 var(--dark); }

  /* SECTION */
  .section { padding: 80px 40px; }
  .section-header { text-align: center; margin-bottom: 60px; }
  .section-tag { display: inline-block; padding: 5px 16px; border-radius: 50px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 16px; border: 2px solid var(--dark); box-shadow: 3px 3px 0 var(--dark); }
  .section-header h2 { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 900; line-height: 1.1; }

  /* PRODUCT CARD */
  .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 28px; max-width: 1200px; margin: 0 auto; }
  .product-card { background: white; border: 3px solid var(--dark); border-radius: 20px; overflow: hidden; box-shadow: 6px 6px 0 var(--dark); transition: all 0.2s; }
  .product-card:hover { transform: translate(-3px, -3px); box-shadow: 9px 9px 0 var(--dark); }
  .product-img { height: 220px; display: flex; align-items: center; justify-content: center; font-size: 5rem; position: relative; }
  .product-badge { position: absolute; top: 14px; right: 14px; background: var(--gold); border: 2px solid var(--dark); border-radius: 50px; padding: 3px 12px; font-size: 0.72rem; font-weight: 800; box-shadow: 2px 2px 0 var(--dark); }
  .product-info { padding: 20px; }
  .product-category { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--mid); margin-bottom: 6px; }
  .product-name { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; margin-bottom: 8px; line-height: 1.3; }
  .product-desc { font-size: 0.85rem; color: var(--mid); margin-bottom: 16px; line-height: 1.5; font-weight: 600; }
  .product-footer { display: flex; align-items: center; justify-content: space-between; }
  .product-price { font-size: 1.4rem; font-weight: 800; color: var(--coral); }
  .add-to-cart-btn { padding: 10px 20px; background: var(--dark); color: white; border: none; border-radius: 50px; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 0.85rem; cursor: pointer; transition: all 0.15s; box-shadow: 3px 3px 0 var(--coral); text-decoration: none; }
  .add-to-cart-btn:hover { background: var(--coral); box-shadow: 3px 3px 0 var(--dark); color: white; }

  /* FOOTER */
  footer { background: var(--dark); color: white; text-align: center; padding: 40px; font-weight: 600; font-size: 0.9rem; }
  .footer-logo { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 900; color: var(--coral); margin-bottom: 12px; }
  footer p { color: rgba(255,255,255,0.6); }
  .footer-login-btn { display: inline-flex; align-items: center; gap: 8px; margin-top: 16px; padding: 12px 28px; background: var(--coral); color: white; border: 2.5px solid white; border-radius: 50px; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 0.9rem; text-decoration: none; transition: all 0.2s; box-shadow: 3px 3px 0 rgba(255,255,255,0.3); }
  .footer-login-btn:hover { background: white; color: var(--dark); }

  /* BACK BTN */
  .back-btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: white; border: 2.5px solid var(--dark); border-radius: 50px; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 0.9rem; cursor: pointer; box-shadow: 3px 3px 0 var(--dark); margin-bottom: 36px; transition: all 0.15s; text-decoration: none; color: var(--dark); }
  .back-btn:hover { background: var(--dark); color: white; }

  @media (max-width: 900px) { nav { padding: 0 20px; } .section { padding: 60px 20px; } }
  @media (max-width: 600px) { .nav-links { gap: 4px; } .nav-btn { padding: 7px 12px; font-size: 0.8rem; } }
</style>
@stack('styles')
</head>
<body>

{{-- ══ NAVBAR ══ --}}
<nav>
  <a class="nav-logo" href="{{ route('home') }}">🧵 Stitch <span>&</span> Bloom</a>
  <div class="nav-links">
    <a class="nav-btn {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
    <a class="nav-btn {{ request()->routeIs('shop') ? 'active' : '' }}" href="{{ route('shop') }}">Shop</a>
    <a class="nav-btn cart-btn" href="{{ route('cart') }}">
      🛒 Cart
      @if(session()->has('cart') && count(session('cart')) > 0)
        <span class="cart-badge">{{ array_sum(array_column(session('cart'), 'qty')) }}</span>
      @endif
    </a>

    {{-- Show different nav items based on auth state --}}
    @auth
      @if(Auth::user()->isAdmin())
        <a class="nav-btn" href="{{ route('admin.dashboard') }}">⚙ Admin</a>
      @else
        <a class="nav-btn" href="{{ route('user.dashboard') }}">👤 My Account</a>
      @endif
      <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit" class="nav-btn">Sign Out</button>
      </form>
    @else
      {{-- Single login button — opens the modal --}}
      <button class="nav-btn login-btn" onclick="openLoginModal()">🌸 Login / Join</button>
    @endauth
  </div>
</nav>

{{-- ALERTS --}}
@if(session('success'))
  <div class="alert alert-success">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-error">❌ {{ session('error') }}</div>
@endif

@yield('content')

{{-- ══ FOOTER ══ --}}
<footer>
  <div class="footer-logo">Stitch & Bloom</div>
  <p>Handmade embroidery with love 🧵 · Every piece is unique · Made to order</p>
  @guest
    <a class="footer-login-btn" onclick="openLoginModal()" href="#">
      🌸 Join & Get 10% Off Your First Order
    </a>
  @endguest
</footer>

{{-- ══ LOGIN MODAL (placed correctly before </body>) ══ --}}
@guest
  @include('auth.login')
@endguest

@stack('scripts')
</body>
</html>
