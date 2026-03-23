@extends('layouts.app')

@section('title', 'Contact Us — Soochikaari')

@push('styles')

    <style>
    .contact-page{max-width:1120px;margin:0 auto;padding:44px 20px 80px;}
    .contact-hero{text-align:center;max-width:760px;margin:0 auto 34px;}
    .contact-hero p{color:var(--mid);line-height:1.8;font-size:1rem;}
    .contact-grid{display:grid;grid-template-columns:minmax(0,1.05fr) minmax(320px,.95fr);gap:24px;align-items:start;}
    .contact-card,.contact-panel{background:#fff;border:2px solid var(--border);border-radius:28px;box-shadow:8px 8px 0 rgba(58,58,58,.06);overflow:hidden;}
    .contact-card-body,.contact-panel-body{padding:28px;}
    .contact-highlights{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;margin-bottom:22px;}
    .contact-highlight{background:var(--bg5);border:1.5px solid var(--border);border-radius:20px;padding:18px 14px;text-align:center;}
    .contact-highlight strong{display:block;margin:8px 0 4px;font-size:.92rem;}
    .contact-highlight span{display:block;color:var(--mid);font-size:.82rem;line-height:1.5;word-break:break-word;}
    .contact-form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px;}
    .contact-field{display:flex;flex-direction:column;gap:8px;margin-bottom:16px;}
    .contact-field label{font-size:.9rem;font-weight:800;color:var(--dark);}
    .contact-field input,.contact-field textarea{width:100%;border:1.5px solid var(--border);border-radius:18px;padding:14px 16px;font:inherit;background:var(--bg);color:var(--dark);outline:none;transition:border-color .2s, box-shadow .2s;}
    .contact-field input:focus,.contact-field textarea:focus{border-color:var(--p1);box-shadow:0 0 0 4px rgba(212,149,106,.12);}
    .contact-field textarea{resize:vertical;min-height:160px;}
    .contact-field.is-error input,.contact-field.is-error textarea{border-color:#c75c64;background:#fff7f7;}
    .contact-error{font-size:.78rem;color:#b54752;font-weight:700;}
    .contact-success{background:var(--bg2);border:1.5px solid var(--p3);color:#2d6b5e;border-radius:18px;padding:14px 18px;font-weight:700;margin-bottom:18px;}
    .contact-panel-list{display:flex;flex-direction:column;gap:16px;margin-top:18px;}
    .contact-panel-item{display:flex;gap:14px;align-items:flex-start;padding:16px;border:1.5px solid var(--border);border-radius:18px;background:var(--bg4);}
    .contact-panel-item strong{display:block;margin-bottom:4px;}
    .contact-panel-item p,.contact-panel-item a{margin:0;color:var(--mid);line-height:1.6;text-decoration:none;word-break:break-word;}
    .contact-panel-item a:hover{color:var(--p1);}
    .contact-note{margin-top:18px;padding:16px 18px;border-radius:18px;background:var(--bg1);border:1.5px dashed var(--border);color:var(--mid);line-height:1.7;}
    @media(max-width:900px){.contact-grid{grid-template-columns:1fr;}.contact-highlights{grid-template-columns:1fr;}.contact-form-grid{grid-template-columns:1fr;}}
    </style>

@endpush
@section('content')
<div class="contact-page">
    <section class="contact-hero">
        <div class="section-tag" style="background: var(--bg5); color: var(--p5);">📬 Contact</div>
        <h1>Let’s talk about your next handmade order</h1>
        <p>Have a question about custom embroidery, delivery, gifting, or care instructions? Send a message and we’ll guide you step by step.</p>
    </section>
    <div class="contact-grid">
        <section class="contact-card">
            <div class="rangoli-strip"></div>
            <div class="contact-card-body">
                @if(session('success'))
                    <div class="contact-success">✅ {{ session('success') }}</div>
                @endif

                <div class="contact-highlights">
                    <div class="contact-highlight">
                        <div>📍</div>
                        <strong>Based in India</strong>
                        <span>Crafted and coordinated from Surat, Gujarat.</span>
                    </div>
                    <div class="contact-highlight">
                        <div>📧</div>
                        <strong>Email support</strong>
                        <span>{{ $contactEmail }}</span>
                    </div>
                    <div class="contact-highlight">
                        <div>🕐</div>
                        <strong>Fast response</strong>
                        <span>Usually within 24 business hours.</span>
                    </div>
                </div>

                <form action="{{ route('contact.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="contact-form-grid">
                        <div class="contact-field @error('name') is-error @enderror">
                            <label for="contact-name">Your Name *</label>
                            <input id="contact-name" type="text" name="name" value="{{ old('name') }}" placeholder="">
                            @error('name')<div class="contact-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="contact-field @error('email') is-error @enderror">
                            <label for="contact-email">Email Address *</label>
                            <input id="contact-email" type="email" name="email" value="{{ old('email') }}" placeholder="">
                            @error('email')<div class="contact-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="contact-field @error('phone') is-error @enderror">
                        <label for="contact-phone">Phone Number <span style="font-weight:600;color:var(--mid);">(optional)</span></label>
                        <input id="contact-phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="">
                        @error('phone')<div class="contact-error">{{ $message }}</div>@enderror
                    </div>

                   <div style="margin-top:20px;">
                        <button type="submit" class="btn-primary">Send Message ✉️</button>
                    </div>
                </form>
            </div>
        </section>
        <aside class="contact-panel">
            <div class="contact-panel-body">
                <div class="section-tag" style="background: var(--bg2); color: var(--p3);">💬 Before you send</div>
                <h2 style="margin-bottom:12px;">What to include for faster help</h2>
                <p style="color:var(--mid);line-height:1.8;">The more specific your message is, the easier it is for us to help with recommendations, timelines, and custom requests.</p>
                <div class="contact-panel-list">
                    <div class="contact-panel-item">
                        <div>🧵</div>
                        <div>
                            <strong>Custom order details</strong>
                            <p>Share product type, colors, quantity, and occasion if you want a personalized piece.</p>
                        </div>
                    </div>
                    <div class="contact-panel-item">
                        <div>🚚</div>
                        <div>
                            <strong>Delivery questions</strong>
                            <p>Tell us your city or country so we can guide you on shipping expectations.</p>
                        </div>
                    </div>
                    <div class="contact-panel-item">
                        <div>📨</div>
                        <div>
                            <strong>Preferred contact method</strong>
                            <p>We’ll reach you at <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a> if you have questions about where inquiries go.</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection