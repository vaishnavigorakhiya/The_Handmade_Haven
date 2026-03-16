{{-- resources/views/auth/login.blade.php --}}
<div class="lm-overlay" id="loginModalOverlay" onclick="closeLMIfOutside(event)">
  <div class="lm-modal" id="loginModal">

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
        <span style="animation-delay:.4s">🌼</span>
        <span style="animation-delay:.8s">💛</span>
      </div>
    </div>

    <div class="lm-right">
      <button class="lm-close" onclick="closeLoginModal()" type="button">✕</button>

      {{-- STEP 1 --}}
      <div class="lm-step" id="lmStep1">
        <div class="lm-step-tag">Step 1 of 2</div>
        <h3 class="lm-step-title">Login or Join</h3>
        <p class="lm-step-sub">Enter your email or phone number to continue.</p>
        <div class="lm-field-wrap">
          <input type="text" id="lmIdentifier" class="lm-input"
                 placeholder="Email or phone number"
                 autocomplete="username" />
          <div class="lm-ferr" id="lmIdentifierErr"></div>
        </div>
        <div class="lm-error" id="lmStep1Err"></div>
        <button type="button" class="lm-btn" onclick="lmSubmitStep1()">Continue →</button>
        <label class="lm-check-label">
          <input type="checkbox" id="lmOfferCheck" checked />
          <span class="lm-check-box"></span>
          Notify me with exclusive offers & updates
        </label>
        <p class="lm-legal">By continuing, I accept the <a href="#">Privacy Policy</a> and <a href="#">T&Cs</a>.</p>
      </div>

      {{-- STEP 2a: OTP --}}
      <div class="lm-step" id="lmStep2OTP" style="display:none;">
        <div class="lm-step-tag">Step 2 of 2</div>
        <h3 class="lm-step-title">Verify OTP 📱</h3>
        <p class="lm-step-sub">Enter the 6-digit code sent to <strong id="lmPhoneLabel"></strong></p>
        <div class="lm-otp-row" id="lmOtpBoxes">
          <input class="lm-otp-box" type="text" maxlength="1" id="lmOtp0" oninput="lmOtpIn(this,0)" onkeydown="lmOtpKey(this,0,event)" />
          <input class="lm-otp-box" type="text" maxlength="1" id="lmOtp1" oninput="lmOtpIn(this,1)" onkeydown="lmOtpKey(this,1,event)" />
          <input class="lm-otp-box" type="text" maxlength="1" id="lmOtp2" oninput="lmOtpIn(this,2)" onkeydown="lmOtpKey(this,2,event)" />
          <input class="lm-otp-box" type="text" maxlength="1" id="lmOtp3" oninput="lmOtpIn(this,3)" onkeydown="lmOtpKey(this,3,event)" />
          <input class="lm-otp-box" type="text" maxlength="1" id="lmOtp4" oninput="lmOtpIn(this,4)" onkeydown="lmOtpKey(this,4,event)" />
          <input class="lm-otp-box" type="text" maxlength="1" id="lmOtp5" oninput="lmOtpIn(this,5)" onkeydown="lmOtpKey(this,5,event)" />
        </div>
        <div class="lm-error" id="lmOtpErr"></div>
        <button type="button" class="lm-btn" onclick="lmSubmitOtp()">Verify & Login →</button>
        <p class="lm-legal" style="margin-top:10px;">
          Didn't receive it? <a href="#" onclick="lmResend();return false;">Resend OTP</a>
          &nbsp;·&nbsp; <a href="#" onclick="lmBack();return false;">Change number</a>
        </p>
      </div>

      {{-- STEP 2b: Password --}}
      <div class="lm-step" id="lmStep2Pass" style="display:none;">
        <div class="lm-step-tag">Step 2 of 2</div>
        <h3 class="lm-step-title">Enter Password 🔐</h3>
        <p class="lm-step-sub">Welcome back, <strong id="lmEmailLabel"></strong></p>
        <div class="lm-field-wrap">
          <div class="lm-pass-wrap">
            <input type="password" id="lmPassword" class="lm-input" placeholder="Your password" autocomplete="current-password" />
            <button type="button" class="lm-eye" onclick="lmToggleEye('lmPassword',this)">👁</button>
          </div>
          <div class="lm-ferr" id="lmPasswordErr"></div>
        </div>
        <div class="lm-error" id="lmPassErr"></div>
        <label class="lm-check-label" style="margin-bottom:14px;">
          <input type="checkbox" id="lmRemember" />
          <span class="lm-check-box"></span>
          Keep me logged in
        </label>
        <button type="button" class="lm-btn" onclick="lmSubmitPass()">Login →</button>
        <p class="lm-legal" style="margin-top:10px;"><a href="#" onclick="lmBack();return false;">← Use different email</a></p>
      </div>

      {{-- STEP 2c: Register --}}
      <div class="lm-step" id="lmStep2Reg" style="display:none;">
        <div class="lm-step-tag">New Account</div>
        <h3 class="lm-step-title">Create Account ✨</h3>
        <p class="lm-step-sub">Creating account for <strong id="lmRegEmailLabel"></strong></p>
        <div class="lm-field-wrap">
          <label class="lm-field-label">Full Name</label>
          <input type="text" id="lmRegName" class="lm-input" placeholder="Your full name" autocomplete="name" />
          <div class="lm-ferr" id="lmRegNameErr"></div>
        </div>
        <div class="lm-field-wrap">
          <label class="lm-field-label">Password</label>
          <div class="lm-pass-wrap">
            <input type="password" id="lmRegPass" class="lm-input" placeholder="Minimum 8 characters" autocomplete="new-password" oninput="lmStrength(this.value)" />
            <button type="button" class="lm-eye" onclick="lmToggleEye('lmRegPass',this)">👁</button>
          </div>
          <div class="lm-strength-bar" id="lmStrengthBar" style="display:none;">
            <div id="lmStrengthFill"></div>
          </div>
          <div class="lm-ferr" id="lmRegPassErr"></div>
        </div>
        <div class="lm-field-wrap">
          <label class="lm-field-label">Confirm Password</label>
          <div class="lm-pass-wrap">
            <input type="password" id="lmRegConfirm" class="lm-input" placeholder="Repeat your password" autocomplete="new-password" />
            <button type="button" class="lm-eye" onclick="lmToggleEye('lmRegConfirm',this)">👁</button>
          </div>
          <div class="lm-ferr" id="lmRegConfirmErr"></div>
        </div>
        <label class="lm-check-label" style="margin-bottom:4px;">
          <input type="checkbox" id="lmTerms" />
          <span class="lm-check-box"></span>
          I accept the <a href="#" style="color:var(--coral);font-weight:800;">Terms & Conditions</a>
        </label>
        <div class="lm-ferr" id="lmTermsErr"></div>
        <div class="lm-error" id="lmRegErr"></div>
        <button type="button" class="lm-btn" style="margin-top:12px;" onclick="lmSubmitReg()">Create Account →</button>
        <p class="lm-legal" style="margin-top:10px;">Already registered? <a href="#" onclick="lmBack();return false;">Login instead</a></p>
      </div>

      {{-- Loading --}}
      <div class="lm-loading" id="lmLoading" style="display:none;">
        <div class="lm-spinner"></div>
        <p>Please wait…</p>
      </div>
    </div>
  </div>
</div>

<style>
.lm-overlay{position:fixed;inset:0;z-index:1000;background:rgba(0,0,0,.55);backdrop-filter:blur(3px);display:flex;align-items:center;justify-content:center;padding:16px;opacity:0;pointer-events:none;transition:opacity .3s;}
.lm-overlay.open{opacity:1;pointer-events:all;}
.lm-modal{display:grid;grid-template-columns:1fr 1fr;max-width:820px;width:100%;border:3px solid var(--dark);border-radius:28px;overflow:hidden;box-shadow:10px 10px 0 var(--dark);transform:translateY(30px) scale(.97);transition:transform .3s cubic-bezier(.34,1.56,.64,1);max-height:92vh;overflow-y:auto;background:white;}
.lm-overlay.open .lm-modal{transform:translateY(0) scale(1);}
/* Left */
.lm-left{background:linear-gradient(145deg,#FFE8D6 0%,#FFD6E8 50%,#E8D6FF 100%);padding:44px 32px;position:relative;overflow:hidden;}
.lm-brand{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:900;margin-bottom:24px;}
.lm-brand span{color:var(--coral);}
.lm-title{font-family:'Playfair Display',serif;font-size:1.9rem;font-weight:900;line-height:1.15;margin-bottom:12px;}
.lm-title em{font-style:normal;color:var(--coral);}
.lm-sub{color:var(--mid);font-weight:600;font-size:.9rem;line-height:1.6;margin-bottom:28px;}
.lm-perks{display:flex;flex-direction:column;gap:14px;}
.lm-perk{display:flex;align-items:flex-start;gap:12px;font-size:1.4rem;}
.lm-perk div b{display:block;font-size:.88rem;font-weight:800;margin-bottom:2px;}
.lm-perk div p{font-size:.77rem;color:var(--mid);font-weight:600;margin:0;}
.lm-floaties{position:absolute;bottom:20px;right:20px;display:flex;gap:8px;}
.lm-floaties span{font-size:1.8rem;animation:lmFloat 3s ease-in-out infinite;display:inline-block;}
@keyframes lmFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
/* Right */
.lm-right{background:white;padding:44px 36px;position:relative;min-height:400px;}
.lm-close{position:absolute;top:14px;right:16px;width:30px;height:30px;border-radius:50%;border:2px solid var(--dark);background:var(--cream);font-size:.82rem;font-weight:800;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .15s;z-index:10;}
.lm-close:hover{background:var(--dark);color:white;}
.lm-step-tag{font-size:.73rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:var(--teal);margin-bottom:12px;}
.lm-step-title{font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:900;margin-bottom:6px;}
.lm-step-sub{color:var(--mid);font-weight:600;font-size:.88rem;margin-bottom:20px;line-height:1.5;}
/* Fields */
.lm-field-wrap{margin-bottom:12px;}
.lm-field-label{display:block;font-size:.75rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:var(--mid);margin-bottom:5px;}
.lm-input{width:100%;padding:13px 16px;border:2.5px solid var(--dark);border-radius:14px;font-family:'Nunito',sans-serif;font-size:1rem;font-weight:600;background:var(--cream);outline:none;transition:all .2s;}
.lm-input:focus{border-color:var(--coral);background:white;}
.lm-input.err{border-color:var(--coral)!important;background:#fff5f5;}
.lm-input.ok{border-color:var(--teal)!important;}
.lm-ferr{font-size:.77rem;font-weight:700;color:var(--coral);min-height:17px;margin-top:4px;}
.lm-ferr:not(:empty)::before{content:'⚠ ';}
.lm-error{font-size:.82rem;font-weight:700;color:var(--coral);min-height:18px;margin-bottom:6px;}
.lm-error:not(:empty){background:#fff0f0;border:1.5px solid var(--coral);border-radius:8px;padding:8px 12px;margin-bottom:10px;}
/* Pass wrap */
.lm-pass-wrap{position:relative;}
.lm-pass-wrap .lm-input{padding-right:46px;}
.lm-eye{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:1rem;opacity:.55;transition:opacity .15s;}
.lm-eye:hover{opacity:1;}
/* Strength */
.lm-strength-bar{height:5px;background:var(--cream);border-radius:3px;overflow:hidden;border:1.5px solid var(--dark);margin-top:6px;}
.lm-strength-bar div{height:100%;border-radius:3px;transition:width .3s,background .3s;}
/* OTP */
.lm-otp-row{display:flex;gap:8px;justify-content:center;margin-bottom:8px;flex-wrap:wrap;}
.lm-otp-box{width:45px;height:51px;border:2.5px solid var(--dark);border-radius:12px;text-align:center;font-size:1.3rem;font-weight:800;font-family:'Nunito',sans-serif;outline:none;transition:all .2s;background:var(--cream);}
.lm-otp-box:focus{border-color:var(--coral);background:white;box-shadow:0 0 0 3px rgba(255,107,107,.12);}
.lm-otp-box.filled{border-color:var(--teal);background:#E8F8F5;}
.lm-otp-box.shake{animation:lmShake .4s;}
@keyframes lmShake{0%,100%{transform:translateX(0)}25%{transform:translateX(-4px)}75%{transform:translateX(4px)}}
/* Button */
.lm-btn{width:100%;padding:15px;background:var(--dark);color:white;border:3px solid var(--dark);border-radius:50px;font-family:'Nunito',sans-serif;font-size:1rem;font-weight:800;cursor:pointer;box-shadow:4px 4px 0 var(--coral);transition:all .15s;margin-bottom:14px;margin-top:6px;}
.lm-btn:hover{background:var(--coral);box-shadow:4px 4px 0 var(--dark);}
/* Checkbox */
.lm-check-label{display:flex;align-items:center;gap:8px;font-size:.82rem;font-weight:700;cursor:pointer;margin-bottom:16px;color:var(--mid);}
.lm-check-label input{display:none;}
.lm-check-box{width:17px;height:17px;border:2px solid var(--dark);border-radius:4px;flex-shrink:0;display:flex;align-items:center;justify-content:center;background:white;transition:all .15s;}
.lm-check-label input:checked+.lm-check-box{background:var(--teal);border-color:var(--teal);}
.lm-check-label input:checked+.lm-check-box::after{content:'✓';color:white;font-size:.72rem;font-weight:900;}
.lm-legal{font-size:.76rem;color:var(--mid);font-weight:600;text-align:center;}
.lm-legal a{color:var(--coral);font-weight:800;text-decoration:none;}
/* Loading */
.lm-loading{text-align:center;padding:40px 20px;}
.lm-spinner{width:40px;height:40px;border:4px solid var(--cream);border-top-color:var(--coral);border-radius:50%;animation:lmSpin .8s linear infinite;margin:0 auto 16px;}
@keyframes lmSpin{to{transform:rotate(360deg)}}
/* Mobile */
@media(max-width:700px){.lm-modal{grid-template-columns:1fr;max-height:95vh;}.lm-left{display:none;}.lm-right{padding:36px 22px;}.lm-otp-box{width:38px;height:44px;font-size:1.1rem;}}
</style>

<script>
(function(){
const CSRF=()=>document.querySelector('meta[name="csrf-token"]').getAttribute('content');

window.openLoginModal=function(){
  document.getElementById('loginModalOverlay').classList.add('open');
  setTimeout(()=>document.getElementById('lmIdentifier')?.focus(),350);
};
window.closeLoginModal=function(){
  document.getElementById('loginModalOverlay').classList.remove('open');
};
window.closeLMIfOutside=function(e){if(e.target.id==='loginModalOverlay')closeLoginModal();};

function showStep(id){
  ['lmStep1','lmStep2OTP','lmStep2Pass','lmStep2Reg','lmLoading'].forEach(s=>{
    const el=document.getElementById(s); if(el)el.style.display='none';
  });
  const t=document.getElementById(id); if(t)t.style.display='block';
}
function showLoad(){showStep('lmLoading');}
function hideLoad(){document.getElementById('lmLoading').style.display='none';}

window.lmBack=function(){
  showStep('lmStep1');
  clearAllErrs();
  setTimeout(()=>document.getElementById('lmIdentifier')?.focus(),100);
};

function setErr(id,eid,msg){const el=document.getElementById(id);const em=document.getElementById(eid);if(el)el.classList.add('err');if(em)em.textContent=msg;}
function clrErr(id,eid){const el=document.getElementById(id);const em=document.getElementById(eid);if(el){el.classList.remove('err');el.classList.add('ok');}if(em)em.textContent='';}
function clearAllErrs(){
  document.querySelectorAll('.lm-input').forEach(el=>el.classList.remove('err','ok'));
  document.querySelectorAll('.lm-ferr,.lm-error').forEach(el=>el.textContent='');
}

/* STEP 1 */
window.lmSubmitStep1=function(){
  const val=(document.getElementById('lmIdentifier').value||'').trim();
  document.getElementById('lmStep1Err').textContent='';
  clearAllErrs();
  if(!val){setErr('lmIdentifier','lmIdentifierErr','Please enter your email or phone number.');document.getElementById('lmIdentifier').focus();return;}
  const isPhone=/^[0-9]{10,15}$/.test(val.replace(/\D/g,''));
  const isEmail=/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
  if(!isPhone&&!isEmail){setErr('lmIdentifier','lmIdentifierErr','Please enter a valid email or 10-digit phone number.');document.getElementById('lmIdentifier').focus();return;}
  clrErr('lmIdentifier','lmIdentifierErr');
  showLoad();
  fetch('/auth/submit',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF(),'Accept':'application/json'},body:JSON.stringify({identifier:val})})
  .then(r=>r.json()).then(data=>{
    hideLoad();
    if(data.step==='otp'){
      document.getElementById('lmPhoneLabel').textContent=val;
      document.querySelectorAll('.lm-dev-otp').forEach(e=>e.remove());
      if(data.dev_otp){
        const h=document.createElement('div');h.className='lm-dev-otp';
        h.style.cssText='background:#FFFDE8;border:2px dashed #FFB347;border-radius:8px;padding:7px 12px;margin-bottom:10px;font-size:.82rem;font-weight:700;text-align:center;';
        h.innerHTML='🛠 Dev OTP: <strong>'+data.dev_otp+'</strong>';
        document.getElementById('lmOtpBoxes').before(h);
      }
      showStep('lmStep2OTP');
      setTimeout(()=>document.getElementById('lmOtp0').focus(),100);
    } else if(data.step==='password'){
      document.getElementById('lmEmailLabel').textContent=val;
      showStep('lmStep2Pass');
      setTimeout(()=>document.getElementById('lmPassword').focus(),100);
    } else if(data.step==='register'){
      document.getElementById('lmRegEmailLabel').textContent=val;
      showStep('lmStep2Reg');
      setTimeout(()=>document.getElementById('lmRegName').focus(),100);
    } else if(data.error){
      document.getElementById('lmStep1Err').textContent=data.error;
      setErr('lmIdentifier','lmIdentifierErr',data.error);
    }
  }).catch(()=>{hideLoad();document.getElementById('lmStep1Err').textContent='Something went wrong. Please try again.';});
};

/* STEP 2b: Password */
window.lmSubmitPass=function(){
  const pw=(document.getElementById('lmPassword').value||'');
  document.getElementById('lmPassErr').textContent=''; clrErr('lmPassword','lmPasswordErr');
  if(!pw){setErr('lmPassword','lmPasswordErr','Password cannot be empty.');document.getElementById('lmPassword').focus();return;}
  showLoad();
  fetch('/auth/password',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF(),'Accept':'application/json'},body:JSON.stringify({password:pw,remember:document.getElementById('lmRemember').checked})})
  .then(r=>r.json()).then(data=>{
    hideLoad();
    if(data.redirect)window.location.href=data.redirect;
    else if(data.error){document.getElementById('lmPassErr').textContent=data.error;setErr('lmPassword','lmPasswordErr',data.error);}
  }).catch(()=>{hideLoad();document.getElementById('lmPassErr').textContent='Something went wrong.';});
};

/* STEP 2a: OTP */
window.lmSubmitOtp=function(){
  const otp=[0,1,2,3,4,5].map(i=>(document.getElementById('lmOtp'+i).value||'')).join('');
  const err=document.getElementById('lmOtpErr'); err.textContent='';
  if(otp.length<6){
    err.textContent='Please enter all 6 digits.';
    [0,1,2,3,4,5].forEach(i=>{const b=document.getElementById('lmOtp'+i);b.classList.add('shake');setTimeout(()=>b.classList.remove('shake'),500);});
    document.getElementById('lmOtp0').focus(); return;
  }
  showLoad();
  fetch('/auth/otp',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF(),'Accept':'application/json'},body:JSON.stringify({otp})})
  .then(r=>r.json()).then(data=>{
    hideLoad();
    if(data.redirect)window.location.href=data.redirect;
    else if(data.error){
      err.textContent=data.error;
      [0,1,2,3,4,5].forEach(i=>{const b=document.getElementById('lmOtp'+i);b.classList.add('shake');b.value='';setTimeout(()=>b.classList.remove('shake'),500);});
      setTimeout(()=>document.getElementById('lmOtp0').focus(),200);
    }
  }).catch(()=>{hideLoad();err.textContent='Something went wrong.';});
};

window.lmResend=function(){
  fetch('/auth/resend',{method:'POST',headers:{'X-CSRF-TOKEN':CSRF(),'Accept':'application/json'}})
  .then(r=>r.json()).then(data=>{
    const e=document.getElementById('lmOtpErr');
    e.style.color='var(--teal)';e.textContent=data.message||'OTP resent!';
    setTimeout(()=>{e.textContent='';e.style.color='';},4000);
  });
};

window.lmOtpIn=function(el,i){
  el.value=el.value.replace(/\D/g,'');
  if(el.value){el.classList.add('filled');if(i<5)document.getElementById('lmOtp'+(i+1)).focus();}
  else el.classList.remove('filled');
};
window.lmOtpKey=function(el,i,e){
  if(e.key==='Backspace'&&!el.value&&i>0)document.getElementById('lmOtp'+(i-1)).focus();
  if(e.key==='Enter')lmSubmitOtp();
};

/* STEP 2c: Register */
window.lmSubmitReg=function(){
  let ok=true;
  clearAllErrs();
  const nm=(document.getElementById('lmRegName').value||'').trim();
  const pw=(document.getElementById('lmRegPass').value||'');
  const cf=(document.getElementById('lmRegConfirm').value||'');
  const tm=document.getElementById('lmTerms').checked;
  const em=(document.getElementById('lmRegEmailLabel').textContent||'').trim();
  document.getElementById('lmRegErr').textContent='';
  document.getElementById('lmTermsErr').textContent='';
  if(!nm){setErr('lmRegName','lmRegNameErr','Please enter your full name.');ok=false;}
  else if(nm.length<2){setErr('lmRegName','lmRegNameErr','Name must be at least 2 characters.');ok=false;}
  else clrErr('lmRegName','lmRegNameErr');
  if(!pw){setErr('lmRegPass','lmRegPassErr','Please create a password.');ok=false;}
  else if(pw.length<8){setErr('lmRegPass','lmRegPassErr','Password must be at least 8 characters.');ok=false;}
  else clrErr('lmRegPass','lmRegPassErr');
  if(!cf){setErr('lmRegConfirm','lmRegConfirmErr','Please confirm your password.');ok=false;}
  else if(pw!==cf){setErr('lmRegConfirm','lmRegConfirmErr','Passwords do not match.');ok=false;}
  else if(ok)clrErr('lmRegConfirm','lmRegConfirmErr');
  if(!tm){document.getElementById('lmTermsErr').textContent='Please accept the Terms & Conditions.';ok=false;}
  if(!ok)return;
  showLoad();
  fetch('/auth/register',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF(),'Accept':'application/json'},body:JSON.stringify({name:nm,email:em,password:pw,password_confirmation:cf})})
  .then(r=>r.json()).then(data=>{
    hideLoad();
    if(data.redirect)window.location.href=data.redirect;
    else if(data.error)document.getElementById('lmRegErr').textContent=data.error;
    else if(data.errors)document.getElementById('lmRegErr').textContent=Object.values(data.errors).flat()[0]||'Registration failed.';
  }).catch(()=>{hideLoad();document.getElementById('lmRegErr').textContent='Something went wrong.';});
};

window.lmStrength=function(v){
  const bar=document.getElementById('lmStrengthBar');
  const fill=document.getElementById('lmStrengthFill');
  if(!v){bar.style.display='none';return;}
  bar.style.display='block';
  let s=0;
  if(v.length>=8)s++;if(v.length>=12)s++;
  if(/[A-Z]/.test(v))s++;if(/[0-9]/.test(v))s++;if(/[^A-Za-z0-9]/.test(v))s++;
  const lvl=[['20%','#FF6B6B'],['40%','#FFB347'],['60%','#FFD166'],['80%','#4ECDC4'],['100%','#95D5B2']][Math.min(s,4)];
  fill.style.width=lvl[0];fill.style.background=lvl[1];
};

window.lmToggleEye=function(id,btn){
  const el=document.getElementById(id);
  el.type=el.type==='password'?'text':'password';
  btn.textContent=el.type==='password'?'👁':'🙈';
};

document.addEventListener('keydown',function(e){if(e.key==='Escape')closeLoginModal();});
})();
</script>
