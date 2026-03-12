@if(request()->routeIs('home'))
<button class="otp-trigger-btn" onclick="openOtpModal()" title="Join Stitch & Bloom">
  <span class="trigger-icon">🧵</span>
  <span class="trigger-text">Join & Get Offers</span>
</button>
@endif

<!-- MODAL OVERLAY -->
<div class="otp-overlay" id="otpOverlay" onclick="closeIfOutside(event)">
  <div class="otp-modal" id="otpModal">

    
    <div class="otp-left">
      <div class="otp-left-inner">
        <div class="otp-brand-logo">🧵 Stitch <span>&</span> Bloom</div>
        <h2 class="otp-welcome-title">Welcome to<br><em>Stitch & Bloom!</em></h2>
        <p class="otp-welcome-sub">India's finest handmade embroidery, crafted with love in every stitch.</p>

        <div class="otp-perks">
          <div class="otp-perk">
            <div class="perk-icon">🌸</div>
            <div>
              <div class="perk-title">Exclusive Member Offers</div>
              <div class="perk-desc">Early access to new collections & discounts</div>
            </div>
          </div>
          <div class="otp-perk">
            <div class="perk-icon">🎁</div>
            <div>
              <div class="perk-title">First Order Bonus</div>
              <div class="perk-desc">Get 10% off your very first purchase</div>
            </div>
          </div>
          <div class="otp-perk">
            <div class="perk-icon">✨</div>
            <div>
              <div class="perk-title">VIP Treatment</div>
              <div class="perk-desc">Track orders, save favourites & more</div>
            </div>
          </div>
        </div>

        <div class="otp-floaties">
          <span class="otp-float-emoji" style="animation-delay:0s">🪡</span>
          <span class="otp-float-emoji" style="animation-delay:0.4s">🌼</span>
          <span class="otp-float-emoji" style="animation-delay:0.8s">💛</span>
        </div>
      </div>
    </div>

    <!-- RIGHT SIDE — Form Panel -->
    <div class="otp-right">
      <button class="otp-close" onclick="closeOtpModal()">✕</button>

      <!-- STEP 1: Phone Number -->
      <div class="otp-step" id="stepPhone">
        <div class="step-tag">Step 1 of 2</div>
        <h3 class="step-title">Explore Stitch & Bloom</h3>
        <p class="step-sub">Affordable handmade, made with heart!</p>

        <div class="phone-input-wrap">
          <div class="phone-flag">🇮🇳 +91</div>
          <input type="tel" id="phoneInput" class="phone-input" placeholder="Enter Mobile Number" maxlength="10" oninput="this.value=this.value.replace(/\D/g,'')" />
        </div>

        <label class="otp-checkbox-label">
          <input type="checkbox" id="offerCheck" checked />
          <span class="otp-checkbox-custom"></span>
          Notify me with exclusive offers & updates
        </label>

        <button class="otp-submit-btn" onclick="sendOtp()">Send OTP</button>

        <p class="otp-legal">By continuing, I accept the <a href="#">Privacy Policy</a> and <a href="#">T&Cs</a>.</p>
      </div>

      <!-- STEP 2: OTP Verify -->
      <div class="otp-step hidden" id="stepOtp">
        <div class="step-tag">Step 2 of 2</div>
        <h3 class="step-title">Verify Your Number</h3>
        <p class="step-sub">We sent a 4-digit OTP to <strong id="displayPhone"></strong></p>

        <div class="otp-boxes">
          <input class="otp-box" type="text" maxlength="1" oninput="otpInput(this, 0)" id="otp0" />
          <input class="otp-box" type="text" maxlength="1" oninput="otpInput(this, 1)" id="otp1" />
          <input class="otp-box" type="text" maxlength="1" oninput="otpInput(this, 2)" id="otp2" />
          <input class="otp-box" type="text" maxlength="1" oninput="otpInput(this, 3)" id="otp3" />
        </div>

        <!-- Demo hint -->
        <div class="otp-demo-hint">💡 Demo OTP: <strong>1234</strong></div>

        <button class="otp-submit-btn" onclick="verifyOtp()">Verify & Continue</button>

        <p class="otp-legal" style="margin-top:12px;">
          Didn't receive it? <a href="#" onclick="resendOtp()">Resend OTP</a> &nbsp;|&nbsp;
          <a href="#" onclick="goBackToPhone()">Change Number</a>
        </p>
      </div>

    </div>
  </div>
</div>

<!-- USER DASHBOARD MODAL -->
<div class="otp-overlay" id="dashboardOverlay" onclick="closeDashIfOutside(event)">
  <div class="dashboard-modal" id="dashboardModal">

    <button class="otp-close" onclick="closeDashboard()" style="top:16px;right:20px;">✕</button>

    <div class="dash-header">
      <div class="dash-avatar" id="dashAvatar">🌸</div>
      <div>
        <div class="dash-welcome">Welcome back!</div>
        <div class="dash-name" id="dashName">Member</div>
        <div class="dash-phone" id="dashPhone"></div>
      </div>
      <div class="dash-badge">✨ VIP Member</div>
    </div>

    <div class="dash-cards">
      <div class="dash-card" style="background:#FFE8D6;">
        <div class="dash-card-icon">🛒</div>
        <div class="dash-card-val" id="dashOrders">0</div>
        <div class="dash-card-label">My Orders</div>
      </div>
      <div class="dash-card" style="background:#E8F8F5;">
        <div class="dash-card-icon">💰</div>
        <div class="dash-card-val" id="dashSaved">₹0</div>
        <div class="dash-card-label">Coins Saved</div>
      </div>
      <div class="dash-card" style="background:#F5E8FF;">
        <div class="dash-card-icon">🎁</div>
        <div class="dash-card-val">10%</div>
        <div class="dash-card-label">First Order Off</div>
      </div>
    </div>

    <div class="dash-coupon">
      <div class="coupon-label">🎉 Your Welcome Coupon</div>
      <div class="coupon-code" id="couponCode">STITCH10</div>
      <button class="coupon-copy" onclick="copyCoupon()">Copy Code</button>
    </div>

    <div class="dash-actions">
      <a href="{{ route('shop') }}" class="dash-action-btn" onclick="closeDashboard()">🌸 Browse Shop</a>
      <button class="dash-action-btn secondary" onclick="logout()">Sign Out</button>
    </div>

  </div>
</div>

<!-- ── STYLES ── -->
<style>
/* TRIGGER */
.otp-trigger-btn {
  position: fixed; bottom: 30px; left: 30px; z-index: 900;
  display: flex; align-items: center; gap: 10px;
  background: var(--coral); color: white;
  border: 3px solid var(--dark); border-radius: 50px;
  padding: 14px 24px; font-family: 'Nunito', sans-serif;
  font-weight: 800; font-size: 0.95rem; cursor: pointer;
  box-shadow: 5px 5px 0 var(--dark);
  animation: pulse-btn 2.5s ease-in-out infinite;
  transition: all 0.2s;
}
.otp-trigger-btn:hover { transform: translate(-2px,-2px); box-shadow: 7px 7px 0 var(--dark); }
.trigger-icon { font-size: 1.3rem; }
@keyframes pulse-btn { 0%,100%{box-shadow:5px 5px 0 var(--dark)} 50%{box-shadow:5px 5px 0 var(--teal)} }

/* OVERLAY */
.otp-overlay {
  position: fixed; inset: 0; z-index: 1000;
  background: rgba(0,0,0,0.5);
  display: flex; align-items: center; justify-content: center;
  padding: 20px;
  opacity: 0; pointer-events: none;
  transition: opacity 0.3s;
}
.otp-overlay.open { opacity: 1; pointer-events: all; }

/* MODAL */
.otp-modal {
  display: grid; grid-template-columns: 1fr 1fr;
  max-width: 860px; width: 100%;
  border: 3px solid var(--dark); border-radius: 28px;
  overflow: hidden; box-shadow: 10px 10px 0 var(--dark);
  transform: translateY(30px) scale(0.97);
  transition: transform 0.3s cubic-bezier(.34,1.56,.64,1);
  max-height: 90vh; overflow-y: auto;
}
.otp-overlay.open .otp-modal { transform: translateY(0) scale(1); }

/* LEFT */
.otp-left {
  background: linear-gradient(145deg, #FFE8D6 0%, #FFD6E8 50%, #E8D6FF 100%);
  padding: 48px 36px;
  position: relative; overflow: hidden;
}
.otp-left-inner { position: relative; z-index: 1; }
.otp-brand-logo {
  font-family: 'Playfair Display', serif;
  font-size: 1.1rem; font-weight: 900;
  color: var(--dark); margin-bottom: 28px;
}
.otp-brand-logo span { color: var(--coral); }
.otp-welcome-title {
  font-family: 'Playfair Display', serif;
  font-size: 2rem; font-weight: 900;
  line-height: 1.15; margin-bottom: 12px;
  color: var(--dark);
}
.otp-welcome-title em { font-style: normal; color: var(--coral); }
.otp-welcome-sub { color: var(--mid); font-weight: 600; font-size: 0.92rem; line-height: 1.6; margin-bottom: 32px; }

.otp-perks { display: flex; flex-direction: column; gap: 16px; }
.otp-perk { display: flex; align-items: flex-start; gap: 14px; }
.perk-icon { font-size: 1.6rem; flex-shrink: 0; }
.perk-title { font-weight: 800; font-size: 0.92rem; margin-bottom: 2px; }
.perk-desc { font-size: 0.8rem; color: var(--mid); font-weight: 600; }

.otp-floaties { position: absolute; bottom: 24px; right: 24px; display: flex; gap: 8px; }
.otp-float-emoji { font-size: 1.8rem; animation: float 3s ease-in-out infinite; display: inline-block; }

/* RIGHT */
.otp-right {
  background: white; padding: 48px 40px;
  position: relative;
}
.otp-close {
  position: absolute; top: 16px; right: 20px;
  background: var(--cream); border: 2px solid var(--dark);
  border-radius: 50%; width: 32px; height: 32px;
  font-size: 0.85rem; font-weight: 800; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: all 0.15s;
}
.otp-close:hover { background: var(--dark); color: white; }

.step-tag { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--teal); margin-bottom: 14px; }
.step-title { font-family: 'Playfair Display', serif; font-size: 1.7rem; font-weight: 900; margin-bottom: 6px; }
.step-sub { color: var(--mid); font-weight: 600; font-size: 0.9rem; margin-bottom: 28px; }

.phone-input-wrap {
  display: flex; align-items: center;
  border: 2.5px solid var(--dark); border-radius: 14px;
  overflow: hidden; margin-bottom: 16px;
  transition: border-color 0.2s;
}
.phone-input-wrap:focus-within { border-color: var(--coral); }
.phone-flag { padding: 0 14px; font-size: 0.95rem; font-weight: 800; background: var(--cream); height: 52px; display: flex; align-items: center; border-right: 2px solid var(--dark); white-space: nowrap; }
.phone-input { flex: 1; border: none; outline: none; padding: 0 16px; font-family: 'Nunito', sans-serif; font-size: 1rem; font-weight: 700; height: 52px; }

.otp-checkbox-label {
  display: flex; align-items: center; gap: 10px;
  font-size: 0.85rem; font-weight: 700; cursor: pointer;
  margin-bottom: 24px; color: var(--mid);
}
.otp-checkbox-label input { display: none; }
.otp-checkbox-custom {
  width: 18px; height: 18px; border: 2px solid var(--dark);
  border-radius: 5px; flex-shrink: 0; display: flex;
  align-items: center; justify-content: center; background: white;
  transition: all 0.15s;
}
.otp-checkbox-label input:checked + .otp-checkbox-custom { background: var(--teal); border-color: var(--teal); }
.otp-checkbox-label input:checked + .otp-checkbox-custom::after { content: '✓'; color: white; font-size: 0.75rem; font-weight: 900; }

.otp-submit-btn {
  width: 100%; padding: 15px;
  background: var(--dark); color: white;
  border: 3px solid var(--dark); border-radius: 50px;
  font-family: 'Nunito', sans-serif; font-size: 1rem; font-weight: 800;
  cursor: pointer; box-shadow: 4px 4px 0 var(--coral);
  transition: all 0.15s; margin-bottom: 16px;
}
.otp-submit-btn:hover { background: var(--coral); box-shadow: 4px 4px 0 var(--dark); }

.otp-legal { font-size: 0.78rem; color: var(--mid); font-weight: 600; text-align: center; }
.otp-legal a { color: var(--coral); font-weight: 800; }

/* OTP BOXES */
.otp-boxes { display: flex; gap: 12px; justify-content: center; margin-bottom: 16px; }
.otp-box {
  width: 58px; height: 58px; border: 2.5px solid var(--dark);
  border-radius: 14px; text-align: center; font-size: 1.5rem;
  font-weight: 800; font-family: 'Nunito', sans-serif;
  outline: none; transition: all 0.2s; background: var(--cream);
}
.otp-box:focus { border-color: var(--coral); background: white; box-shadow: 0 0 0 3px rgba(255,107,107,0.15); }
.otp-box.filled { border-color: var(--teal); background: #E8F8F5; }

.otp-demo-hint {
  text-align: center; font-size: 0.82rem; font-weight: 700;
  color: var(--mid); background: var(--cream);
  border: 2px dashed var(--gold); border-radius: 8px;
  padding: 8px 12px; margin-bottom: 20px;
}

.hidden { display: none !important; }

/* DASHBOARD MODAL */
.dashboard-modal {
  background: white; max-width: 520px; width: 100%;
  border: 3px solid var(--dark); border-radius: 28px;
  padding: 40px; box-shadow: 10px 10px 0 var(--dark);
  position: relative;
  transform: translateY(30px) scale(0.97);
  transition: transform 0.3s cubic-bezier(.34,1.56,.64,1);
}
.otp-overlay.open .dashboard-modal { transform: translateY(0) scale(1); }

.dash-header {
  display: flex; align-items: center; gap: 16px;
  margin-bottom: 28px; padding-bottom: 24px;
  border-bottom: 2.5px solid var(--cream);
}
.dash-avatar {
  width: 60px; height: 60px; border-radius: 50%;
  background: linear-gradient(135deg, #FFE8D6, #FFD6E8);
  border: 3px solid var(--dark); display: flex; align-items: center;
  justify-content: center; font-size: 1.8rem;
  box-shadow: 3px 3px 0 var(--dark); flex-shrink: 0;
}
.dash-welcome { font-size: 0.78rem; font-weight: 800; color: var(--mid); text-transform: uppercase; letter-spacing: 0.07em; }
.dash-name { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 900; }
.dash-phone { font-size: 0.85rem; font-weight: 700; color: var(--mid); }
.dash-badge { margin-left: auto; background: var(--gold); border: 2px solid var(--dark); border-radius: 50px; padding: 5px 14px; font-size: 0.78rem; font-weight: 800; box-shadow: 2px 2px 0 var(--dark); white-space: nowrap; }

.dash-cards { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 24px; }
.dash-card { border: 2.5px solid var(--dark); border-radius: 16px; padding: 16px 12px; text-align: center; box-shadow: 4px 4px 0 var(--dark); }
.dash-card-icon { font-size: 1.5rem; margin-bottom: 6px; }
.dash-card-val { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 900; color: var(--coral); }
.dash-card-label { font-size: 0.72rem; font-weight: 800; color: var(--mid); text-transform: uppercase; letter-spacing: 0.04em; margin-top: 2px; }

.dash-coupon {
  background: linear-gradient(135deg, #FFE8D6, #FFD6F5);
  border: 2.5px dashed var(--dark); border-radius: 16px;
  padding: 20px 24px; display: flex; align-items: center;
  gap: 16px; margin-bottom: 24px;
}
.coupon-label { font-size: 0.8rem; font-weight: 800; color: var(--mid); margin-bottom: 4px; }
.coupon-code { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 900; color: var(--coral); letter-spacing: 0.05em; flex: 1; }
.coupon-copy { padding: 8px 18px; background: var(--dark); color: white; border: none; border-radius: 50px; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 0.82rem; cursor: pointer; transition: all 0.15s; }
.coupon-copy:hover { background: var(--coral); }

.dash-actions { display: flex; gap: 12px; }
.dash-action-btn { flex: 1; padding: 13px; text-align: center; background: var(--coral); color: white; border: 2.5px solid var(--dark); border-radius: 50px; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 0.92rem; cursor: pointer; box-shadow: 4px 4px 0 var(--dark); transition: all 0.15s; text-decoration: none; display: flex; align-items: center; justify-content: center; }
.dash-action-btn:hover { transform: translate(-2px,-2px); box-shadow: 6px 6px 0 var(--dark); color: white; }
.dash-action-btn.secondary { background: white; color: var(--dark); }
.dash-action-btn.secondary:hover { background: var(--dark); color: white; }

@media(max-width:700px){
  .otp-modal{grid-template-columns:1fr;}
  .otp-left{display:none;}
  .dash-cards{grid-template-columns:1fr 1fr;}
}
</style>

<!-- ── SCRIPTS ── -->
<script>
// Simple in-memory user store (replace with real API calls in production)
let currentUser = JSON.parse(localStorage.getItem('stitchUser') || 'null');
let generatedOtp = '';
let enteredPhone = '';

// Auto-open dashboard if already logged in
window.addEventListener('load', () => {
  if (currentUser) showDashboard();
});

function openOtpModal() {
  document.getElementById('otpOverlay').classList.add('open');
  setTimeout(() => document.getElementById('phoneInput').focus(), 400);
}

function closeOtpModal() {
  document.getElementById('otpOverlay').classList.remove('open');
}

function closeIfOutside(e) {
  if (e.target.id === 'otpOverlay') closeOtpModal();
}

function sendOtp() {
  const phone = document.getElementById('phoneInput').value.trim();
  if (phone.length !== 10) { shakeInput('phoneInput'); return; }
  enteredPhone = phone;
  generatedOtp = '1234'; // In production: call your API to send real OTP via Twilio/MSG91
  document.getElementById('displayPhone').textContent = '+91 ' + phone;
  document.getElementById('stepPhone').classList.add('hidden');
  document.getElementById('stepOtp').classList.remove('hidden');
  setTimeout(() => document.getElementById('otp0').focus(), 100);
}

function otpInput(el, index) {
  el.value = el.value.replace(/\D/g,'');
  if (el.value) { el.classList.add('filled'); if (index < 3) document.getElementById('otp'+(index+1)).focus(); }
  else el.classList.remove('filled');
}

function getOtpValue() {
  return [0,1,2,3].map(i => document.getElementById('otp'+i).value).join('');
}

function verifyOtp() {
  const entered = getOtpValue();
  if (entered.length < 4) { [0,1,2,3].forEach(i => document.getElementById('otp'+i).style.borderColor='var(--coral)'); return; }
  if (entered === generatedOtp) {
    // Create user session
    currentUser = { phone: enteredPhone, name: 'Member', joined: new Date().toLocaleDateString(), orders: 0 };
    localStorage.setItem('stitchUser', JSON.stringify(currentUser));
    closeOtpModal();
    setTimeout(showDashboard, 300);
  } else {
    [0,1,2,3].forEach(i => { const b = document.getElementById('otp'+i); b.style.borderColor='var(--coral)'; b.style.background='#FFE8E8'; });
    setTimeout(() => [0,1,2,3].forEach(i => { document.getElementById('otp'+i).style.borderColor=''; document.getElementById('otp'+i).style.background=''; }), 1200);
  }
}

function resendOtp() { generatedOtp = '1234'; alert('OTP resent! (Demo: 1234)'); }
function goBackToPhone() { document.getElementById('stepOtp').classList.add('hidden'); document.getElementById('stepPhone').classList.remove('hidden'); }

function showDashboard() {
  if (!currentUser) return;
  document.getElementById('dashName').textContent = 'Member · ' + currentUser.phone.slice(0,4)+'XXXXXX';
  document.getElementById('dashPhone').textContent = '+91 ' + currentUser.phone;
  document.getElementById('dashOrders').textContent = currentUser.orders || 0;
  document.getElementById('dashSaved').textContent = '₹' + ((currentUser.orders || 0) * 45);
  document.getElementById('dashboardOverlay').classList.add('open');
  // Change trigger button to show user icon
  const btn = document.querySelector('.otp-trigger-btn');
  if (btn) { btn.innerHTML = '<span class="trigger-icon">👤</span><span class="trigger-text">My Account</span>'; btn.onclick = showDashboard; }
}

function closeDashboard() { document.getElementById('dashboardOverlay').classList.remove('open'); }
function closeDashIfOutside(e) { if (e.target.id === 'dashboardOverlay') closeDashboard(); }

function copyCoupon() {
  navigator.clipboard.writeText('STITCH10').then(() => {
    const btn = document.querySelector('.coupon-copy');
    btn.textContent = '✓ Copied!'; btn.style.background='var(--teal)';
    setTimeout(() => { btn.textContent='Copy Code'; btn.style.background=''; }, 2000);
  });
}

function logout() {
  localStorage.removeItem('stitchUser');
  currentUser = null;
  closeDashboard();
  const btn = document.querySelector('.otp-trigger-btn');
  if (btn) { btn.innerHTML = '<span class="trigger-icon">🧵</span><span class="trigger-text">Join & Get Offers</span>'; btn.onclick = openOtpModal; }
}

function shakeInput(id) {
  const el = document.getElementById(id);
  el.style.borderColor = 'var(--coral)';
  el.style.animation = 'shake 0.4s';
  setTimeout(() => { el.style.borderColor=''; el.style.animation=''; }, 500);
}
</script>

<style>
@keyframes shake {
  0%,100%{transform:translateX(0)} 25%{transform:translateX(-6px)} 75%{transform:translateX(6px)}
}
</style>
