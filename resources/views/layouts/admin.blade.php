<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Admin — @yield('title', 'Soochikaari')</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
/* ── ROOT ── */
:root{
  --p1:#D4956A;--p2:#C9A96E;--p3:#6FA89A;--p4:#8B7BB5;--p5:#C49BA0;
  --bg:#FAF7F4;--bg1:#FBF3EE;--bg2:#EEF6F5;--bg3:#F3F1F9;--bg4:#FBF7EE;--bg5:#F9F1F2;
  --dark:#3A3A3A;--mid:#9A9A9A;--border:#E2D9D0;--cream:#FAF7F4;
  --sidebar-w:240px;
}
*{margin:0;padding:0;box-sizing:border-box;}
html,body{height:100%;font-family:'Nunito',sans-serif;background:var(--bg);color:var(--dark);}

/* ── SHELL ── */
.admin-shell{display:flex;min-height:100vh;}

/* ══════════════════════════════
   SIDEBAR
══════════════════════════════ */
.admin-sidebar{
  width:var(--sidebar-w);flex-shrink:0;
  background:linear-gradient(160deg,#2A1A3E 0%,#1E1430 60%,#2A1A3E 100%);
  display:flex;flex-direction:column;
  position:fixed;top:0;left:0;bottom:0;z-index:200;
  overflow-y:auto;
}
.sidebar-rangoli{height:4px;background:linear-gradient(90deg,var(--p1),var(--p2),var(--p3),var(--p4),var(--p5));opacity:0.6;}
.sidebar-brand{padding:22px 20px 18px;border-bottom:1px solid rgba(255,255,255,0.08);}
.sidebar-brand-title{
  font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:900;color:#fff;
  display:flex;align-items:center;gap:8px;
}
.sidebar-brand-accent{color:var(--p1);}
.sidebar-brand-sub{font-size:0.6rem;font-weight:700;color:rgba(255,255,255,0.28);letter-spacing:0.1em;text-transform:uppercase;margin-top:3px;}
.sidebar-nav{padding:12px 0 6px;flex:1;}
.sidebar-nav-label{font-size:0.6rem;font-weight:800;text-transform:uppercase;letter-spacing:0.12em;color:rgba(255,255,255,0.22);padding:10px 20px 4px;display:block;}
.sidebar-nav-item{
  display:flex;align-items:center;gap:10px;padding:9px 20px;
  font-size:0.82rem;font-weight:700;color:rgba(255,255,255,0.48);
  cursor:pointer;transition:all 0.15s;text-decoration:none;
  position:relative;border:none;background:none;width:100%;text-align:left;
}
.sidebar-nav-item:hover{color:rgba(255,255,255,0.85);background:rgba(255,255,255,0.05);}
.sidebar-nav-item.active{color:#fff;background:rgba(212,149,106,0.15);}
.sidebar-nav-item.active::before{content:'';position:absolute;left:0;top:5px;bottom:5px;width:3px;background:var(--p1);border-radius:0 3px 3px 0;}
.sidebar-nav-icon{font-size:13px;width:20px;text-align:center;flex-shrink:0;}
.sidebar-nav-badge{margin-left:auto;background:var(--p1);color:white;font-size:0.63rem;font-weight:800;padding:2px 7px;border-radius:50px;min-width:18px;text-align:center;}
.sidebar-footer{padding:16px 20px;border-top:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;gap:10px;}
.sidebar-avatar{width:34px;height:34px;border-radius:50%;background:rgba(212,149,106,0.2);border:1.5px solid rgba(212,149,106,0.4);display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;}
.sidebar-footer-name{font-size:0.8rem;font-weight:700;color:#fff;}
.sidebar-footer-role{font-size:0.63rem;color:rgba(255,255,255,0.28);margin-top:1px;}
.sidebar-signout{margin-left:auto;background:none;border:none;font-family:'Nunito',sans-serif;font-size:0.68rem;color:rgba(255,255,255,0.3);cursor:pointer;padding:0;transition:color 0.15s;}
.sidebar-signout:hover{color:var(--p1);}

/* ── MOBILE OVERLAY ── */
.sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:199;}
.sidebar-overlay.open{display:block;}

/* ══════════════════════════════
   MAIN CONTENT
══════════════════════════════ */
.admin-main-wrap{margin-left:var(--sidebar-w);flex:1;display:flex;flex-direction:column;min-height:100vh;}

/* ── TOP BAR ── */
.admin-topbar{
  position:sticky;top:0;z-index:100;
  background:white;border-bottom:2px solid var(--border);
  height:60px;display:flex;align-items:center;
  padding:0 32px;gap:16px;
  box-shadow:0 2px 8px rgba(0,0,0,0.06);
}
.topbar-hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;background:none;border:none;padding:4px;}
.topbar-hamburger span{width:22px;height:2px;background:var(--dark);border-radius:2px;transition:all 0.3s;}
.topbar-page-name{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:900;color:var(--dark);}
.topbar-right{margin-left:auto;display:flex;align-items:center;gap:12px;}
.topbar-badge{display:flex;align-items:center;gap:6px;padding:6px 14px;background:var(--bg1);border:1.5px solid var(--border);border-radius:50px;font-size:0.78rem;font-weight:700;color:var(--dark);text-decoration:none;transition:all 0.15s;}
.topbar-badge:hover{background:var(--dark);color:white;border-color:var(--dark);}
.topbar-shop-link{display:flex;align-items:center;gap:5px;padding:6px 14px;background:var(--bg2);border:1.5px solid var(--p3);border-radius:50px;font-size:0.78rem;font-weight:700;color:var(--dark);text-decoration:none;transition:all 0.15s;}
.topbar-shop-link:hover{background:var(--p3);color:white;border-color:var(--p3);}

/* ── ALERTS ── */
.admin-alerts{padding:0 32px;}
.alert{padding:12px 20px;border:1.5px solid var(--border);border-radius:12px;margin-top:16px;font-weight:700;font-size:0.88rem;}
.alert-success{background:var(--bg2);color:#2D6B5E;border-color:var(--p3);}
.alert-error{background:var(--bg5);color:#7A3A40;border-color:var(--p5);}

/* ── PAGE CONTENT ── */
.admin-content{padding:28px 32px;flex:1;}

/* ── SHARED COMPONENT STYLES ── */
.rangoli-strip{height:4px;background:linear-gradient(90deg,var(--p1),var(--p2),var(--p3),var(--p4),var(--p5));opacity:0.45;}
.admin-section-tag{display:inline-block;background:var(--bg3);border:1.5px solid var(--border);color:var(--p4);border-radius:50px;padding:4px 14px;font-size:0.7rem;font-weight:800;letter-spacing:0.07em;text-transform:uppercase;margin-bottom:6px;}
.admin-page-title{font-family:'Playfair Display',serif;font-size:1.7rem;font-weight:900;color:var(--dark);}
.admin-page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:24px;}
.admin-add-btn{padding:11px 22px;background:var(--p1);color:white;border:2.5px solid var(--dark);border-radius:50px;font-family:'Nunito',sans-serif;font-size:0.85rem;font-weight:800;cursor:pointer;box-shadow:4px 4px 0 var(--dark);transition:all 0.15s;white-space:nowrap;text-decoration:none;display:inline-flex;align-items:center;gap:6px;}
.admin-add-btn:hover{transform:translate(-2px,-2px);box-shadow:6px 6px 0 var(--dark);color:white;}
.admin-card{background:white;border:2.5px solid var(--dark);border-radius:20px;overflow:hidden;box-shadow:5px 5px 0 var(--dark);margin-bottom:24px;}
.admin-card-header{padding:16px 20px;border-bottom:2px solid var(--bg);display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;}
.admin-card-title{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:800;}
.admin-card-actions{display:flex;gap:8px;align-items:center;}
.admin-search{padding:8px 16px;border:2px solid var(--dark);border-radius:50px;font-family:'Nunito',sans-serif;font-size:0.8rem;font-weight:600;background:var(--cream);outline:none;width:200px;transition:border-color 0.2s;}
.admin-search:focus{border-color:var(--p1);background:white;}
.sec-btn{padding:8px 16px;border:2px solid var(--dark);border-radius:50px;font-family:'Nunito',sans-serif;font-size:0.8rem;font-weight:700;background:white;cursor:pointer;box-shadow:2px 2px 0 var(--dark);transition:all 0.12s;display:inline-flex;align-items:center;gap:5px;text-decoration:none;color:var(--dark);}
.sec-btn:hover{background:var(--dark);color:white;}
.admin-table-wrap{overflow-x:auto;}
.admin-table{width:100%;border-collapse:collapse;min-width:600px;}
.admin-table th{background:var(--dark);color:white;padding:11px 16px;text-align:left;font-size:0.68rem;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;}
.admin-table td{padding:11px 16px;border-bottom:2px solid var(--bg);font-weight:600;font-size:0.83rem;vertical-align:middle;}
.admin-table tr:last-child td{border-bottom:none;}
.admin-table tbody tr:hover td{background:var(--bg1);}
.pill{display:inline-block;font-size:0.7rem;font-weight:800;padding:3px 10px;border-radius:50px;border:2px solid var(--dark);}
.pill-green{background:#B2D8D0;}
.pill-amber{background:var(--p2);}
.pill-red{background:#F5B7B1;color:#7B241C;border-color:#F5B7B1;}
.pill-blue{background:var(--bg3);}
.pill-purple{background:var(--bg3);color:var(--p4);}
.pill-new{background:var(--bg1);color:var(--p1);}
.pill-read{background:var(--bg);color:var(--mid);}
.pill-replied{background:var(--bg2);color:var(--p3);}
.act-btn{padding:5px 10px;border:2px solid var(--border);border-radius:50px;font-family:'Nunito',sans-serif;font-size:0.72rem;font-weight:700;cursor:pointer;background:white;margin-right:3px;transition:all 0.12s;display:inline-flex;align-items:center;gap:3px;text-decoration:none;color:var(--dark);}
.act-btn:hover{background:var(--dark);color:white;border-color:var(--dark);}
.act-teal{background:var(--bg2);border-color:var(--p3);}
.act-teal:hover{background:var(--p3);color:white;border-color:var(--p3);}
.act-del{color:#c0392b;border-color:#F5B7B1;}
.act-del:hover{background:#c0392b;color:white;border-color:#c0392b;}
.prod-thumb{width:40px;height:40px;border-radius:10px;border:2px solid var(--dark);display:flex;align-items:center;justify-content:center;font-size:1.2rem;overflow:hidden;flex-shrink:0;}
.prod-thumb img{width:100%;height:100%;object-fit:cover;}
.stat-card{background:white;border:2.5px solid var(--dark);border-radius:16px;padding:16px 18px;box-shadow:4px 4px 0 var(--dark);position:relative;overflow:hidden;}
.stat-card::after{content:attr(data-emoji);position:absolute;right:12px;top:10px;font-size:1.8rem;opacity:0.1;}
.stat-label{font-size:0.68rem;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:var(--mid);margin-bottom:6px;}
.stat-val{font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:900;color:var(--dark);}
.stat-note{font-size:0.7rem;font-weight:700;margin-top:4px;}
.stat-note.up{color:var(--p3);}
.stat-note.warn{color:var(--p2);}
.stat-note.danger{color:#c0392b;}
/* forms */
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.form-group{display:flex;flex-direction:column;gap:5px;}
.form-group.full{grid-column:1/-1;}
.form-label{font-size:0.7rem;font-weight:800;text-transform:uppercase;letter-spacing:0.06em;color:var(--mid);}
.form-input,.form-select,.form-textarea{padding:11px 14px;border:2.5px solid var(--dark);border-radius:11px;font-family:'Nunito',sans-serif;font-size:0.9rem;font-weight:600;background:var(--cream);outline:none;transition:border-color 0.2s;width:100%;}
.form-input:focus,.form-select:focus,.form-textarea:focus{border-color:var(--p1);background:white;}
.form-input.is-invalid,.form-select.is-invalid,.form-textarea.is-invalid{border-color:var(--p1)!important;background:#fff5f5;}
.form-textarea{resize:vertical;min-height:88px;}
.form-divider{grid-column:1/-1;display:flex;align-items:center;gap:12px;margin:4px 0;}
.form-divider span{font-size:0.68rem;font-weight:800;text-transform:uppercase;letter-spacing:0.1em;color:var(--mid);white-space:nowrap;}
.form-divider::before,.form-divider::after{content:'';flex:1;height:2px;background:var(--bg);border-radius:2px;}
.ferr{color:var(--p1);font-size:0.73rem;font-weight:700;min-height:16px;margin-top:3px;}
.ferr:not(:empty)::before{content:'⚠ ';}
.form-submit{margin-top:20px;padding:12px 30px;background:var(--p3);color:var(--dark);border:2.5px solid var(--dark);border-radius:50px;font-family:'Nunito',sans-serif;font-size:0.9rem;font-weight:800;cursor:pointer;box-shadow:4px 4px 0 var(--dark);transition:all 0.15s;}
.form-submit:hover{transform:translate(-2px,-2px);box-shadow:6px 6px 0 var(--dark);}
/* modals */
.modal-overlay{position:fixed;inset:0;z-index:500;background:rgba(0,0,0,0.55);backdrop-filter:blur(3px);display:flex;align-items:center;justify-content:center;padding:20px;opacity:0;pointer-events:none;transition:opacity 0.25s;}
.modal-overlay.open{opacity:1;pointer-events:all;}
.modal-box{background:white;border:3px solid var(--dark);border-radius:24px;width:100%;max-width:680px;max-height:90vh;overflow-y:auto;box-shadow:10px 10px 0 var(--dark);transform:translateY(20px) scale(0.97);transition:transform 0.3s cubic-bezier(0.34,1.56,0.64,1);}
.modal-overlay.open .modal-box{transform:translateY(0) scale(1);}
.modal-header{padding:20px 26px 16px;border-bottom:2px solid var(--bg);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;background:white;z-index:5;border-radius:24px 24px 0 0;}
.modal-title{font-family:'Playfair Display',serif;font-size:1.2rem;font-weight:800;}
.modal-close{width:32px;height:32px;border-radius:50%;border:2px solid var(--dark);background:var(--cream);font-size:0.85rem;font-weight:800;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.15s;}
.modal-close:hover{background:var(--dark);color:white;}
.modal-body{padding:22px 26px 26px;}
.del-overlay{position:fixed;inset:0;z-index:600;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;padding:20px;opacity:0;pointer-events:none;transition:opacity 0.2s;}
.del-overlay.open{opacity:1;pointer-events:all;}
.del-box{background:white;border:3px solid var(--dark);border-radius:20px;padding:36px;max-width:400px;width:100%;box-shadow:8px 8px 0 var(--dark);text-align:center;transform:scale(0.95);transition:transform 0.2s cubic-bezier(0.34,1.56,0.64,1);}
.del-overlay.open .del-box{transform:scale(1);}
.del-icon{font-size:3rem;margin-bottom:12px;}
.del-title{font-family:'Playfair Display',serif;font-size:1.25rem;font-weight:900;margin-bottom:8px;}
.del-sub{color:var(--mid);font-weight:600;font-size:0.87rem;margin-bottom:22px;line-height:1.5;}
.del-btns{display:flex;gap:12px;justify-content:center;}
.dbtn{padding:11px 26px;border-radius:50px;font-family:'Nunito',sans-serif;font-weight:800;font-size:0.88rem;cursor:pointer;border:2.5px solid var(--dark);transition:all 0.15s;box-shadow:3px 3px 0 var(--dark);}
.dbtn-cancel{background:white;}.dbtn-cancel:hover{background:var(--dark);color:white;}
.dbtn-del{background:#c0392b;color:white;border-color:#c0392b;}.dbtn-del:hover{background:#a93226;}
/* image upload */
.img-upload-area{border:2.5px dashed var(--dark);border-radius:14px;background:var(--cream);padding:20px;text-align:center;cursor:pointer;transition:all 0.2s;position:relative;overflow:hidden;}
.img-upload-area:hover{border-color:var(--p1);background:var(--bg1);}
.img-upload-area input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;z-index:2;}
.img-preview-wrap{display:none;flex-direction:column;align-items:center;gap:8px;}
.img-preview{width:100px;height:100px;object-fit:cover;border-radius:10px;border:2.5px solid var(--dark);box-shadow:3px 3px 0 var(--dark);}
.img-remove-btn{background:var(--p1);color:white;border:none;border-radius:50px;padding:4px 14px;font-size:0.73rem;font-weight:800;cursor:pointer;}
/* table empty */
.table-empty{text-align:center;padding:40px 20px;color:var(--mid);font-weight:700;display:none;}
/* cat chips */
.cat-chip{display:inline-flex;align-items:center;gap:8px;padding:6px 16px;border:2.5px solid var(--dark);border-radius:50px;font-family:'Nunito',sans-serif;font-weight:800;font-size:0.82rem;box-shadow:3px 3px 0 var(--dark);}
.cat-del-btn{background:none;border:none;cursor:pointer;font-size:0.8rem;opacity:0.45;transition:opacity 0.15s;padding:0;font-family:'Nunito',sans-serif;}
.cat-del-btn:hover{opacity:1;color:var(--p1);}

/* ── RESPONSIVE ── */
@media(max-width:900px){
  .admin-sidebar{transform:translateX(-100%);transition:transform 0.3s;}
  .admin-sidebar.open{transform:translateX(0);}
  .admin-main-wrap{margin-left:0;}
  .topbar-hamburger{display:flex;}
  .admin-content{padding:20px 16px;}
  .admin-topbar{padding:0 16px;}
}
</style>
@stack('admin-styles')
</head>
<body>
<div class="admin-shell">

  {{-- MOBILE OVERLAY --}}
  <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

  {{-- SIDEBAR --}}
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-rangoli"></div>
    <div class="sidebar-brand">
      <div class="sidebar-brand-title">
        <span class="sidebar-brand-accent">🪡</span>
        Soochi<span class="sidebar-brand-accent">kaari</span>
      </div>
      <div class="sidebar-brand-sub">Admin Panel</div>
    </div>

    <nav class="sidebar-nav">
      <span class="sidebar-nav-label">Overview</span>
      <a class="sidebar-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
         href="{{ route('admin.dashboard') }}">
        <span class="sidebar-nav-icon">▦</span> Dashboard
      </a>

      <span class="sidebar-nav-label">Catalogue</span>
      <a class="sidebar-nav-item {{ request()->routeIs('admin.dashboard') && !request()->query('tab') ? '' : '' }} {{ request()->is('admin') ? 'active' : '' }}"
         href="{{ route('admin.dashboard') }}#products">
        <span class="sidebar-nav-icon">🧵</span> Products
      </a>
      <a class="sidebar-nav-item" href="{{ route('admin.dashboard') }}#categories">
        <span class="sidebar-nav-icon">🏷</span> Categories
      </a>
      <a class="sidebar-nav-item" href="{{ route('admin.dashboard') }}#orders">
        <span class="sidebar-nav-icon">📦</span> Orders
      </a>

      <span class="sidebar-nav-label">Content</span>
      <a class="sidebar-nav-item {{ request()->routeIs('admin.blog*') ? 'active' : '' }}"
         href="#">
        <span class="sidebar-nav-icon">📝</span> Blog Posts
      </a>

      <span class="sidebar-nav-label">People</span>
      <a class="sidebar-nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}"
         href="{{ route('admin.users.index') }}">
        <span class="sidebar-nav-icon">👥</span> Users
      </a>
      <a class="sidebar-nav-item {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}"
         href="{{ route('admin.contacts.index') }}">
        <span class="sidebar-nav-icon">📬</span> Contacts
        @php $newContacts = \App\Models\Contact::where('status','new')->count(); @endphp
        @if($newContacts > 0)
          <span class="sidebar-nav-badge">{{ $newContacts }}</span>
        @endif
      </a>

      <span class="sidebar-nav-label">Store</span>
      <a class="sidebar-nav-item" href="{{ route('home') }}" target="_blank">
        <span class="sidebar-nav-icon">🌸</span> View Shop
      </a>
    </nav>

    <div class="sidebar-footer">
      <div class="sidebar-avatar">🌸</div>
      <div>
        <div class="sidebar-footer-name">Admin</div>
        <div class="sidebar-footer-role">{{ Auth::user()->email ?? '' }}</div>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sidebar-signout">Sign out</button>
      </form>
    </div>
  </aside>

  {{-- MAIN --}}
  <div class="admin-main-wrap">
    <div class="admin-topbar">
      <button class="topbar-hamburger" onclick="toggleSidebar()">
        <span></span><span></span><span></span>
      </button>
      <div class="topbar-page-name">@yield('page-name', 'Dashboard')</div>
      <div class="topbar-right">
        @if($newContacts > 0)
          <a href="{{ route('admin.contacts.index') }}" class="topbar-badge">
            📬 {{ $newContacts }} new
          </a>
        @endif
        <a href="{{ route('home') }}" target="_blank" class="topbar-shop-link">
          🌸 View Shop
        </a>
      </div>
    </div>

    <div class="admin-alerts">
      @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-error">❌ {{ session('error') }}</div>
      @endif
    </div>

    <div class="admin-content">
      @yield('content')
    </div>
  </div>
</div>

{{-- SHARED DELETE CONFIRM --}}
<div class="del-overlay" id="delOverlay">
  <div class="del-box">
    <div class="del-icon">🗑️</div>
    <div class="del-title" id="delTitle">Delete?</div>
    <div class="del-sub" id="delSub">This cannot be undone.</div>
    <div class="del-btns">
      <button class="dbtn dbtn-cancel" onclick="closeDel()">Cancel</button>
      <button class="dbtn dbtn-del" onclick="confirmDel()">Yes, Delete</button>
    </div>
  </div>
</div>
<form id="delForm" method="POST" style="display:none">@csrf @method('DELETE')</form>

<script>
/* sidebar mobile */
function toggleSidebar(){
  document.getElementById('adminSidebar').classList.toggle('open');
  document.getElementById('sidebarOverlay').classList.toggle('open');
}
function closeSidebar(){
  document.getElementById('adminSidebar').classList.remove('open');
  document.getElementById('sidebarOverlay').classList.remove('open');
}
/* shared delete */
let _delAction=null;
function openDel(action,title,sub){
  _delAction=action;
  document.getElementById('delTitle').textContent=title||'Delete?';
  document.getElementById('delSub').textContent=sub||'This cannot be undone.';
  document.getElementById('delOverlay').classList.add('open');
  document.body.style.overflow='hidden';
}
function closeDel(){
  document.getElementById('delOverlay').classList.remove('open');
  document.body.style.overflow='';
  _delAction=null;
}
function confirmDel(){
  if(!_delAction)return;
  document.getElementById('delForm').action=_delAction;
  document.getElementById('delForm').submit();
}
document.getElementById('delOverlay').addEventListener('click',function(e){if(e.target===this)closeDel();});
document.addEventListener('keydown',function(e){if(e.key==='Escape')closeDel();});
/* shared helpers */
function previewImg(ev,wId,phId,iId,nId){
  const f=ev.target.files[0];if(!f)return;
  const r=new FileReader();
  r.onload=e=>{
    document.getElementById(iId).src=e.target.result;
    document.getElementById(nId).textContent=f.name;
    document.getElementById(phId).style.display='none';
    document.getElementById(wId).style.display='flex';
  };r.readAsDataURL(f);
}
function removeImg(iId,wId,phId){
  document.getElementById(iId).value='';
  document.getElementById(wId).style.display='none';
  document.getElementById(phId).style.display='block';
}
function filterTable(q,tbodyId){
  q=q.toLowerCase().trim();let v=0;
  document.querySelectorAll('#'+tbodyId+' tr').forEach(r=>{
    const m=!q||(r.dataset.search||'').includes(q);
    r.style.display=m?'':'none';if(m)v++;
  });
  const emp=document.getElementById(tbodyId+'Empty');
  if(emp)emp.style.display=v===0?'block':'none';
}
</script>
@stack('admin-scripts')
</body>
</html>
