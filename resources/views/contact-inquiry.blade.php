<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Inquiry — Soochikaari</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Nunito', 'Helvetica Neue', Arial, sans-serif; background: #FAF7F4; color: #3A3A3A; padding: 40px 20px; }
        .wrapper { max-width: 600px; margin: 0 auto; }
        .rangoli-strip { height: 5px; background: linear-gradient(90deg, #D4956A, #C9A96E, #6FA89A, #8B7BB5, #C49BA0); border-radius: 4px 4px 0 0; opacity: 0.7; }
        .header { background: linear-gradient(135deg, #FFE8D6 0%, #FFD6E8 50%, #E8D6FF 100%); border: 3px solid #3A3A3A; border-top: none; padding: 32px 36px 28px; }
        .brand { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 900; color: #3A3A3A; margin-bottom: 6px; }
        .brand .accent { color: #D4956A; }
        .brand-tag { font-size: 0.72rem; font-weight: 700; color: #9A9A9A; text-transform: uppercase; letter-spacing: 0.06em; }
        .body { background: #FFFFFF; border: 3px solid #3A3A3A; border-top: none; padding: 32px 36px; box-shadow: 6px 6px 0 #3A3A3A; }
        .section-tag { display: inline-block; padding: 4px 14px; border-radius: 50px; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; border: 1.5px solid #E2D9D0; background: rgba(212,149,106,0.08); color: #D4956A; margin-bottom: 10px; }
        h1 { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 900; line-height: 1.2; margin-bottom: 6px; color: #3A3A3A; }
        .subtitle { font-size: 0.88rem; color: #9A9A9A; font-weight: 600; margin-bottom: 28px; line-height: 1.5; }
        .divider { height: 2px; background: #FAF7F4; border-radius: 2px; margin: 24px 0; }
        .status-row { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
        .status-badge { display: inline-block; padding: 4px 14px; border-radius: 50px; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.05em; background: #E8F8F5; color: #3A3A3A; border: 2px solid #3A3A3A; }
        .received-at { font-size: 0.78rem; font-weight: 700; color: #9A9A9A; }
        .field { margin-bottom: 16px; }
        .field-label { font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #9A9A9A; margin-bottom: 4px; }
        .field-value { font-size: 0.95rem; font-weight: 700; color: #3A3A3A; padding: 11px 14px; background: #FAF7F4; border: 2px solid #E2D9D0; border-radius: 11px; }
        .message-box { padding: 16px 18px; background: #FBF3EE; border: 2px solid rgba(212,149,106,0.25); border-left: 4px solid #D4956A; border-radius: 0 12px 12px 0; font-size: 0.92rem; font-weight: 600; color: #3A3A3A; line-height: 1.75; }
        .cta-wrap { margin-top: 28px; text-align: center; }
        .cta-btn { display: inline-block; padding: 14px 32px; background: #D4956A; color: #ffffff; text-decoration: none; font-family: 'Nunito', sans-serif; font-size: 0.95rem; font-weight: 800; border-radius: 50px; border: 2px solid #3A3A3A; box-shadow: 4px 4px 0 #3A3A3A; }
        .footer-note { margin-top: 28px; padding: 14px 18px; background: #FAF7F4; border: 1.5px dashed #E2D9D0; border-radius: 12px; font-size: 0.78rem; font-weight: 700; color: #9A9A9A; line-height: 1.6; }
        .email-footer { margin-top: 28px; text-align: center; }
        .footer-logo { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 900; color: #D4956A; margin-bottom: 4px; }
        .footer-copy { font-size: 0.72rem; color: #9A9A9A; font-weight: 600; }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="rangoli-strip"></div>

    <div class="header">
        <div class="brand">🪡 <span class="accent">Soochi</span>kaari</div>
        <div class="brand-tag">The Art of Indian Embroidery</div>
    </div>

    <div class="body">
        <div class="section-tag">📬 New Inquiry</div>
        <h1>Someone reached out!</h1>
        <p class="subtitle">A new contact inquiry has been submitted via the Soochikaari website. Here are the full details below.</p>

        <div class="status-row">
            <span class="status-badge">🟢 New</span>
            <span class="received-at">Received {{ $contact->created_at->format('d M Y, h:i A') }}</span>
        </div>

        <div class="divider"></div>

        <div class="field">
            <div class="field-label">👤 Name</div>
            <div class="field-value">{{ $contact->name }}</div>
        </div>

        <div class="field">
            <div class="field-label">✉️ Email</div>
            <div class="field-value">{{ $contact->email }}</div>
        </div>

        @if($contact->phone)
        <div class="field">
            <div class="field-label">📞 Phone</div>
            <div class="field-value">{{ $contact->phone }}</div>
        </div>
        @endif

        <div class="field">
            <div class="field-label">💬 Message</div>
            <div class="message-box">{{ $contact->message }}</div>
        </div>

        <div class="divider"></div>

        <div class="cta-wrap">
            <a href="mailto:{{ $contact->email }}" class="cta-btn">Reply to {{ $contact->name }} →</a>
        </div>

        <div class="footer-note">
            📋 This inquiry has been saved to your admin panel. Go to <strong>Admin → Contacts</strong> to view, manage, and mark it as replied.
        </div>
    </div>

    <div class="email-footer">
        <div class="footer-logo">🪡 Soochikaari</div>
        <div class="footer-copy">
            © {{ date('Y') }} Soochikaari · The Art of Indian Embroidery<br>
            Surat, Gujarat, India — Made with ♥ for Indian craft
        </div>
    </div>

</div>
</body>
</html>
