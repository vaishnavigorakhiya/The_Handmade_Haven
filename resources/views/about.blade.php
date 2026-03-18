@extends('layouts.app')
@section('title', 'About Us — Soochikaari')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
.about-page { overflow: hidden; }

/* ── HERO ── */
.about-hero {
  min-height: 82vh;
  position: relative;
  background: var(--bg1);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}
.blob { position: absolute; border-radius: 50%; pointer-events: none; }
.blob-1 { width: 480px; height: 480px; background: rgba(212,149,106,0.18); top: -80px; left: -100px; }
.blob-2 { width: 320px; height: 320px; background: rgba(111,168,154,0.15); bottom: -60px; right: 100px; }
.blob-3 { width: 200px; height: 200px; background: rgba(139,123,181,0.12); top: 40%; left: 55%; }
.hero-center {
  position: relative; z-index: 5;
  display: flex; flex-direction: column;
  align-items: center; text-align: center;
  padding: 100px 40px;
}
.portrait-wrap { position: relative; margin-bottom: 28px; }
.portrait-ring {
  width: 150px; height: 150px; border-radius: 50%;
  border: 4px solid var(--dark);
  box-shadow: 7px 7px 0 var(--p1);
  overflow: hidden;
  background: linear-gradient(135deg, var(--bg1), var(--bg2));
  display: flex; align-items: center; justify-content: center;
  font-size: 3.5rem;
  margin: 0 auto;
}
.portrait-ring img { width: 100%; height: 100%; object-fit: cover; display: block; }
.portrait-badge {
  position: absolute; bottom: -10px; right: -10px;
  background: var(--p4); color: white;
  border: 3px solid white;
  border-radius: 50px; padding: 4px 12px;
  font-family: 'Nunito', sans-serif; font-size: 0.7rem; font-weight: 800;
  letter-spacing: 0.05em; text-transform: uppercase;
  box-shadow: 3px 3px 0 var(--dark);
}
.hero-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2rem, 5vw, 3.2rem);
  font-weight: 900; color: var(--dark); line-height: 1.1;
  margin-bottom: 12px;
}
.hero-title em { color: var(--p1); font-style: italic; }
.hero-sub { font-size: 0.9rem; color: var(--mid); font-weight: 700; margin-bottom: 6px; }
.hero-brand {
  font-family: 'Playfair Display', serif;
  font-size: 1.1rem; font-weight: 900; color: var(--dark);
}
.hero-brand .accent { color: var(--p1); }

/* ── NAME MEANING STRIP ── */
.meaning-strip {
  background: var(--dark);
  padding: 28px 40px;
  display: flex; align-items: center; justify-content: center;
  gap: 40px; flex-wrap: wrap;
}
.meaning-item { text-align: center; }
.meaning-word {
  font-family: 'Playfair Display', serif;
  font-size: 1.4rem; font-weight: 900;
  color: var(--p1); margin-bottom: 4px;
}
.meaning-def { font-size: 0.75rem; color: rgba(255,255,255,0.55); font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; }
.meaning-divider { width: 1px; height: 48px; background: rgba(255,255,255,0.12); }
.meaning-together {
  font-family: 'Playfair Display', serif;
  font-size: 1rem; font-style: italic;
  color: rgba(255,255,255,0.75); text-align: center;
}
.meaning-together strong { color: var(--p2); font-style: normal; }

/* ── ABOUT MAIN ── */
.about-main { background: white; padding: 90px 40px; position: relative; overflow: hidden; }
.about-main-inner { max-width: 1060px; margin: 0 auto; }
.about-big-title {
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(5rem, 11vw, 8rem);
  letter-spacing: .04em; color: var(--dark);
  line-height: .9; margin-bottom: 44px;
  position: relative; display: inline-block;
}
.about-big-title::after {
  content: ''; position: absolute;
  bottom: -5px; left: 0; right: 0; height: 5px;
  background: var(--p1); border-radius: 3px;
}
.about-text-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; }
.about-accent-line { width: 52px; height: 4px; border-radius: 2px; margin-bottom: 22px; }
.about-text-col p {
  font-size: 0.95rem; line-height: 1.85;
  color: #666; font-weight: 600; margin-bottom: 16px;
}

/* ── VALUES ── */
.values-strip {
  background: linear-gradient(135deg, #2A1A3E 0%, #1E1430 60%, #2A1A3E 100%);
  padding: 72px 40px;
}
.values-inner { max-width: 1060px; margin: 0 auto; }
.values-label {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.9rem; letter-spacing: .25em;
  color: var(--p1); margin-bottom: 44px; text-transform: uppercase;
}
.values-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 32px; }
.value-card { border-left: 3px solid var(--p1); padding-left: 18px; }
.value-card:nth-child(2) { border-left-color: var(--p3); }
.value-card:nth-child(3) { border-left-color: var(--p4); }
.value-card:nth-child(4) { border-left-color: var(--p2); }
.value-num {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 2.8rem; color: rgba(255,255,255,.12);
  line-height: 1; margin-bottom: 4px;
}
.value-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.15rem; font-weight: 700;
  color: white; margin-bottom: 8px;
}
.value-text { font-size: .82rem; color: rgba(255,255,255,.58); font-weight: 600; line-height: 1.7; }

/* ── STORY ── */
.story-section { background: var(--bg); padding: 90px 40px; }
.story-inner {
  max-width: 1060px; margin: 0 auto;
  display: grid; grid-template-columns: 1fr 1.3fr;
  gap: 72px; align-items: center;
}
.story-img-frame { position: relative; }
.story-badge {
  position: absolute; top: -16px; left: -16px;
  background: var(--dark); color: white;
  padding: 6px 16px;
  font-family: 'Nunito', sans-serif; font-weight: 800;
  font-size: .72rem; letter-spacing: .1em;
  text-transform: uppercase; border-radius: 50px; z-index: 2;
  box-shadow: 3px 3px 0 var(--p1);
}
.story-img-main {
  width: 100%; aspect-ratio: 4/5;
  border: 3px solid var(--dark); border-radius: 6px;
  background: linear-gradient(135deg, var(--bg1), var(--bg2));
  box-shadow: 12px 12px 0 var(--p1);
  display: flex; align-items: center; justify-content: center;
  font-size: 5rem; overflow: hidden; position: relative;
}
.story-img-main img { width: 100%; height: 100%; object-fit: cover; }
.story-img-deco {
  position: absolute; bottom: -22px; right: -22px;
  width: 80px; height: 80px;
  background: var(--p4); border: 3px solid var(--dark);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 2rem; box-shadow: 4px 4px 0 var(--dark); z-index: 2;
}
.story-text h2 {
  font-family: 'Playfair Display', serif;
  font-size: clamp(1.7rem, 3.5vw, 2.5rem);
  font-weight: 900; line-height: 1.15;
  margin-bottom: 16px; color: var(--dark);
}
.story-text h2 em { font-style: italic; color: var(--p1); }
.story-text p {
  font-size: 0.95rem; line-height: 1.85;
  color: #666; font-weight: 600; margin-bottom: 16px;
}
.story-quote {
  border-left: 4px solid var(--p1);
  padding: 16px 22px;
  background: white; border-radius: 0 12px 12px 0;
  margin: 22px 0;
  box-shadow: 0 3px 12px rgba(212,149,106,0.12);
}
.story-quote p {
  font-family: 'Playfair Display', serif;
  font-size: 1rem; font-style: italic;
  color: var(--dark); font-weight: 700;
  margin: 0; line-height: 1.6;
}
.founder-sig {
  font-size: 0.82rem; font-weight: 800;
  color: var(--p1); margin-top: 4px;
  letter-spacing: 0.02em;
}

/* ── PROCESS ── */
.process-section { background: white; padding: 80px 40px; }
.process-inner { max-width: 1060px; margin: 0 auto; }
.process-header { margin-bottom: 48px; }
.section-tag {
  display: inline-block; padding: 5px 16px;
  border-radius: 50px; font-size: 0.75rem; font-weight: 800;
  text-transform: uppercase; letter-spacing: 0.1em;
  border: 1.5px solid var(--border);
  background: rgba(212,149,106,0.08); color: var(--p1);
  margin-bottom: 14px;
}
.process-header h2 {
  font-family: 'Playfair Display', serif;
  font-size: clamp(1.6rem, 3.5vw, 2.4rem);
  font-weight: 900; color: var(--dark); line-height: 1.1;
}
.process-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
.process-card {
  background: var(--bg); border: 1.5px solid var(--border);
  border-radius: 18px; padding: 32px 24px;
  position: relative; overflow: hidden;
  transition: all 0.2s;
}
.process-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(0,0,0,0.08); }
.process-card:nth-child(1) { background: var(--bg1); border-color: rgba(212,149,106,0.25); }
.process-card:nth-child(2) { background: var(--bg2); border-color: rgba(111,168,154,0.25); }
.process-card:nth-child(3) { background: var(--bg3); border-color: rgba(139,123,181,0.25); }
.process-num {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 4rem; line-height: 1;
  color: rgba(0,0,0,0.06); margin-bottom: 8px;
}
.process-icon { font-size: 2rem; margin-bottom: 14px; display: block; }
.process-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.15rem; font-weight: 900;
  color: var(--dark); margin-bottom: 10px;
}
.process-text { font-size: 0.85rem; line-height: 1.7; color: #777; font-weight: 600; }

/* ── CTA ── */
.about-cta {
  background: linear-gradient(135deg, var(--p1) 0%, var(--p2) 100%);
  padding: 80px 40px; text-align: center;
  position: relative; overflow: hidden;
}
.about-cta::before {
  content: ''; position: absolute;
  top: -60px; right: -60px;
  width: 280px; height: 280px;
  background: rgba(255,255,255,0.08);
  border-radius: 50%;
}
.about-cta::after {
  content: ''; position: absolute;
  bottom: -80px; left: -40px;
  width: 240px; height: 240px;
  background: rgba(255,255,255,0.06);
  border-radius: 50%;
}
.about-cta-inner { position: relative; z-index: 1; }
.about-cta h3 {
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(2.5rem, 6vw, 4.5rem);
  color: white; letter-spacing: .05em;
  margin-bottom: 16px; line-height: 1;
}
.about-cta p {
  font-size: 1rem; color: rgba(255,255,255,.88);
  font-weight: 600; margin-bottom: 36px;
  max-width: 480px; margin-inline: auto; line-height: 1.7;
}
.about-cta-btn {
  display: inline-flex; align-items: center; gap: 10px;
  padding: 16px 40px;
  background: white; color: var(--dark);
  border: 3px solid var(--dark);
  border-radius: 50px;
  font-family: 'Nunito', sans-serif;
  font-size: 1rem; font-weight: 800;
  text-decoration: none; cursor: pointer;
  box-shadow: 6px 6px 0 var(--dark);
  transition: all .15s;
}
.about-cta-btn:hover {
  transform: translate(-3px,-3px);
  box-shadow: 9px 9px 0 var(--dark);
  color: var(--dark);
}

/* ── RESPONSIVE ── */
@media(max-width: 900px) {
  .about-text-grid { grid-template-columns: 1fr; }
  .story-inner { grid-template-columns: 1fr; gap: 40px; }
  .story-img-frame { max-width: 380px; margin: 0 auto; }
  .process-grid { grid-template-columns: 1fr; }
  .hero-center { padding: 80px 20px; }
  .meaning-strip { gap: 20px; padding: 24px 20px; }
  .meaning-divider { display: none; }
}
@media(max-width: 600px) {
  .about-main, .story-section, .values-strip, .about-cta, .process-section { padding: 56px 20px; }
  .about-big-title { font-size: 4rem; }
  .process-grid { gap: 16px; }
}
</style>
@endpush

@section('content')
<div class="about-page">

  {{-- ── HERO ── --}}
  <div class="about-hero">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
    <div class="hero-center">
      <div class="portrait-wrap">
        <div class="portrait-ring">
          <img src="{{ asset('storage/products/Profile.jpeg') }}"
               alt="Vaishnavi Gorakhiya — Founder of Soochikaari"
               onerror="this.style.display='none';" />
        </div>
        {{-- <div class="portrait-badge">Founder & Maker</div> --}}
      </div>
      <h1 class="hero-title">
        Behind every stitch<br><em>is a story</em>
      </h1>
      <p class="hero-sub">Vaishnavi Gorakhiya · Founder & Creator</p>
      <p class="hero-brand">🪡 <span class="accent">Soochi</span>kaari</p>
    </div>
  </div>

  {{-- ── NAME MEANING STRIP ── --}}
  <div class="meaning-strip">
    <div class="meaning-item">
      <div class="meaning-word">सूची (Soochi)</div>
      <div class="meaning-def">Needle — the tool of our craft</div>
    </div>
    <div class="meaning-divider"></div>
    <div class="meaning-item">
      <div class="meaning-word">कारी (Kaari)</div>
      <div class="meaning-def">Craft · Art · Work</div>
    </div>
    <div class="meaning-divider"></div>
    <div class="meaning-together">Together: <strong>"The Art of the Needle"</strong> — pure sanskruti, purely handmade 🪡</div>
  </div>

  {{-- ── ABOUT MAIN ── --}}
  <div class="about-main">
    <div class="about-main-inner">
      <div class="about-big-title">ABOUT</div>
      <div class="about-text-grid">
        <div class="about-text-col">
          <div class="about-accent-line" style="background: var(--p1);"></div>
          <p>Hi, I'm <strong>Vaishnavi</strong> — the hands and heart behind Soochikaari, a handmade embroidery studio rooted in Gujarat, India, where every piece is born from patience, colour, and a genuine love for the craft.</p>
          <p>What started as a quiet hobby more than 5 years ago has grown into something I couldn't have imagined — a studio where each hoop, tote bag, cap, and pillowcase carries a little piece of me in every single stitch.</p>
          <p>I believe handmade things carry an energy that mass-produced items simply can't replicate. When you hold one of my pieces, you're holding hours of careful, intentional work.</p>
        </div>
        <div class="about-text-col">
          <div class="about-accent-line" style="background: var(--p3);"></div>
          <p>Every design starts with a sketch, then comes to life on fabric one thread at a time. I work with premium quality hoops, soft cotton fabrics, and the finest embroidery threads — sourced with care.</p>
          <p>No two pieces are ever exactly the same — those slight, human variations are what make each item uniquely yours. That's the magic of handmade.</p>
          <p>Thank you for supporting small, slow, and handmade. Whether you're decorating your home or gifting someone special, I hope Soochikaari brings a little warmth and beauty into your life. 🌸</p>
        </div>
      </div>
    </div>
  </div>

  {{-- ── VALUES ── --}}
  <div class="values-strip">
    <div class="values-inner">
      <div class="values-label">✦ What We Stand For</div>
      <div class="values-grid">
        <div class="value-card">
          <div class="value-num">01</div>
          <div class="value-title">Handmade Always</div>
          <div class="value-text">Every piece is stitched entirely by hand — no machines, no shortcuts, no compromise.</div>
        </div>
        <div class="value-card">
          <div class="value-num">02</div>
          <div class="value-title">Made with Intention</div>
          <div class="value-text">Each design is thoughtfully created. Slow making means better making — and we believe in that deeply.</div>
        </div>
        <div class="value-card">
          <div class="value-num">03</div>
          <div class="value-title">Rooted in Indian Craft</div>
          <div class="value-text">Soochikaari celebrates India's rich embroidery heritage — keeping ancient art alive one stitch at a time.</div>
        </div>
        <div class="value-card">
          <div class="value-num">04</div>
          <div class="value-title">Custom Orders Welcome</div>
          <div class="value-text">Your vision, brought to life. We love custom pieces that carry your personal story and meaning.</div>
        </div>
      </div>
    </div>
  </div>

  {{-- ── STORY ── --}}
  <div class="story-section">
    <div class="story-inner">
      <div class="story-img-frame">
        <div class="story-badge">Est. 2019 · Surat, Gujarat</div>
        <div class="story-img-main">
          <img src="{{ asset('storage/products/AboutUs.jpeg') }}"
               alt="Embroidery in progress" onerror="this.style.display='none';" />
        </div>
        <div class="story-img-deco">🌸</div>
      </div>
      <div class="story-text">
        <h2>The story behind every <em>stitch</em></h2>
        <p>Soochikaari was born from a deep love for hand embroidery and the quiet magic that happens between a needle, a thread, and a piece of cloth.</p>
        <p>Over 5 years ago, what began as a personal creative outlet slowly blossomed into something bigger. As a solo maker from Surat, Gujarat, this isn't just a shop — it's a labor of love.</p>
        <div class="story-quote">
          <p>"I wanted to create things that felt alive — that carried warmth, colour, and the kind of care you can actually feel when you hold them."</p>
        </div>
        <p>Today, every piece ships from my little home studio, wrapped with love and a hand-written note. I'm so grateful you're here.</p>
        <p class="founder-sig">— Vaishnavi Gorakhiya, Founder & Creator, Soochikaari 🪡</p>
        <a class="btn-primary" href="{{ route('shop') }}" style="margin-top: 20px;">🧵 Shop the Collection</a>
      </div>
    </div>
  </div>

  {{-- ── PROCESS ── --}}
  <div class="process-section">
    <div class="process-inner">
      <div class="process-header">
        <div class="section-tag">🪡 Our Craft Process</div>
        <h2 class="section-header-title" style="font-family:'Playfair Display',serif;font-size:clamp(1.6rem,3.5vw,2.4rem);font-weight:900;color:var(--dark);line-height:1.1;margin-top:10px;">
          How every piece <em style="color:var(--p1);font-style:italic;">comes to life</em>
        </h2>
      </div>
      <div class="process-grid">
        <div class="process-card">
          <div class="process-num">01</div>
          <span class="process-icon">🎨</span>
          <div class="process-title">Design</div>
          <div class="process-text">Every piece starts with an idea — a pattern, a colour palette, or a customer's dream. I sketch and plan each design with care before a single stitch is made.</div>
        </div>
        <div class="process-card">
          <div class="process-num">02</div>
          <span class="process-icon">🪡</span>
          <div class="process-title">Stitch</div>
          <div class="process-text">Using only hand embroidery techniques, I bring the design to life — stitch by stitch, with full attention and love. This is the heart of Soochikaari.</div>
        </div>
        <div class="process-card">
          <div class="process-num">03</div>
          <span class="process-icon">✨</span>
          <div class="process-title">Finish & Ship</div>
          <div class="process-text">Each finished piece is carefully inspected, cleaned, and packed with love before it reaches your hands — because you deserve something that feels as good as it looks.</div>
        </div>
      </div>
    </div>
  </div>

  {{-- ── CTA ── --}}
  <div class="about-cta">
    <div class="about-cta-inner">
      <h3>Let's make something beautiful</h3>
      <p>Whether you're looking for a unique gift, home decor, or a custom piece that tells your story — we'd love to create it for you.</p>
      <a class="about-cta-btn" href="{{ route('shop') }}">🌸 Browse the Shop</a>
    </div>
  </div>

</div>
@endsection
