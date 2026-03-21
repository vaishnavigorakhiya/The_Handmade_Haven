@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-name', 'Dashboard')

@push('admin-styles')
<style>
.admin-stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;}
.edit-cur-img{width:72px;height:72px;border-radius:10px;border:2.5px solid var(--dark);object-fit:cover;box-shadow:3px 3px 0 var(--dark);flex-shrink:0;}
.edit-img-row{display:flex;align-items:flex-start;gap:14px;background:var(--cream);border-radius:12px;padding:14px;margin-bottom:4px;}
.cat-area{padding:14px 20px;display:flex;flex-wrap:wrap;gap:10px;align-items:center;}
.cat-add-row{padding:12px 20px;border-top:2px solid var(--bg);display:flex;gap:10px;align-items:flex-start;flex-wrap:wrap;}
.cat-add-input{flex:1;min-width:160px;padding:9px 14px;border:2px solid var(--dark);border-radius:11px;font-family:'Nunito',sans-serif;font-size:0.87rem;font-weight:600;background:var(--cream);outline:none;transition:border-color 0.2s;}
.cat-add-input:focus{border-color:var(--p1);background:white;}
.cat-color-sel{padding:9px 12px;border:2px solid var(--dark);border-radius:11px;font-family:'Nunito',sans-serif;font-size:0.83rem;font-weight:600;background:var(--cream);outline:none;cursor:pointer;}
.cat-add-btn{padding:9px 20px;background:var(--p1);color:white;border:2px solid var(--dark);border-radius:50px;font-family:'Nunito',sans-serif;font-weight:800;font-size:0.82rem;cursor:pointer;box-shadow:3px 3px 0 var(--dark);white-space:nowrap;transition:all 0.15s;}
.cat-add-btn:hover{transform:translate(-1px,-1px);box-shadow:5px 5px 0 var(--dark);}
@media(max-width:800px){.admin-stats-row{grid-template-columns:1fr 1fr;}}
</style>
@endpush

@section('content')

{{-- STATS --}}
<div class="admin-stats-row">
  <div class="stat-card" data-emoji="🧵" style="background:var(--bg1)">
    <div class="stat-label">Products</div>
    <div class="stat-val">{{ $products->count() }}</div>
    <div class="stat-note up">All categories</div>
  </div>
  <div class="stat-card" data-emoji="📦" style="background:var(--bg2)">
    <div class="stat-label">Orders</div>
    <div class="stat-val">{{ $totalOrders }}</div>
    <div class="stat-note up">Total placed</div>
  </div>
  <div class="stat-card" data-emoji="💰" style="background:var(--bg4)">
    <div class="stat-label">Revenue</div>
    <div class="stat-val">₹{{ number_format($totalRevenue, 0) }}</div>
    <div class="stat-note up">All time</div>
  </div>
  <div class="stat-card" data-emoji="⚠️" style="background:var(--bg5)">
    <div class="stat-label">Low Stock</div>
    <div class="stat-val">{{ $lowStock }}</div>
    <div class="stat-note {{ $lowStock > 0 ? 'danger' : 'up' }}">
      {{ $lowStock > 0 ? 'Needs restocking' : 'All good' }}
    </div>
  </div>
</div>

{{-- ── PRODUCTS ── --}}
<div class="admin-card" id="products">
  <div class="rangoli-strip"></div>
  <div class="admin-card-header">
    <div class="admin-card-title">📋 All Products</div>
    <div class="admin-card-actions">
      <input class="admin-search" placeholder="🔍 Search products…"
             oninput="filterTable(this.value,'productTbody')" />
      <button class="admin-add-btn" onclick="openAddModal()"
              style="padding:8px 16px;font-size:0.8rem;box-shadow:3px 3px 0 var(--dark);">
        ✨ Add Product
      </button>
    </div>
  </div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Image</th><th>Product</th><th>Category</th>
          <th>Price</th><th>Stock</th><th>Status</th><th>Actions</th>
        </tr>
      </thead>
      <tbody id="productTbody">
        @foreach($products as $product)
          <tr data-search="{{ strtolower($product->name.' '.$product->category) }}">
            <td>
              <div class="prod-thumb" style="background:{{ $product->color ?? '#FFE8D6' }}">
                @if($product->image)
                  <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}"
                       onerror="this.style.display='none'" />
                @else
                  {{ $product->emoji ?? '🧵' }}
                @endif
              </div>
            </td>
            <td><strong>{{ $product->name }}</strong></td>
            <td>{{ $product->category }}</td>
            <td><strong>₹{{ number_format($product->price, 2) }}</strong></td>
            <td>{{ $product->stock }}</td>
            <td>
              @if($product->stock === 0)<span class="pill pill-red">Out of Stock</span>
              @elseif($product->stock <= 3)<span class="pill pill-amber">Low Stock</span>
              @else<span class="pill pill-green">In Stock</span>@endif
            </td>
            <td>
              <button class="act-btn"
                data-id="{{ $product->id }}"
                data-name="{{ $product->name }}"
                data-price="{{ $product->price }}"
                data-category="{{ $product->category }}"
                data-stock="{{ $product->stock }}"
                data-description="{{ addslashes($product->description) }}"
                data-badge="{{ $product->badge }}"
                data-color="{{ $product->color }}"
                data-image="{{ $product->image }}"
                onclick="openEditFromData(this)">✏ Edit</button>
              <form action="{{ route('admin.products.restock', $product->id) }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="act-btn act-teal">📦 +5</button>
              </form>
              <button class="act-btn act-del"
                onclick="openDel(
                  '{{ route('admin.products.destroy', $product->id) }}',
                  'Delete Product?',
                  'Delete &quot;{{ addslashes($product->name) }}&quot;? This cannot be undone.'
                )">🗑</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="table-empty" id="productTbodyEmpty">
      <div style="font-size:2.5rem;margin-bottom:8px;">🔍</div>No products match.
    </div>
  </div>
</div>

{{-- ── CATEGORIES ── --}}
<div class="admin-card" id="categories">
  <div class="rangoli-strip"></div>
  <div class="admin-card-header">
    <div class="admin-card-title">🏷 Categories</div>
  </div>
  <div class="cat-area">
    @foreach($categories as $cat)
      <div class="cat-chip" style="background:{{ $cat->color }}">
        {{ $cat->name }}
        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" style="display:inline">
          @csrf @method('DELETE')
          <button type="submit" class="cat-del-btn"
                  onclick="return confirm('Remove \'{{ addslashes($cat->name) }}\'?')">✕</button>
        </form>
      </div>
    @endforeach
  </div>
  <form action="{{ route('admin.categories.store') }}" method="POST" id="catForm" novalidate>
    @csrf
    <div class="cat-add-row">
      <div style="flex:1;min-width:160px;display:flex;flex-direction:column;gap:4px;">
        <input type="text" name="name" id="catInput" class="cat-add-input"
               placeholder="New category name…" value="{{ old('name') }}" />
        <div class="ferr" id="catErr">@error('name'){{ $message }}@enderror</div>
      </div>
      <select name="color" class="cat-color-sel">
        <option value="#FFE8D6">🍑 Peach</option>
        <option value="#E8F8F5">🌿 Mint</option>
        <option value="#F5E8FF">💜 Lavender</option>
        <option value="#FFE8F0">🌸 Rose</option>
        <option value="#FFFDE8">🌟 Yellow</option>
        <option value="#D6EAF8">💙 Blue</option>
      </select>
      <button type="button" class="cat-add-btn" onclick="submitCat()">+ Add</button>
    </div>
  </form>
</div>

{{-- ── ORDERS ── --}}
@php $recentOrders = \App\Models\Order::with('user')->latest()->take(10)->get(); @endphp
<div class="admin-card" id="orders">
  <div class="rangoli-strip"></div>
  <div class="admin-card-header">
    <div class="admin-card-title">🛒 Orders</div>
    <div class="admin-card-actions">
      <input class="admin-search" placeholder="🔍 Search…"
             oninput="filterTable(this.value,'orderTbody')" />
    </div>
  </div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr><th>#</th><th>Customer</th><th>Phone</th><th>Address</th><th>Total</th><th>Status</th><th>Date</th></tr>
      </thead>
      <tbody id="orderTbody">
        @forelse($recentOrders as $order)
          <tr data-search="{{ strtolower(($order->full_name ?? $order->user?->name ?? '').' '.($order->address ?? '')) }}">
            <td><strong>#{{ $order->id }}</strong></td>
            <td>{{ $order->full_name ?? $order->user?->name ?? '—' }}</td>
            <td>{{ $order->phone ?? '—' }}</td>
            <td style="max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $order->address ?? '—' }}</td>
            <td><strong>₹{{ number_format($order->total, 2) }}</strong></td>
            <td><span class="pill {{ $order->status === 'completed' ? 'pill-green' : 'pill-blue' }}">{{ ucfirst($order->status) }}</span></td>
            <td style="color:var(--mid)">{{ $order->created_at->format('d M Y') }}</td>
          </tr>
        @empty
          <tr><td colspan="7" style="text-align:center;padding:32px;color:var(--mid);font-weight:700;">No orders yet.</td></tr>
        @endforelse
      </tbody>
    </table>
    <div class="table-empty" id="orderTbodyEmpty"><div style="font-size:2rem;margin-bottom:6px;">🔍</div>No orders match.</div>
  </div>
</div>

{{-- ── USERS QUICK VIEW ── --}}
@php $recentUsers = \App\Models\User::where('role','!=','admin')->latest()->take(5)->get(); @endphp
<div class="admin-card">
  <div class="rangoli-strip"></div>
  <div class="admin-card-header">
    <div class="admin-card-title">👥 Recent Users</div>
    <div class="admin-card-actions">
      <a href="{{ route('admin.users.index') }}" class="sec-btn">View all →</a>
    </div>
  </div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Joined</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse($recentUsers as $user)
          <tr>
            <td><strong>{{ $user->name }}</strong></td>
            <td>{{ $user->email ?? '—' }}</td>
            <td>{{ $user->phone ?? '—' }}</td>
            <td><span class="pill {{ $user->is_active ? 'pill-green' : 'pill-red' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></td>
            <td style="color:var(--mid)">{{ $user->created_at->format('d M Y') }}</td>
            <td>
              <a href="{{ route('admin.users.show', $user) }}" class="act-btn">View</a>
              <form action="{{ route('admin.users.toggle', $user) }}" method="POST" style="display:inline">
                @csrf @method('PATCH')
                <button type="submit" class="act-btn">{{ $user->is_active ? 'Deactivate' : 'Activate' }}</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" style="text-align:center;padding:32px;color:var(--mid);font-weight:700;">No users yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- ── CONTACTS QUICK VIEW ── --}}
@php $recentContacts = \App\Models\Contact::latest()->take(5)->get(); @endphp
<div class="admin-card">
  <div class="rangoli-strip"></div>
  <div class="admin-card-header">
    <div class="admin-card-title">📬 Recent Contacts</div>
    <div class="admin-card-actions">
      <a href="{{ route('admin.contacts.index') }}" class="sec-btn">View all →</a>
    </div>
  </div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr><th>Name</th><th>Email</th><th>Message</th><th>Status</th><th>Date</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse($recentContacts as $contact)
          <tr>
            <td><strong>{{ $contact->name }}</strong></td>
            <td>{{ $contact->email }}</td>
            <td style="max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--mid)">{{ $contact->message }}</td>
            <td>
              @if($contact->status === 'new')<span class="pill pill-new">New</span>
              @elseif($contact->status === 'replied')<span class="pill pill-replied">Replied</span>
              @else<span class="pill pill-read">Read</span>@endif
            </td>
            <td style="color:var(--mid)">{{ $contact->created_at->format('d M Y') }}</td>
            <td>
              <a href="{{ route('admin.contacts.show', $contact) }}" class="act-btn">View</a>
              <button class="act-btn act-del"
                onclick="openDel('{{ route('admin.contacts.destroy', $contact) }}','Delete Inquiry?','This cannot be undone.')">🗑</button>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" style="text-align:center;padding:32px;color:var(--mid);font-weight:700;">No inquiries yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- ══ ADD PRODUCT MODAL ══ --}}
<div class="modal-overlay" id="addOverlay" onclick="if(event.target.id==='addOverlay')closeAdd()">
  <div class="modal-box">
    <div class="modal-header">
      <div class="modal-title">✨ Add New Product</div>
      <button type="button" class="modal-close" onclick="closeAdd()">✕</button>
    </div>
    <div class="modal-body">
      <form action="{{ route('admin.products.store') }}" method="POST"
            enctype="multipart/form-data" id="addForm" novalidate>
        @csrf
        <div class="form-grid">
          <div class="form-divider"><span>Basic Info</span></div>
          <div class="form-group">
            <label class="form-label">Product Name *</label>
            <input class="form-input" name="name" id="a_name" value="{{ old('name') }}" placeholder="e.g. Floral Hoop Art"/>
            <div class="ferr" id="ae_name">@error('name'){{ $message }}@enderror</div>
          </div>
          <div class="form-group">
            <label class="form-label">Price (₹) *</label>
            <input class="form-input" name="price" id="a_price" type="number" step="0.01" min="0" value="{{ old('price') }}" placeholder="24.99"/>
            <div class="ferr" id="ae_price">@error('price'){{ $message }}@enderror</div>
          </div>
          <div class="form-group">
            <label class="form-label">Category *</label>
            <select class="form-select" name="category" id="a_category">
              <option value="">— Select —</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->name }}" {{ old('category')==$cat->name?'selected':'' }}>{{ $cat->name }}</option>
              @endforeach
            </select>
            <div class="ferr" id="ae_category">@error('category'){{ $message }}@enderror</div>
          </div>
          <div class="form-group">
            <label class="form-label">Stock *</label>
            <input class="form-input" name="stock" id="a_stock" type="number" min="0" value="{{ old('stock') }}" placeholder="10"/>
            <div class="ferr" id="ae_stock">@error('stock'){{ $message }}@enderror</div>
          </div>
          <div class="form-group">
            <label class="form-label">Card Color</label>
            <select class="form-select" name="color">
              <option value="#FFE8D6">🍑 Peach</option><option value="#E8F8F5">🌿 Mint</option>
              <option value="#F5E8FF">💜 Lavender</option><option value="#FFE8F0">🌸 Rose</option>
              <option value="#FFFDE8">🌟 Yellow</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Badge (optional)</label>
            <input class="form-input" name="badge" value="{{ old('badge') }}" placeholder="Bestseller, New…"/>
          </div>
          <div class="form-divider"><span>Image</span></div>
          <div class="form-group full">
            <label class="form-label">Product Image</label>
            <div class="img-upload-area">
              <input type="file" name="image" id="aImgInput" accept="image/*"
                     onchange="previewImg(event,'aPreviewWrap','aPlaceholder','aImgEl','aImgName')"/>
              <div id="aPlaceholder">
                <div style="font-size:2rem;margin-bottom:5px;">📸</div>
                <div style="font-weight:800;font-size:0.85rem;margin-bottom:2px;">Click or drag & drop</div>
                <div style="font-size:0.73rem;color:var(--mid)">JPG · PNG · WEBP · max 2 MB</div>
              </div>
              <div class="img-preview-wrap" id="aPreviewWrap">
                <img class="img-preview" id="aImgEl" src="" alt=""/>
                <div style="font-size:0.73rem;font-weight:700;color:var(--mid)" id="aImgName"></div>
                <button type="button" class="img-remove-btn"
                        onclick="removeImg('aImgInput','aPreviewWrap','aPlaceholder')">✕ Remove</button>
              </div>
            </div>
            <div class="ferr" id="ae_image">@error('image'){{ $message }}@enderror</div>
          </div>
          <div class="form-divider"><span>Description</span></div>
          <div class="form-group full">
            <label class="form-label">Description *</label>
            <textarea class="form-textarea" name="description" id="a_description" placeholder="Describe this piece…">{{ old('description') }}</textarea>
            <div class="ferr" id="ae_description">@error('description'){{ $message }}@enderror</div>
          </div>
        </div>
        <button type="button" class="form-submit" onclick="validateAdd()">✨ Add Product</button>
      </form>
    </div>
  </div>
</div>

{{-- ══ EDIT PRODUCT MODAL ══ --}}
<div class="modal-overlay" id="editOverlay" onclick="if(event.target.id==='editOverlay')closeEdit()">
  <div class="modal-box">
    <div class="modal-header">
      <div class="modal-title">✏ Edit Product</div>
      <button type="button" class="modal-close" onclick="closeEdit()">✕</button>
    </div>
    <div class="modal-body">
      <form id="editForm" method="POST" enctype="multipart/form-data" action="" novalidate>
        @csrf<input type="hidden" name="_method" value="PATCH"/>
        <div class="form-grid">
          <div class="form-divider"><span>Basic Info</span></div>
          <div class="form-group"><label class="form-label">Name *</label><input class="form-input" name="name" id="e_name"/><div class="ferr" id="ee_name"></div></div>
          <div class="form-group"><label class="form-label">Price (₹) *</label><input class="form-input" name="price" id="e_price" type="number" step="0.01" min="0"/><div class="ferr" id="ee_price"></div></div>
          <div class="form-group">
            <label class="form-label">Category *</label>
            <select class="form-select" name="category" id="e_category">
              @foreach($categories as $cat)<option value="{{ $cat->name }}">{{ $cat->name }}</option>@endforeach
            </select>
            <div class="ferr" id="ee_category"></div>
          </div>
          <div class="form-group"><label class="form-label">Stock *</label><input class="form-input" name="stock" id="e_stock" type="number" min="0"/><div class="ferr" id="ee_stock"></div></div>
          <div class="form-group">
            <label class="form-label">Color</label>
            <select class="form-select" name="color" id="e_color">
              <option value="#FFE8D6">🍑 Peach</option><option value="#E8F8F5">🌿 Mint</option>
              <option value="#F5E8FF">💜 Lavender</option><option value="#FFE8F0">🌸 Rose</option>
              <option value="#FFFDE8">🌟 Yellow</option>
            </select>
          </div>
          <div class="form-group"><label class="form-label">Badge</label><input class="form-input" name="badge" id="e_badge"/></div>
          <div class="form-divider"><span>Image</span></div>
          <div class="form-group full">
            <div class="edit-img-row">
              <img class="edit-cur-img" id="eCurImg" src="" alt="" style="display:none"/>
              <div id="eNoImg" style="font-size:0.82rem;font-weight:700;color:var(--mid);align-self:center;">No image</div>
              <div style="flex:1;">
                <div style="font-size:0.7rem;font-weight:700;color:var(--mid);margin-bottom:5px;">Replace image</div>
                <div class="img-upload-area" style="padding:12px;">
                  <input type="file" name="image" id="eImgInput" accept="image/*"
                         onchange="previewImg(event,'ePreviewWrap','ePlaceholder','eImgEl','eImgName')"/>
                  <div id="ePlaceholder"><div style="font-size:1.3rem;">📸</div><div style="font-size:0.75rem;font-weight:700;margin-top:3px;">Click or drag</div></div>
                  <div class="img-preview-wrap" id="ePreviewWrap">
                    <img class="img-preview" id="eImgEl" src="" alt="" style="width:70px;height:70px;"/>
                    <div style="font-size:0.7rem;font-weight:700;color:var(--mid)" id="eImgName"></div>
                    <button type="button" class="img-remove-btn" onclick="removeImg('eImgInput','ePreviewWrap','ePlaceholder')">✕ Remove</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-divider"><span>Description</span></div>
          <div class="form-group full"><label class="form-label">Description *</label><textarea class="form-textarea" name="description" id="e_description"></textarea><div class="ferr" id="ee_description"></div></div>
        </div>
        <div style="display:flex;gap:12px;margin-top:20px;flex-wrap:wrap;">
          <button type="button" class="form-submit" onclick="validateEdit()">💾 Save Changes</button>
          <button type="button" onclick="closeEdit()" style="padding:12px 26px;background:white;border:2.5px solid var(--dark);border-radius:50px;font-family:'Nunito',sans-serif;font-weight:800;cursor:pointer;box-shadow:3px 3px 0 var(--dark);">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('admin-scripts')
<script>
function openAddModal(){document.getElementById('addOverlay').classList.add('open');document.body.style.overflow='hidden';setTimeout(()=>document.getElementById('a_name').focus(),300);}
function closeAdd(){document.getElementById('addOverlay').classList.remove('open');document.body.style.overflow='';}
function validateAdd(){
  let ok=true;
  const checks=[
    {id:'a_name',eid:'ae_name',minLen:3,msg:'At least 3 characters.'},
    {id:'a_price',eid:'ae_price',num:true,msg:'Valid price required.'},
    {id:'a_category',eid:'ae_category',msg:'Select a category.'},
    {id:'a_stock',eid:'ae_stock',num:true,msg:'Stock required.'},
    {id:'a_description',eid:'ae_description',minLen:10,msg:'At least 10 characters.'},
  ];
  checks.forEach(f=>{
    const el=document.getElementById(f.id);const em=document.getElementById(f.eid);
    el.classList.remove('is-invalid');if(em)em.textContent='';
    const v=el.value.trim();let inv=!v;
    if(!inv&&f.minLen)inv=v.length<f.minLen;
    if(!inv&&f.num)inv=isNaN(v)||parseFloat(v)<0;
    if(inv){el.classList.add('is-invalid');if(em)em.textContent=f.msg;ok=false;}
  });
  if(ok)document.getElementById('addForm').submit();
  else{const f=document.querySelector('#addForm .is-invalid');if(f)f.scrollIntoView({behavior:'smooth',block:'center'});}
}
function openEditFromData(btn){
  const p=btn.dataset;
  document.getElementById('editForm').action='/admin/products/'+p.id;
  document.getElementById('e_name').value=p.name||'';
  document.getElementById('e_price').value=p.price||'';
  document.getElementById('e_category').value=p.category||'';
  document.getElementById('e_stock').value=p.stock??0;
  document.getElementById('e_description').value=p.description||'';
  document.getElementById('e_badge').value=p.badge||'';
  const cs=document.getElementById('e_color');if(cs&&p.color)cs.value=p.color;
  const img=document.getElementById('eCurImg');const noImg=document.getElementById('eNoImg');
  if(p.image&&p.image!=='null'&&p.image!==''){img.src='/storage/'+p.image;img.style.display='block';noImg.style.display='none';}
  else{img.style.display='none';noImg.style.display='block';}
  removeImg('eImgInput','ePreviewWrap','ePlaceholder');
  document.getElementById('editOverlay').classList.add('open');document.body.style.overflow='hidden';
  setTimeout(()=>document.getElementById('e_name').focus(),300);
}
function closeEdit(){document.getElementById('editOverlay').classList.remove('open');document.body.style.overflow='';}
function validateEdit(){
  let ok=true;
  const checks=[
    {id:'e_name',eid:'ee_name',minLen:3,msg:'At least 3 characters.'},
    {id:'e_price',eid:'ee_price',num:true,msg:'Valid price required.'},
    {id:'e_category',eid:'ee_category',msg:'Select a category.'},
    {id:'e_stock',eid:'ee_stock',num:true,msg:'Stock required.'},
    {id:'e_description',eid:'ee_description',minLen:10,msg:'At least 10 characters.'},
  ];
  checks.forEach(f=>{
    const el=document.getElementById(f.id);const em=document.getElementById(f.eid);
    el.classList.remove('is-invalid');if(em)em.textContent='';
    const v=el.value.trim();let inv=!v;
    if(!inv&&f.minLen)inv=v.length<f.minLen;
    if(!inv&&f.num)inv=isNaN(v)||parseFloat(v)<0;
    if(inv){el.classList.add('is-invalid');if(em)em.textContent=f.msg;ok=false;}
  });
  if(ok)document.getElementById('editForm').submit();
  else{const f=document.querySelector('#editForm .is-invalid');if(f)f.scrollIntoView({behavior:'smooth',block:'center'});}
}
function submitCat(){
  const v=document.getElementById('catInput').value.trim();
  const err=document.getElementById('catErr');err.textContent='';
  if(!v||v.length<2){err.textContent='At least 2 characters.';document.getElementById('catInput').focus();return;}
  document.getElementById('catForm').submit();
}
document.addEventListener('keydown',function(e){if(e.key==='Escape'){closeAdd();closeEdit();}});
@if($errors->any() && old('name'))
  document.addEventListener('DOMContentLoaded',function(){openAddModal();});
@endif
</script>
@endpush
