{{-- resources/views/components/login-modal.blade.php
     Replaces otp-modal.blade.php
     Both navbar button AND footer button open THIS modal
--}}

{{-- ══ MODAL OVERLAY ══ --}}
<div class="lm-overlay" id="loginModalOverlay" onclick="closeLMIfOutside(event)">
  <div class="lm-modal" id="loginModal">

    {{-- LEFT PANEL --}}
    <div class="lm-left">
      <div class="lm-brand">🧵 Stitch <span>&</span> Bloom</div>
      <h2 class="lm-title">Welcome to<br><em>Stitch & Bloom!</em></h2>
      <p class="lm-sub">India's finest handmade embroidery, crafted with love in every stitch.</p>
      <div class="lm-perks">
        <div class="lm-perk"><span>🌸</span><div><b>Exclusive Member Offers</b><p>Early access to new collections & discounts</p></div></div>
        <div class="lm-perk"><span>🎁</span><div><b>First Order Bonus</b><p>Get 10% off your very first purchase</p></div></div>
        <div class="lm-perk"><span>✨</span><div><b>VIP Treatment</b><p>Track orders, save favourites & more</p></div></div>
      </div>
      <div class="lm-floaties">
        <span style="animation-delay:0s">🪡</span>
        <span style="animation-delay:0.4s">🌼</span>
        <span style="animation-delay:0.8s">💛</span>
      </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="lm-right">
      <button class="lm-close" onclick="closeLoginModal()">✕</button>

      {{-- STEP 1: Enter email or phone --}}
      <div class="lm-step" id="lmStep1">
        <div class="lm-step-tag">Step 1 of 2</div>
        <h3 class="lm-step-title">Login or Join</h3>
        <p class="lm-step-sub">Enter your email (admin) or phone number to continue.</p>

        <form id="lmIdentifierForm">
          @csrf
          <div class="lm-input-wrap" id="lmInputWrap">
            <input type="text" id="lmIdentifier" class="lm-input"
                   placeholder="Email or 10-digit phone number"
                   oninput="detectInputType(this)" />
          </div>
          <div class="lm-error" id="lmStep1Error"></div>
          <button type="button" class="lm-btn" id="lmStep1Btn" onclick="submitIdentifier()">
            Continue →
          </button>
        </form>

        <label class="lm-check-label">
          <input type="checkbox" id="lmOfferCheck" checked />
          <span class="lm-check-box"></span>
          Notify me with exclusive offers & updates
        </label>
        <p class="lm-legal">By continuing, I accept the <a href="#">Privacy Policy</a> and <a href="#">T&Cs</a>.</p>
      </div>

      {{-- STEP 2a: OTP for phone users --}}
      <div class="lm-step" id="lmStep2OTP" style="display:none;">
        <div class="lm-step-tag">Step 2 of 2</div>
        <h3 class="lm-step-title">Verify OTP 📱</h3>
        <p class="lm-step-sub">We sent a 6-digit code to <strong id="lmDisplayPhone"></strong></p>
        <div class="lm-otp-boxes">
          <input class="lm-otp-box" type="text" maxlength="1" id="lmOtp0" oninput="lmOtpInput(this,0)" onkeydown="lmOtpKey(this,0,event)" />
          <input class="lm-otp-box" type="text" maxlength="1" id="lmOtp1" oninput="lmOtpInput(this,1)" onkeydown="lmOtpKey(this,1,event)" />
          <input class="lm-otp-box" type="text" maxlength="1" id="lmOtp2" oninput="lmOtpInput(this,2)" onkeydown="lmOtpKey(this,2,event)" />
          <input class="lm-otp-box" type="text" maxlength="1" id="lmOtp3" oninput="lmOtpInput(this,3)" onkeydown="lmOtpKey(this,3,event)" />
          <input class="lm-otp-box" type="text" maxlength="1" id="lmOtp4" oninput="lmOtpInput(this,4)" onkeydown="lmOtpKey(this,4,event)" />
          <input class="lm-otp-box" type="text" maxlength="1" id="lmOtp5" oninput="lmOtpInput(this,5)" onkeydown="lmOtpKey(this,5,event)" />
        </div>
        <div class="lm-error" id="lmOtpError"></div>
        <button type="button" class="lm-btn" onclick="submitOtp()">Verify & Login →</button>
        <p class="lm-legal" style="margin-top:12px;">
          Didn't get it? <a href="#" onclick="resendOtp(); return false;">Resend OTP</a> &nbsp;|&nbsp;
          <a href="#" onclick="goBackToStep1(); return false;">Change Number</a>
        </p>
      </div>

      {{-- STEP 2b: Password for email/admin users --}}
      <div class="lm-step" id="lmStep2Pass" style="display:none;">
        <div class="lm-step-tag">Step 2 of 2</div>
        <h3 class="lm-step-title">Enter Password 🔐</h3>
        <p class="lm-step-sub">Logging in as <strong id="lmDisplayEmail"></strong></p>
        <input type="password" id="lmPassword" class="lm-input" placeholder="Your password" style="margin-bottom:16px;" />
        <div class="lm-error" id="lmPassError"></div>
        <label class="lm-check-label" style="margin-bottom:16px;">
          <input type="checkbox" id="lmRemember" />
          <span class="lm-check-box"></span>
          Keep me logged in
        </label>
        <button type="button" class="lm-btn" onclick="submitPassword()">Login →</button>
        <p class="lm-legal" style="margin-top:12px;">
          <a href="#" onclick="goBackToStep1(); return false;">← Use different email</a>
        </p>
      </div>

      {{-- Loading state --}}
      <div class="lm-loading" id="lmLoading" style="display:none;">
        <div class="lm-spinner"></div>
        <p>Please wait...</p>
      </div>

    </div>
  </div>
</div>

{{-- ══ STYLES ══ --}}
<style>
.lm-overlay {
  position: fixed; inset: 0; z-index: 1000;
  background: rgba(0,0,0,0.55); backdrop-filter: blur(3px);
  display: flex; align-items: center; justify-content: center;
  padding: 20px; opacity: 0; pointer-events: none;
  transition: opacity 0.3s;
}
.lm-overlay.open { opacity: 1; pointer-events: all; }

.lm-modal {
  display: grid; grid-template-columns: 1fr 1fr;
  max-width: 820px; width: 100%;
  border: 3px solid var(--dark); border-radius: 28px;
  overflow: hidden; box-shadow: 10px 10px 0 var(--dark);
  transform: translateY(30px) scale(0.97);
  transition: transform 0.3s cubic-bezier(.34,1.56,.64,1);
  max-height: 92vh; overflow-y: auto;
  background: white;
}
.lm-overlay.open .lm-modal { transform: translateY(0) scale(1); }

/* LEFT */
.lm-left {
  background: linear-gradient(145deg, #FFE8D6 0%, #FFD6E8 50%, #E8D6FF 100%);
  padding: 44px 32px; position: relative; overflow: hidden;
}
.lm-brand { font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 900; margin-bottom: 24px; }
.lm-brand span { color: var(--coral); }
.lm-title { font-family: 'Playfair Display', serif; font-size: 1.9rem; font-weight: 900; line-height: 1.15; margin-bottom: 12px; }
.lm-title em { font-style: normal; color: var(--coral); }
.lm-sub { color: var(--mid); font-weight: 600; font-size: 0.9rem; line-height: 1.6; margin-bottom: 28px; }
.lm-perks { display: flex; flex-direction: column; gap: 14px; }
.lm-perk { display: flex; align-items: flex-start; gap: 12px; font-size: 1.4rem; }
.lm-perk div b { display: block; font-size: 0.88rem; font-weight: 800; margin-bottom: 2px; }
.lm-perk div p { font-size: 0.77rem; color: var(--mid); font-weight: 600; margin: 0; }
.lm-floaties { position: absolute; bottom: 20px; right: 20px; display: flex; gap: 8px; }
.lm-floaties span { font-size: 1.8rem; animation: lmFloat 3s ease-in-out infinite; display: inline-block; }
@keyframes lmFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }

/* RIGHT */
.lm-right { background: white; padding: 44px 36px; position: relative; min-height: 420px; }
.lm-close {
  position: absolute; top: 14px; right: 16px;
  width: 30px; height: 30px; border-radius: 50%;
  border: 2px solid var(--dark); background: var(--cream);
  font-size: 0.82rem; font-weight: 800; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: all 0.15s;
}
.lm-close:hover { background: var(--dark); color: white; }

.lm-step-tag { font-size: 0.73rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--teal); margin-bottom: 12px; }
.lm-step-title { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 900; margin-bottom: 6px; }
.lm-step-sub { color: var(--mid); font-weight: 600; font-size: 0.88rem; margin-bottom: 24px; line-height: 1.5; }

.lm-input-wrap { margin-bottom: 6px; }
.lm-input {
  width: 100%; padding: 14px 16px;
  border: 2.5px solid var(--dark); border-radius: 14px;
  font-family: 'Nunito', sans-serif; font-size: 1rem; font-weight: 600;
  background: var(--cream); outline: none; transition: all 0.2s;
}
.lm-input:focus { border-color: var(--coral); background: white; }

.lm-input-type-hint {
  font-size: 0.78rem; font-weight: 700; margin-bottom: 14px;
  padding: 5px 10px; border-radius: 6px; display: inline-block;
}
.hint-phone { background: #E8F8F5; color: #2D7A6B; }
.hint-email { background: #F5E8FF; color: #6B2D7A; }

.lm-btn {
  width: 100%; padding: 15px;
  background: var(--dark); color: white;
  border: 3px solid var(--dark); border-radius: 50px;
  font-family: 'Nunito', sans-serif; font-size: 1rem; font-weight: 800;
  cursor: pointer; box-shadow: 4px 4px 0 var(--coral);
  transition: all 0.15s; margin-bottom: 16px; margin-top: 8px;
}
.lm-btn:hover { background: var(--coral); box-shadow: 4px 4px 0 var(--dark); }
.lm-btn:disabled { opacity: 0.6; cursor: not-allowed; }

.lm-error {
  color: var(--coral); font-size: 0.82rem; font-weight: 700;
  min-height: 20px; margin-bottom: 4px;
}

/* OTP BOXES */
.lm-otp-boxes { display: flex; gap: 8px; justify-content: center; margin-bottom: 8px; }
.lm-otp-box {
  width: 46px; height: 52px; border: 2.5px solid var(--dark);
  border-radius: 12px; text-align: center; font-size: 1.3rem;
  font-weight: 800; font-family: 'Nunito', sans-serif;
  outline: none; transition: all 0.2s; background: var(--cream);
}
.lm-otp-box:focus { border-color: var(--coral); background: white; box-shadow: 0 0 0 3px rgba(255,107,107,0.12); }
.lm-otp-box.filled { border-color: var(--teal); background: #E8F8F5; }

/* CHECKBOX */
.lm-check-label { display: flex; align-items: center; gap: 8px; font-size: 0.82rem; font-weight: 700; cursor: pointer; margin-bottom: 20px; color: var(--mid); }
.lm-check-label input { display: none; }
.lm-check-box { width: 17px; height: 17px; border: 2px solid var(--dark); border-radius: 4px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: white; transition: all 0.15s; }
.lm-check-label input:checked + .lm-check-box { background: var(--teal); border-color: var(--teal); }
.lm-check-label input:checked + .lm-check-box::after { content: '✓'; color: white; font-size: 0.72rem; font-weight: 900; }

.lm-legal { font-size: 0.76rem; color: var(--mid); font-weight: 600; text-align: center; }
.lm-legal a { color: var(--coral); font-weight: 800; text-decoration: none; }

/* LOADING */
.lm-loading { text-align: center; padding: 40px 20px; }
.lm-spinner { width: 40px; height: 40px; border: 4px solid var(--cream); border-top-color: var(--coral); border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto 16px; }
@keyframes spin { to { transform: rotate(360deg); } }

@media(max-width:700px){
  .lm-modal { grid-template-columns: 1fr; }
  .lm-left { display: none; }
  .lm-otp-boxes { gap: 6px; }
  .lm-otp-box { width: 40px; height: 46px; font-size: 1.1rem; }
}
</style>

{{-- ══ SCRIPTS ══ --}}
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ── Open / Close ──
function openLoginModal() {
  document.getElementById('loginModalOverlay').classList.add('open');
  setTimeout(() => document.getElementById('lmIdentifier')?.focus(), 350);
}

function closeLoginModal() {
  document.getElementById('loginModalOverlay').classList.remove('open');
}

function closeLMIfOutside(e) {
  if (e.target.id === 'loginModalOverlay') closeLoginModal();
}

// ── Detect phone vs email as user types ──
function detectInputType(input) {
  const val = input.value.trim();
  const existing = document.getElementById('lmTypeHint');
  if (existing) existing.remove();

  if (!val) return;

  const isPhone = /^[0-9]+$/.test(val);
  const isEmail = val.includes('@');
  const hint = document.createElement('div');
  hint.id = 'lmTypeHint';
  hint.className = 'lm-input-type-hint ' + (isPhone ? 'hint-phone' : isEmail ? 'hint-email' : '');
  hint.textContent = isPhone ? '📱 Phone login — OTP will be sent' : isEmail ? '📧 Email login — Password required' : '';
  if (hint.textContent) input.parentNode.after(hint);
}

// ── STEP 1: Submit identifier ──
function submitIdentifier() {
  const identifier = document.getElementById('lmIdentifier').value.trim();
  const errEl = document.getElementById('lmStep1Error');
  errEl.textContent = '';

  if (!identifier) { errEl.textContent = 'Please enter your email or phone number.'; return; }

  showLoading();

  fetch('/auth/submit', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
    body: JSON.stringify({ identifier })
  })
  .then(r => r.json())
  .then(data => {
    hideLoading();
    if (data.step === 'otp') {
      document.getElementById('lmDisplayPhone').textContent = '+91 ' + identifier;
      if (data.dev_otp) {
        const hint = document.createElement('div');
        hint.style.cssText = 'background:#FFFDE8;border:2px dashed var(--gold);border-radius:8px;padding:8px 12px;margin-bottom:12px;font-size:0.82rem;font-weight:700;text-align:center;';
        hint.innerHTML = '🛠 Dev Mode OTP: <strong>' + data.dev_otp + '</strong>';
        document.getElementById('lmStep2OTP').insertBefore(hint, document.querySelector('.lm-otp-boxes'));
      }
      showStep('lmStep2OTP');
      setTimeout(() => document.getElementById('lmOtp0').focus(), 100);
    } else if (data.step === 'password') {
      document.getElementById('lmDisplayEmail').textContent = identifier;
      showStep('lmStep2Pass');
      setTimeout(() => document.getElementById('lmPassword').focus(), 100);
    } else if (data.error) {
      errEl.textContent = data.error;
    }
  })
  .catch(() => { hideLoading(); errEl.textContent = 'Something went wrong. Please try again.'; });
}

// ── STEP 2b: Submit password ──
function submitPassword() {
  const password = document.getElementById('lmPassword').value;
  const remember = document.getElementById('lmRemember').checked;
  const errEl = document.getElementById('lmPassError');
  errEl.textContent = '';
  if (!password) { errEl.textContent = 'Please enter your password.'; return; }

  showLoading();

  fetch('/auth/password', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
    body: JSON.stringify({ password, remember })
  })
  .then(r => r.json())
  .then(data => {
    hideLoading();
    if (data.redirect) { window.location.href = data.redirect; }
    else if (data.error) { errEl.textContent = data.error; }
  })
  .catch(() => { hideLoading(); errEl.textContent = 'Something went wrong. Please try again.'; });
}

// ── STEP 2a: Submit OTP ──
function submitOtp() {
  const otp = [0,1,2,3,4,5].map(i => document.getElementById('lmOtp'+i).value).join('');
  const errEl = document.getElementById('lmOtpError');
  errEl.textContent = '';
  if (otp.length < 6) { errEl.textContent = 'Please enter all 6 digits.'; return; }

  showLoading();

  fetch('/auth/otp', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
    body: JSON.stringify({ otp })
  })
  .then(r => r.json())
  .then(data => {
    hideLoading();
    if (data.redirect) { window.location.href = data.redirect; }
    else if (data.error) {
      errEl.textContent = data.error;
      [0,1,2,3,4,5].forEach(i => { const b = document.getElementById('lmOtp'+i); b.style.borderColor='var(--coral)'; b.style.background='#FFE8E8'; });
      setTimeout(() => [0,1,2,3,4,5].forEach(i => { document.getElementById('lmOtp'+i).style.borderColor=''; document.getElementById('lmOtp'+i).style.background=''; }), 1200);
    }
  })
  .catch(() => { hideLoading(); errEl.textContent = 'Something went wrong. Please try again.'; });
}

// ── Resend OTP ──
function resendOtp() {
  fetch('/auth/resend', { method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } })
  .then(r => r.json())
  .then(data => { document.getElementById('lmOtpError').textContent = data.message || 'OTP resent!'; });
}

// ── OTP box helpers ──
function lmOtpInput(el, i) {
  el.value = el.value.replace(/\D/g,'');
  if (el.value) { el.classList.add('filled'); if (i < 5) document.getElementById('lmOtp'+(i+1)).focus(); }
  else el.classList.remove('filled');
  // Auto submit when all filled
  const otp = [0,1,2,3,4,5].map(j => document.getElementById('lmOtp'+j).value).join('');
  if (otp.length === 6) submitOtp();
}

function lmOtpKey(el, i, e) {
  if (e.key === 'Backspace' && !el.value && i > 0) document.getElementById('lmOtp'+(i-1)).focus();
}

// ── Navigation helpers ──
function goBackToStep1() {
  showStep('lmStep1');
  document.getElementById('lmIdentifier').focus();
}

function showStep(stepId) {
  ['lmStep1','lmStep2OTP','lmStep2Pass','lmLoading'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.style.display = 'none';
  });
  document.getElementById(stepId).style.display = 'block';
}

function showLoading() { showStep('lmLoading'); }
function hideLoading() {
  document.getElementById('lmLoading').style.display = 'none';
}

// ── Keyboard: Enter key submits ──
document.addEventListener('keydown', e => {
  if (e.key !== 'Enter') return;
  if (document.getElementById('lmStep1').style.display !== 'none' && !document.getElementById('lmStep1').style.display || document.getElementById('lmStep1').offsetParent) submitIdentifier();
});
</script>
