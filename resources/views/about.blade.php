@extends('layouts.app')
@section('title', 'About — Stitch & Bloom')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
/* ═══════════════════════════════════════
   ABOUT PAGE — Editorial Magazine Style
═══════════════════════════════════════ */
.about-page { overflow: hidden; }

/* ── Hero section ── */
.about-hero {
  min-height: 88vh;
  position: relative;
  background: #FAF5EF;
  display: flex;
  align-items: center;
  overflow: hidden;
}

/* Large background circle blobs */
.blob {
  position: absolute;
  border-radius: 50%;
  pointer-events: none;
}
.blob-1 {
  width: 520px; height: 520px;
  background: #F2C6AE;
  top: -80px; left: -100px;
  opacity: .45;
}
.blob-2 {
  width: 340px; height: 340px;
  background: #E8D6C8;
  bottom: -60px; right: 120px;
  opacity: .5;
}

/* Diagonal stripe ribbon */
.stripe-ribbon {
  position: absolute;
  right: -30px; top: 50%;
  transform: translateY(-50%);
  width: 180px; height: 340px;
  overflow: hidden;
  z-index: 2;
}
.stripe-ribbon-inner {
  width: 100%; height: 100%;
  background: repeating-linear-gradient(
    -45deg,
    #1a1a1a 0px, #1a1a1a 8px,
    #FAF5EF 8px, #FAF5EF 18px
  );
  border-radius: 50% 0 0 50%;
  clip-path: ellipse(100% 100% at 100% 50%);
}

/* Horizontal rule across middle */
.hero-rule {
  position: absolute;
  left: 0; right: 0;
  top: 50%;
  height: 2px;
  background: #1a1a1a;
  transform: translateY(-50%);
  z-index: 1;
}

/* Floating label boxes */
.float-label {
  position: absolute;
  border: 2px solid #1a1a1a;
  padding: 10px 20px;
  font-family: 'Nunito', sans-serif;
  font-weight: 800;
  font-size: .85rem;
  letter-spacing: .12em;
  text-transform: uppercase;
  background: #FAF5EF;
  z-index: 4;
  box-shadow: 3px 3px 0 #1a1a1a;
}
.fl-say-hi  { top: 18%;  left: 6%; }
.fl-video   { top: 18%;  right: 14%; padding: 10px 28px; }
.fl-faves   { bottom: 22%; left: 6%; }
.fl-story   { bottom: 22%; right: 14%; }

/* Portrait circle */
.portrait-wrap {
  position: relative;
  z-index: 5;
  margin: 0 auto;
  width: 200px; height: 200px;
}
.portrait-circle {
  width: 200px; height: 200px;
  border-radius: 50%;
  border: 5px solid #1a1a1a;
  box-shadow: 8px 8px 0 #1a1a1a;
  overflow: hidden;
  background: linear-gradient(135deg, #F2C6AE, #E8D6C8);
  display: flex; align-items: center; justify-content: center;
}
.portrait-circle img {
  width: 100%; height: 100%;
  object-fit: cover; display: block;
}
.portrait-placeholder {
  display: flex; flex-direction: column; align-items: center;
  justify-content: center; gap: 8px; color: rgba(0,0,0,.35);
  font-size: .75rem; font-weight: 800; text-transform: uppercase;
  letter-spacing: .06em;
}

/* Hero center content */
.hero-center {
  position: relative; z-index: 5;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  padding: 120px 60px;
  width: 100%;
}

/* ── About section ── */
.about-main {
  background: white;
  padding: 100px 40px;
  position: relative;
  overflow: hidden;
}

/* Big "ABOUT" title */
.about-big-title {
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(5rem, 12vw, 9rem);
  letter-spacing: .04em;
  color: #1a1a1a;
  line-height: .9;
  margin-bottom: 48px;
  position: relative;
  display: inline-block;
}
.about-big-title::after {
  content: '';
  position: absolute;
  bottom: -6px; left: 0; right: 0;
  height: 6px;
  background: var(--coral);
  border-radius: 3px;
}

/* Two-column text */
.about-text-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 48px;
  max-width: 900px;
}
.about-text-col p {
  font-size: 1rem;
  line-height: 1.85;
  color: #555;
  font-weight: 600;
  margin-bottom: 18px;
}
.about-text-col p:last-child { margin-bottom: 0; }

/* Decorative accent */
.about-accent-line {
  width: 60px; height: 4px;
  background: var(--coral);
  border-radius: 2px;
  margin-bottom: 24px;
}

/* ── Values strip ── */
.values-strip {
  background: #1a1a1a;
  padding: 72px 40px;
  position: relative;
  overflow: hidden;
}
.values-strip-bg {
  position: absolute; inset: 0;
  background: repeating-linear-gradient(
    -60deg,
    transparent 0px, transparent 40px,
    rgba(255,255,255,.03) 40px, rgba(255,255,255,.03) 41px
  );
}
.values-inner {
  max-width: 1100px; margin: 0 auto;
  position: relative; z-index: 1;
}
.values-label {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 1rem; letter-spacing: .25em;
  color: var(--coral); margin-bottom: 48px;
  text-transform: uppercase;
}
.values-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 36px;
}
.value-card { border-left: 3px solid var(--coral); padding-left: 20px; }
.value-num {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 3rem; color: rgba(255,255,255,.15);
  line-height: 1; margin-bottom: 4px;
}
.value-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.25rem; font-weight: 700;
  color: white; margin-bottom: 10px;
}
.value-text { font-size: .88rem; color: rgba(255,255,255,.65); font-weight: 600; line-height: 1.7; }

/* ── Story section ── */
.story-section {
  background: #FAF5EF;
  padding: 100px 40px;
  position: relative;
}
.story-inner {
  max-width: 1100px; margin: 0 auto;
  display: grid; grid-template-columns: 1fr 1fr;
  gap: 80px; align-items: center;
}
.story-img-frame {
  position: relative;
}
.story-img-main {
  width: 100%; aspect-ratio: 4/5;
  border: 3px solid #1a1a1a;
  border-radius: 4px;
  background: linear-gradient(135deg, #F2C6AE, #E8D6C8);
  box-shadow: 12px 12px 0 #1a1a1a;
  display: flex; align-items: center; justify-content: center;
  overflow: hidden; position: relative;
}
.story-img-main img { width: 100%; height: 100%; object-fit: cover; }
.story-img-decoration {
  position: absolute; bottom: -24px; right: -24px;
  width: 120px; height: 120px;
  background: var(--coral);
  border: 3px solid #1a1a1a;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 2.5rem;
  box-shadow: 5px 5px 0 #1a1a1a;
  z-index: 2;
}
.story-badge {
  position: absolute; top: -18px; left: -18px;
  background: #1a1a1a; color: white;
  padding: 8px 18px;
  font-family: 'Nunito', sans-serif;
  font-weight: 800; font-size: .78rem;
  letter-spacing: .1em; text-transform: uppercase;
  border-radius: 50px;
  z-index: 2;
}
.story-text h2 {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2rem, 4vw, 2.8rem);
  font-weight: 900; line-height: 1.15;
  margin-bottom: 20px; color: #1a1a1a;
}
.story-text h2 em { font-style: italic; color: var(--coral); }
.story-text p {
  font-size: 1rem; line-height: 1.85;
  color: #666; font-weight: 600; margin-bottom: 18px;
}
.story-quote {
  border-left: 4px solid var(--coral);
  padding: 16px 24px;
  background: white;
  border-radius: 0 12px 12px 0;
  margin: 24px 0;
}
.story-quote p {
  font-family: 'Playfair Display', serif;
  font-size: 1.1rem; font-style: italic;
  color: #1a1a1a; font-weight: 700; margin: 0; line-height: 1.6;
}

/* ── CTA strip ── */
.about-cta {
  background: var(--coral);
  padding: 72px 40px;
  text-align: center;
  position: relative; overflow: hidden;
}
.about-cta::before {
  content: '';
  position: absolute; inset: 0;
  background: repeating-linear-gradient(90deg, transparent 0px, transparent 60px, rgba(255,255,255,.07) 60px, rgba(255,255,255,.07) 61px);
}
.about-cta-inner { position: relative; z-index: 1; }
.about-cta h3 {
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(2.5rem, 6vw, 4.5rem);
  color: white; letter-spacing: .05em;
  margin-bottom: 20px; line-height: 1;
}
.about-cta p {
  font-size: 1.1rem; color: rgba(255,255,255,.85);
  font-weight: 600; margin-bottom: 36px; max-width: 500px; margin-inline: auto;
}
.about-cta-btn {
  display: inline-flex; align-items: center; gap: 10px;
  padding: 18px 44px;
  background: white; color: #1a1a1a;
  border: 3px solid #1a1a1a; border-radius: 50px;
  font-family: 'Nunito', sans-serif; font-size: 1.05rem; font-weight: 800;
  text-decoration: none; cursor: pointer;
  box-shadow: 6px 6px 0 #1a1a1a;
  transition: all .15s;
}
.about-cta-btn:hover { transform: translate(-3px,-3px); box-shadow: 9px 9px 0 #1a1a1a; color: #1a1a1a; }

/* Responsive */
@media(max-width:900px){
  .fl-say-hi,.fl-video,.fl-faves,.fl-story{display:none;}
  .stripe-ribbon{display:none;}
  .blob-1{width:300px;height:300px;}
  .about-text-grid{grid-template-columns:1fr;}
  .story-inner{grid-template-columns:1fr;gap:40px;}
  .story-img-frame{max-width:400px;margin:0 auto;}
  .hero-center{padding:80px 24px;}
}
@media(max-width:600px){
  .about-main,.story-section,.values-strip,.about-cta{padding:60px 20px;}
  .about-big-title{font-size:4.5rem;}
}
</style>
@endpush

@section('content')
<div class="about-page">

  {{-- ═══ HERO ═══ --}}
  <div class="about-hero">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="hero-rule"></div>

    {{-- Floating labels --}}
    <div class="float-label fl-say-hi">SAY<br>HI</div>
    <div class="float-label fl-video">— OUR STORY —</div>
    <div class="float-label fl-faves">— FAVES —</div>
    <div class="float-label fl-story">HANDMADE</div>

    {{-- Stripe ribbon --}}
    <div class="stripe-ribbon"><div class="stripe-ribbon-inner"></div></div>

    <div class="hero-center">
      {{-- Portrait --}}
      <div class="portrait-wrap">
        <div class="portrait-circle">
          {{-- Replace the src below with your actual photo --}}
          <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&h=400&fit=crop&crop=face"
               alt="Founder of Stitch & Bloom"
               onerror="this.closest('.portrait-circle').classList.add('ph-mode');this.style.display='none';" />
          <div class="portrait-placeholder" style="display:none;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            <span>Your photo</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ═══ ABOUT TEXT ═══ --}}
  <div class="about-main">
    <div style="max-width:1100px;margin:0 auto;">
      <div class="about-big-title">ABOUT</div>
      <div class="about-text-grid">
        <div class="about-text-col">
          <div class="about-accent-line"></div>
          <p>Hi, I'm the hands and heart behind Stitch & Bloom — a small handmade embroidery studio based in India, where every piece is born from patience, colour, and genuine love for the craft.</p>
          <p>What started as a quiet hobby in my childhood home has grown into something I couldn't have imagined: a studio where each hoop, pillowcase, and sofa cover carries a little piece of me in every stitch.</p>
          <p>I believe handmade things carry an energy that mass-produced items simply can't replicate. When you hold one of my pieces, you're holding hours of careful, intentional work — and that means everything to me.</p>
        </div>
        <div class="about-text-col">
          <div class="about-accent-line" style="background:var(--teal);"></div>
          <p>Every design starts with a sketch, then comes to life on fabric one thread at a time. I work with premium quality hoops, soft cotton fabrics, and the finest embroidery threads sourced from across India.</p>
          <p>No two pieces are ever exactly the same — slight variations are what make each item uniquely yours. I take that seriously, and I hope you treasure it too.</p>
          <p>Thank you for supporting small, slow, and handmade. It truly means the world. Whether you're decorating your home or gifting someone special, I hope Stitch & Bloom adds a little warmth to your life.</p>
        </div>
      </div>
    </div>
  </div>

  {{-- ═══ VALUES ═══ --}}
  <div class="values-strip">
    <div class="values-strip-bg"></div>
    <div class="values-inner">
      <div class="values-label">What We Stand For</div>
      <div class="values-grid">
        <div class="value-card">
          <div class="value-num">01</div>
          <div class="value-title">Handmade Always</div>
          <div class="value-text">Every single piece is stitched entirely by hand — no machines, no shortcuts. Just thread, needle, and time.</div>
        </div>
        <div class="value-card">
          <div class="value-num">02</div>
          <div class="value-title">Made with Intention</div>
          <div class="value-text">Each design is thoughtfully created. We don't rush — slow making means better making.</div>
        </div>
        <div class="value-card">
          <div class="value-num">03</div>
          <div class="value-title">Sustainably Crafted</div>
          <div class="value-text">We use natural fabrics, eco-friendly threads, and minimal packaging that respects our planet.</div>
        </div>
        <div class="value-card">
          <div class="value-num">04</div>
          <div class="value-title">Custom Orders Welcome</div>
          <div class="value-text">Your vision, brought to life. We love working on custom pieces that tell your story.</div>
        </div>
      </div>
    </div>
  </div>

  {{-- ═══ STORY SECTION ═══ --}}
  <div class="story-section">
    <div class="story-inner">
      <div class="story-img-frame">
        <div class="story-badge">Est. 2019</div>
        <div class="story-img-main">
          <img src="https://images.unsplash.com/photo-1618220179428-22790b461013?w=600&h=750&fit=crop"
               alt="Embroidery in progress"
               onerror="this.style.display='none';" />
          <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="rgba(0,0,0,0.2)" stroke-width="1" style="position:absolute;display:none;" id="imgFallback"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        </div>
        <div class="story-img-decoration">🌸</div>
      </div>
      <div class="story-text">
        <h2>The story behind every <em>stitch</em></h2>
        <p>Stitch & Bloom was born in 2019 when I found myself drawn back to the embroidery hoop I'd abandoned as a teenager. What began as stress relief during lockdown became my calling.</p>
        <div class="story-quote">
          <p>"I wanted to create things that felt alive — that carried warmth, colour, and the kind of care you can actually feel when you hold them."</p>
        </div>
        <p>Today, every piece ships from my little home studio in India, wrapped with love and a hand-written note. I'm so grateful you're here.</p>
        <a class="btn-primary" href="{{ route('shop') }}" style="margin-top:8px;">
          🧵 Shop the Collection
        </a>
      </div>
    </div>
  </div>

  {{-- ═══ CTA ═══ --}}
  <div class="about-cta">
    <div class="about-cta-inner">
      <h3>Let's make something beautiful</h3>
      <p>Whether you're looking for a unique gift, home decor, or a custom piece — we'd love to create it for you.</p>
      <a class="about-cta-btn" href="{{ route('shop') }}">🌸 Browse the Shop</a>
    </div>
  </div>

</div>
@endsection
