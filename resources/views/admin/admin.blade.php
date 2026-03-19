@extends('layouts.app')
@section('title', 'Admin Dashboard — Stitch & Bloom')

@push('styles')
<style>
.admin-wrap{max-width:1200px;margin:0 auto;}
.admin-page-header{margin-bottom:36px;}
.admin-page-header h2{font-family:'Playfair Display',serif;font-size:2rem;font-weight:900;margin-top:8px;}
.admin-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:36px;}
.stat-card{background:white;border:3px solid var(--dark);border-radius:18px;padding:22px 18px;box-shadow:5px 5px 0 var(--dark);text-align:center;}
.stat-emoji{font-size:1.8rem;margin-bottom:8px;}
.stat-value{font-family:'Playfair Display',serif;font-size:1.7rem;font-weight:900;color:var(--coral);}
.stat-label{font-size:.73rem;font-weight:800;color:var(--mid);text-transform:uppercase;letter-spacing:.06em;margin-top:3px;}
.table-section{background:white;border:3px solid var(--dark);border-radius:20px;overflow:hidden;box-shadow:6px 6px 0 var(--dark);margin-bottom:36px;}
.table-section-header{padding:20px 24px 16px;border-bottom:2px solid var(--cream);display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;}
.table-section-title{font-family:'Playfair Display',serif;font-size:1.25rem;font-weight:800;}
.table-search{padding:9px 16px;border:2px solid var(--dark);border-radius:50px;font-family:'Nunito',sans-serif;font-size:.88rem;font-weight:600;background:var(--cream);outline:none;width:220px;transition:border-color .2s;}
.table-search:focus{border-color:var(--coral);background:white;}
.admin-table-wrap{overflow-x:auto;}
.admin-table{width:100%;border-collapse:collapse;min-width:700px;}
.admin-table th{background:var(--dark);color:white;padding:14px 20px;text-align:left;font-size:.78rem;font-weight:800;text-transform:uppercase;letter-spacing:.07em;}
.admin-table td{padding:13px 20px;border-bottom:2px solid var(--cream);font-weight:600;vertical-align:middle;}
.admin-table tr:last-child td{border-bottom:none;}
.admin-table tbody tr:hover td{background:#fffaf7;}
.product-thumb{width:48px;height:48px;border-radius:10px;border:2px solid var(--dark);object-fit:cover;display:block;}
.product-thumb-ph{width:48px;height:48px;border-radius:10px;border:2px solid var(--dark);display:flex;align-items:center;justify-content:center;background:var(--cream);color:rgba(0,0,0,.25);}
.stock-badge{padding:3px 12px;border-radius:50px;font-size:.75rem;font-weight:800;border:2px solid var(--dark);display:inline-block;}
.stock-in{background:var(--green);}
.stock-low{background:var(--gold);}
.stock-out{background:var(--coral);color:white;border-color:var(--coral);}
.action-btns{display:flex;gap:6px;flex-wrap:wrap;}
.act-btn{padding:6px 13px;border-radius:50px;font-family:'Nunito',sans-serif;font-size:.77rem;font-weight:800;cursor:pointer;border:2px solid var(--dark);transition:all .15s;display:inline-flex;align-items:center;gap:4px;}
.act-edit{background:var(--lavender);}
.act-edit:hover{background:var(--dark);color:white;}
.act-restock{background:var(--teal);}
.act-restock:hover{background:#3ab8b0;}
.act-del{background:var(--coral);color:white;border-color:var(--coral);}
.act-del:hover{background:#c0392b;border-color:#c0392b;}
.table-empty{text-align:center;padding:40px 20px;color:var(--mid);font-weight:700;display:none;}
.form-section{background:white;border:3px solid var(--dark);border-radius:20px;padding:32px;box-shadow:6px 6px 0 var(--dark);margin-bottom:28px;}
.form-section-title{font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:800;margin-bottom:20px;}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.form-group{display:flex;flex-direction:column;gap:5px;}
.form-group.full{grid-column:1/-1;}
.form-label{font-size:.78rem;font-weight:800;color:var(--mid);text-transform:uppercase;letter-spacing:.05em;}
.form-input,.form-select,.form-textarea{padding:11px 14px;border:2.5px solid var(--dark);border-radius:11px;font-family:'Nunito',sans-serif;font-size:.94rem;font-weight:600;background:var(--cream);outline:none;transition:border-color .2s;width:100%;}
.form-input:focus,.form-select:focus,.form-textarea:focus{border-color:var(--coral);background:white;}
.form-input.is-invalid,.form-select.is-invalid,.form-textarea.is-invalid{border-color:var(--coral)!important;background:#fff5f5;}
.form-textarea{resize:vertical;min-height:84px;}
.ferr{color:var(--coral);font-size:.77rem;font-weight:700;min-height:16px;}
.ferr:not(:empty)::before{content:'⚠ ';}
.form-divider{grid-column:1/-1;display:flex;align-items:center;gap:12px;margin:6px 0 2px;}
.form-divider span{font-size:.73rem;font-weight:800;text-transform:uppercase;letter-spacing:.09em;color:var(--mid);white-space:nowrap;}
.form-divider::before,.form-divider::after{content:'';flex:1;height:2px;background:var(--cream);border-radius:2px;}
.img-upload-area{border:2.5px dashed var(--dark);border-radius:14px;background:var(--cream);padding:22px;text-align:center;cursor:pointer;transition:all .2s;position:relative;overflow:hidden;}
.img-upload-area:hover{border-color:var(--coral);background:#FFF0EC;}
.img-upload-area input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;z-index:2;}
.upload-icon{font-size:2rem;margin-bottom:6px;}
.upload-title{font-weight:800;font-size:.9rem;margin-bottom:3px;}
.upload-sub{font-size:.77rem;color:var(--mid);font-weight:600;}
.img-preview-wrap{display:none;flex-direction:column;align-items:center;gap:8px;}
.img-preview{width:110px;height:110px;object-fit:cover;border-radius:10px;border:3px solid var(--dark);box-shadow:3px 3px 0 var(--dark);}
.img-preview-name{font-size:.78rem;font-weight:700;color:var(--mid);}
.img-remove-btn{background:var(--coral);color:white;border:none;border-radius:50px;padding:4px 14px;font-size:.78rem;font-weight:800;cursor:pointer;}
.form-submit{margin-top:22px;padding:14px 36px;background:var(--teal);color:var(--dark);border:3px solid var(--dark);border-radius:50px;font-family:'Nunito',sans-serif;font-size:1rem;font-weight:800;cursor:pointer;box-shadow:4px 4px 0 var(--dark);transition:all .15s;}
.form-submit:hover{transform:translate(-2px,-2px);box-shadow:6px 6px 0 var(--dark);}
.cat-grid{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px;min-height:42px;}
.cat-chip{display:inline-flex;align-items:center;gap:8px;padding:7px 16px;border:2.5px solid var(--dark);border-radius:50px;font-family:'Nunito',sans-serif;font-weight:800;font-size:.85rem;box-shadow:3px 3px 0 var(--dark);}
.cat-del-btn{background:none;border:none;cursor:pointer;font-size:.85rem;opacity:.55;transition:opacity .15s;padding:0;line-height:1;}
.cat-del-btn:hover{opacity:1;color:var(--coral);}
.cat-add-row{display:flex;gap:10px;align-items:flex-start;flex-wrap:wrap;}
.cat-add-input{flex:1;min-width:160px;padding:10px 14px;border:2.5px solid var(--dark);border-radius:11px;font-family:'Nunito',sans-serif;font-size:.92rem;font-weight:600;background:var(--cream);outline:none;}
.cat-add-input:focus{border-color:var(--coral);background:white;}
.cat-add-btn{padding:10px 22px;background:var(--coral);color:white;border:2.5px solid var(--dark);border-radius:50px;font-family:'Nunito',sans-serif;font-weight:800;font-size:.88rem;cursor:pointer;box-shadow:3px 3px 0 var(--dark);white-space:nowrap;transition:all .15s;}
.cat-add-btn:hover{transform:translate(-1px,-1px);box-shadow:5px 5px 0 var(--dark);}
.modal-overlay{position:fixed;inset:0;z-index:500;background:rgba(0,0,0,.55);backdrop-filter:blur(3px);display:flex;align-items:center;justify-content:center;padding:20px;opacity:0;pointer-events:none;transition:opacity .25s;}
.modal-overlay.open{opacity:1;pointer-events:all;}
.modal-box{background:white;border:3px solid var(--dark);border-radius:24px;width:100%;max-width:700px;max-height:90vh;overflow-y:auto;box-shadow:10px 10px 0 var(--dark);transform:translateY(20px) scale(.97);transition:transform .3s cubic-bezier(.34,1.56,.64,1);}
.modal-overlay.open .modal-box{transform:translateY(0) scale(1);}
.modal-header{padding:22px 28px 18px;border-bottom:2px solid var(--cream);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;background:white;z-index:5;border-radius:24px 24px 0 0;}
.modal-title{font-family:'Playfair Display',serif;font-size:1.3rem;font-weight:800;}
.modal-close{width:32px;height:32px;border-radius:50%;border:2px solid var(--dark);background:var(--cream);font-size:.85rem;font-weight:800;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .15s;}
.modal-close:hover{background:var(--dark);color:white;}
.modal-body{padding:24px 28px 28px;}
.edit-cur-img{width:72px;height:72px;border-radius:10px;border:2.5px solid var(--dark);object-fit:cover;box-shadow:3px 3px 0 var(--dark);flex-shrink:0;}
.edit-img-row{display:flex;align-items:flex-start;gap:16px;background:var(--cream);border-radius:12px;padding:14px 16px;margin-bottom:4px;}
.del-overlay{position:fixed;inset:0;z-index:600;background:rgba(0,0,0,.6);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;padding:20px;opacity:0;pointer-events:none;transition:opacity .2s;}
.del-overlay.open{opacity:1;pointer-events:all;}
.del-box{background:white;border:3px solid var(--dark);border-radius:20px;padding:36px;max-width:400px;width:100%;box-shadow:8px 8px 0 var(--dark);text-align:center;transform:scale(.95);transition:transform .2s cubic-bezier(.34,1.56,.64,1);}
.del-overlay.open .del-box{transform:scale(1);}
.del-icon{font-size:3rem;margin-bottom:12px;}
.del-title{font-family:'Playfair Display',serif;font-size:1.3rem;font-weight:900;margin-bottom:8px;}
.del-sub{color:var(--mid);font-weight:600;font-size:.9rem;margin-bottom:24px;line-height:1.5;}
.del-btns{display:flex;gap:12px;justify-content:center;}
.dbtn{padding:12px 28px;border-radius:50px;font-family:'Nunito',sans-serif;font-weight:800;font-size:.92rem;cursor:pointer;border:2.5px solid var(--dark);transition:all .15s;box-shadow:3px 3px 0 var(--dark);}
.dbtn-cancel{background:white;}.dbtn-cancel:hover{background:var(--dark);color:white;}
.dbtn-del{background:var(--coral);color:white;border-color:var(--coral);}.dbtn-del:hover{background:#c0392b;}
@media(max-width:900px){.admin-stats{grid-template-columns:1fr 1fr;}.form-grid{grid-template-columns:1fr;}.form-group.full{grid-column:1;}.form-divider{grid-column:1;}}
@media(max-width:600px){.table-section-header{flex-direction:column;align-items:flex-start;}.table-search{width:100%;}}
</style>
@endpush

@section('content')
<div class="section">
<div class="admin-wrap">

  <div class="admin-page-header">
    <div class="section-tag" style="background:var(--lavender);">⚙ Admin</div>
    <h2>Product Dashboard</h2>
  </div>

  <div class="admin-stats">
    <div class="stat-card"><div class="stat-emoji">🧵</div><div class="stat-value">{{ $products->count() }}</div><div class="stat-label">Products</div></div>
    <div class="stat-card"><div class="stat-emoji">📦</div><div class="stat-value">{{ $totalOrders }}</div><div class="stat-label">Orders</div></div>
    <div class="stat-card"><div class="stat-emoji">💰</div><div class="stat-value">₹{{ number_format($totalRevenue,0) }}</div><div class="stat-label">Revenue</div></div>
    <div class="stat-card"><div class="stat-emoji">⚠️</div><div class="stat-value">{{ $lowStock }}</div><div class="stat-label">Low Stock</div></div>
  </div>

  {{-- PRODUCTS TABLE --}}
  <div class="table-section">
    <div class="table-section-header">
      <div class="table-section-title">📋 All Products</div>
      <input type="text" class="table-search" placeholder="🔍 Search products…" oninput="filterTable(this.value)" />
    </div>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead><tr><th>Image</th><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody id="productTableBody">
          @foreach($products as $product)
            <tr data-search="{{ strtolower($product->name.' '.$product->category) }}">
              <td>
                @if($product->image)
                  <img src="{{ asset('storage/'.$product->image) }}" class="product-thumb"
                       onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                  <div class="product-thumb-ph" style="display:none;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
                @else
                  <div class="product-thumb-ph"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
                @endif
              </td>
              <td><strong>{{ $product->name }}</strong></td>
              <td>{{ $product->category }}</td>
              <td><strong>₹{{ number_format($product->price,2) }}</strong></td>
              <td>{{ $product->stock }}</td>
              <td>
                @if($product->stock===0)<span class="stock-badge stock-out">Out of Stock</span>
                @elseif($product->stock<=3)<span class="stock-badge stock-low">Low Stock</span>
                @else<span class="stock-badge stock-in">In Stock</span>@endif
              </td>
              <td>
                <div class="action-btns">
                    <button type="button" class="act-btn act-edit"
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
                    <form action="{{ route('admin.products.restock',$product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="act-btn act-restock">📦 +5</button>
                    </form>
                    <button type="button" class="act-btn act-del"
                        onclick="openDel({{ $product->id }},'{{ addslashes($product->name) }}')">🗑 Delete</button>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="table-empty" id="tableEmpty"><div style="font-size:2.5rem;margin-bottom:8px;">🔍</div><div>No products match your search.</div></div>
    </div>
  </div>

  {{-- CATEGORY MANAGER --}}
  <div class="form-section">
    <div class="form-section-title">🏷 Manage Categories</div>
    <div class="cat-grid">
      @foreach($categories as $cat)
        <div class="cat-chip" style="background:{{ $cat->color }}">
          {{ $cat->name }}
          <form action="{{ route('admin.categories.destroy',$cat->id) }}" method="POST" style="display:inline;">
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
          <input type="text" name="name" id="catInput" class="cat-add-input" placeholder="New category name…" value="{{ old('name') }}" />
          <div class="ferr" id="catErr">@error('name'){{ $message }}@enderror</div>
        </div>
        <select name="color" class="form-select" style="width:auto;min-width:130px;">
          <option value="#FFE8D6">🍑 Peach</option>
          <option value="#E8F8F5">🌿 Mint</option>
          <option value="#F5E8FF">💜 Lavender</option>
          <option value="#FFE8F0">🌸 Rose</option>
          <option value="#FFFDE8">🌟 Yellow</option>
          <option value="#D6EAF8">💙 Blue</option>
        </select>
        <button type="button" class="cat-add-btn" onclick="submitCat()">+ Add Category</button>
      </div>
    </form>
  </div>

  {{-- ADD PRODUCT --}}
  <div class="form-section">
    <div class="form-section-title">➕ Add New Product</div>
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="addForm" novalidate>
      @csrf
      <div class="form-grid">
        <div class="form-divider"><span>Basic Info</span></div>
        <div class="form-group">
          <label class="form-label">Product Name *</label>
          <input class="form-input" name="name" id="a_name" value="{{ old('name') }}" placeholder="e.g. Floral Hoop Art" />
          <div class="ferr" id="ae_name">@error('name'){{ $message }}@enderror</div>
        </div>
        <div class="form-group">
          <label class="form-label">Price (₹) *</label>
          <input class="form-input" name="price" id="a_price" type="number" step="0.01" min="0" value="{{ old('price') }}" placeholder="24.99" />
          <div class="ferr" id="ae_price">@error('price'){{ $message }}@enderror</div>
        </div>
        <div class="form-group">
          <label class="form-label">Category *</label>
          <select class="form-select" name="category" id="a_category">
            <option value="">— Select category —</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->name }}" {{ old('category')==$cat->name?'selected':'' }}>{{ $cat->name }}</option>
            @endforeach
          </select>
          <div class="ferr" id="ae_category">@error('category'){{ $message }}@enderror</div>
        </div>
        <div class="form-group">
          <label class="form-label">Stock Qty *</label>
          <input class="form-input" name="stock" id="a_stock" type="number" min="0" value="{{ old('stock') }}" placeholder="10" />
          <div class="ferr" id="ae_stock">@error('stock'){{ $message }}@enderror</div>
        </div>
        <div class="form-divider"><span>Media &amp; Visual</span></div>
        <div class="form-group full">
          <label class="form-label">Product Image</label>
          <div class="img-upload-area" id="aUpArea">
            <input type="file" name="image" id="aImgInput" accept="image/*"
                   onchange="previewImg(event,'aPreviewWrap','aPlaceholder','aImgEl','aImgName')" />
            <div id="aPlaceholder"><div class="upload-icon">📸</div><div class="upload-title">Click or drag & drop</div><div class="upload-sub">JPG · PNG · WEBP · max 2 MB</div></div>
            <div class="img-preview-wrap" id="aPreviewWrap">
              <img class="img-preview" id="aImgEl" src="" alt="" />
              <div class="img-preview-name" id="aImgName"></div>
              <button type="button" class="img-remove-btn" onclick="removeImg('aImgInput','aPreviewWrap','aPlaceholder')">✕ Remove</button>
            </div>
          </div>
          <div class="ferr" id="ae_image">@error('image'){{ $message }}@enderror</div>
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
          <input class="form-input" name="badge" value="{{ old('badge') }}" placeholder="Bestseller, New, Sale…" />
        </div>
        <div class="form-divider"><span>Description</span></div>
        <div class="form-group full">
          <label class="form-label">Product Description *</label>
          <textarea class="form-textarea" name="description" id="a_description" placeholder="Describe this piece…">{{ old('description') }}</textarea>
          <div class="ferr" id="ae_description">@error('description'){{ $message }}@enderror</div>
        </div>
      </div>
      <button type="button" class="form-submit" onclick="validateAdd()">✨ Add Product</button>
    </form>
  </div>

</div>
</div>

{{-- EDIT MODAL --}}
<div class="modal-overlay" id="editOverlay" onclick="closeEditOuter(event)">
  <div class="modal-box">
    <div class="modal-header">
      <div class="modal-title">✏ Edit Product</div>
      <button type="button" class="modal-close" onclick="closeEdit()">✕</button>
    </div>
    <div class="modal-body">
      <form id="editForm" method="POST" enctype="multipart/form-data" action="" novalidate>
        @csrf <input type="hidden" name="_method" value="PATCH" />
        <div class="form-grid">
          <div class="form-divider"><span>Basic Info</span></div>
          <div class="form-group"><label class="form-label">Name *</label><input class="form-input" name="name" id="e_name" /><div class="ferr" id="ee_name"></div></div>
          <div class="form-group"><label class="form-label">Price (₹) *</label><input class="form-input" name="price" id="e_price" type="number" step="0.01" min="0" /><div class="ferr" id="ee_price"></div></div>
          <div class="form-group"><label class="form-label">Category *</label>
            <select class="form-select" name="category" id="e_category">
              @foreach($categories as $cat)<option value="{{ $cat->name }}">{{ $cat->name }}</option>@endforeach
            </select><div class="ferr" id="ee_category"></div>
          </div>
          <div class="form-group"><label class="form-label">Stock *</label><input class="form-input" name="stock" id="e_stock" type="number" min="0" /><div class="ferr" id="ee_stock"></div></div>
          <div class="form-divider"><span>Image</span></div>
          <div class="form-group full">
            <div class="edit-img-row">
              <img class="edit-cur-img" id="eCurImg" src="" alt="" style="display:none;" />
              <div id="eNoImg" style="font-size:.85rem;font-weight:700;color:var(--mid);align-self:center;">No image</div>
              <div style="flex:1;">
                <div style="font-size:.75rem;font-weight:700;color:var(--mid);margin-bottom:6px;">Replace image</div>
                <div class="img-upload-area" id="eUpArea" style="padding:14px;">
                  <input type="file" name="image" id="eImgInput" accept="image/*"
                         onchange="previewImg(event,'ePreviewWrap','ePlaceholder','eImgEl','eImgName')" />
                  <div id="ePlaceholder"><div class="upload-icon" style="font-size:1.4rem;">📸</div><div class="upload-title" style="font-size:.82rem;">Click or drag</div></div>
                  <div class="img-preview-wrap" id="ePreviewWrap">
                    <img class="img-preview" id="eImgEl" src="" alt="" style="width:70px;height:70px;" />
                    <div class="img-preview-name" id="eImgName"></div>
                    <button type="button" class="img-remove-btn" onclick="removeImg('eImgInput','ePreviewWrap','ePlaceholder')">✕ Remove</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group"><label class="form-label">Color</label>
            <select class="form-select" name="color" id="e_color">
              <option value="#FFE8D6">🍑 Peach</option><option value="#E8F8F5">🌿 Mint</option>
              <option value="#F5E8FF">💜 Lavender</option><option value="#FFE8F0">🌸 Rose</option>
              <option value="#FFFDE8">🌟 Yellow</option>
            </select>
          </div>
          <div class="form-group"><label class="form-label">Badge</label><input class="form-input" name="badge" id="e_badge" /></div>
          <div class="form-divider"><span>Description</span></div>
          <div class="form-group full"><label class="form-label">Description *</label><textarea class="form-textarea" name="description" id="e_description"></textarea><div class="ferr" id="ee_description"></div></div>
        </div>
        <div style="display:flex;gap:12px;margin-top:20px;flex-wrap:wrap;">
          <button type="button" class="form-submit" onclick="validateEdit()">💾 Save Changes</button>
          <button type="button" onclick="closeEdit()" style="padding:14px 28px;background:white;border:2.5px solid var(--dark);border-radius:50px;font-family:'Nunito',sans-serif;font-weight:800;cursor:pointer;box-shadow:3px 3px 0 var(--dark);">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- DELETE CONFIRM --}}
<div class="del-overlay" id="delOverlay">
  <div class="del-box">
    <div class="del-icon">🗑️</div>
    <div class="del-title">Delete Product?</div>
    <div class="del-sub" id="delSub">This cannot be undone.</div>
    <div class="del-btns">
      <button class="dbtn dbtn-cancel" onclick="closeDel()">Cancel</button>
      <button class="dbtn dbtn-del" onclick="confirmDel()">Yes, Delete</button>
    </div>
  </div>
</div>
<form id="delForm" method="POST" style="display:none;">@csrf @method('DELETE')</form>

@endsection

@push('scripts')
<script>
function filterTable(q){q=q.toLowerCase().trim();let v=0;document.querySelectorAll('#productTableBody tr').forEach(r=>{const m=!q||(r.dataset.search||'').includes(q);r.style.display=m?'':'none';if(m)v++;});document.getElementById('tableEmpty').style.display=v===0?'block':'none';}
function previewImg(ev,wId,phId,iId,nId){const f=ev.target.files[0];if(f)showFile(f,wId,phId,iId,nId);}
function showFile(f,wId,phId,iId,nId){const r=new FileReader();r.onload=e=>{document.getElementById(iId).src=e.target.result;document.getElementById(nId).textContent=f.name;document.getElementById(phId).style.display='none';document.getElementById(wId).style.display='flex';};r.readAsDataURL(f);}
function removeImg(iId,wId,phId){document.getElementById(iId).value='';document.getElementById(wId).style.display='none';document.getElementById(phId).style.display='block';}
function setE(id,eid,msg){const el=document.getElementById(id);const em=document.getElementById(eid);if(el)el.classList.add('is-invalid');if(em)em.textContent=msg;}
function clrE(id,eid){const el=document.getElementById(id);const em=document.getElementById(eid);if(el){el.classList.remove('is-invalid');el.classList.add('is-valid');}if(em)em.textContent='';}
function validateAdd(){let ok=true;['a_name','a_price','a_category','a_stock','a_description'].forEach(id=>{const el=document.getElementById(id);if(el){el.classList.remove('is-invalid','is-valid');}const em=document.getElementById('ae_'+id.substring(2));if(em)em.textContent='';});
const n=document.getElementById('a_name').value.trim();const p=document.getElementById('a_price').value.trim();const c=document.getElementById('a_category').value;const s=document.getElementById('a_stock').value.trim();const d=document.getElementById('a_description').value.trim();
if(!n){setE('a_name','ae_name','Name required.');ok=false;}else clrE('a_name','ae_name');
if(!p||isNaN(p)||parseFloat(p)<0){setE('a_price','ae_price','Valid price required.');ok=false;}else clrE('a_price','ae_price');
if(!c){setE('a_category','ae_category','Select a category.');ok=false;}else clrE('a_category','ae_category');
if(s===''||isNaN(s)||parseInt(s)<0){setE('a_stock','ae_stock','Stock required.');ok=false;}else clrE('a_stock','ae_stock');
if(!d||d.length<10){setE('a_description','ae_description','At least 10 characters.');ok=false;}else clrE('a_description','ae_description');
if(ok)document.getElementById('addForm').submit();else{const f=document.querySelector('#addForm .is-invalid');if(f)f.scrollIntoView({behavior:'smooth',block:'center'});}}
function validateEdit(){let ok=true;['e_name','e_price','e_category','e_stock','e_description'].forEach(id=>{const el=document.getElementById(id);if(el){el.classList.remove('is-invalid','is-valid');}const em=document.getElementById('ee_'+id.substring(2));if(em)em.textContent='';});
const n=document.getElementById('e_name').value.trim();const p=document.getElementById('e_price').value.trim();const c=document.getElementById('e_category').value;const s=document.getElementById('e_stock').value.trim();const d=document.getElementById('e_description').value.trim();
if(!n||n.length<3){setE('e_name','ee_name','At least 3 chars.');ok=false;}else clrE('e_name','ee_name');
if(!p||isNaN(p)||parseFloat(p)<0){setE('e_price','ee_price','Valid price required.');ok=false;}else clrE('e_price','ee_price');
if(!c){setE('e_category','ee_category','Select a category.');ok=false;}else clrE('e_category','ee_category');
if(s===''||isNaN(s)||parseInt(s)<0){setE('e_stock','ee_stock','Stock required.');ok=false;}else clrE('e_stock','ee_stock');
if(!d||d.length<10){setE('e_description','ee_description','At least 10 chars.');ok=false;}else clrE('e_description','ee_description');
if(ok)document.getElementById('editForm').submit();else{const f=document.querySelector('#editForm .is-invalid');if(f)f.scrollIntoView({behavior:'smooth',block:'center'});}}
function submitCat(){const v=document.getElementById('catInput').value.trim();const err=document.getElementById('catErr');err.textContent='';if(!v||v.length<2){err.textContent='Name must be at least 2 characters.';document.getElementById('catInput').focus();return;}document.getElementById('catForm').submit();}
function openEdit(id,p){document.getElementById('editForm').action='/admin/products/'+id;document.getElementById('e_name').value=p.name||'';document.getElementById('e_price').value=p.price||'';document.getElementById('e_category').value=p.category||'';document.getElementById('e_stock').value=p.stock??0;document.getElementById('e_description').value=p.description||'';document.getElementById('e_badge').value=p.badge||'';const cs=document.getElementById('e_color');if(cs&&p.color)cs.value=p.color;const img=document.getElementById('eCurImg');const noImg=document.getElementById('eNoImg');if(p.image){img.src='/storage/'+p.image;img.style.display='block';noImg.style.display='none';}else{img.style.display='none';noImg.style.display='block';}removeImg('eImgInput','ePreviewWrap','ePlaceholder');document.getElementById('editOverlay').classList.add('open');document.body.style.overflow='hidden';setTimeout(()=>document.getElementById('e_name').focus(),300);}
function closeEdit(){document.getElementById('editOverlay').classList.remove('open');document.body.style.overflow='';}
function closeEditOuter(e){if(e.target.id==='editOverlay')closeEdit();}
let _dId=null;
function openDel(id,name){_dId=id;document.getElementById('delSub').textContent='Delete "'+name+'"? This cannot be undone.';document.getElementById('delOverlay').classList.add('open');document.body.style.overflow='hidden';}
function closeDel(){document.getElementById('delOverlay').classList.remove('open');document.body.style.overflow='';_dId=null;}
function confirmDel(){if(!_dId)return;const f=document.getElementById('delForm');f.action='/admin/products/'+_dId;f.submit();}
document.getElementById('delOverlay').addEventListener('click',function(e){if(e.target===this)closeDel();});
document.addEventListener('keydown',function(e){if(e.key==='Escape'){closeEdit();closeDel();}});
function openEditFromData(btn) {
    const p = {
        name:        btn.dataset.name,
        price:       btn.dataset.price,
        category:    btn.dataset.category,
        stock:       btn.dataset.stock,
        description: btn.dataset.description,
        badge:       btn.dataset.badge,
        color:       btn.dataset.color,
        image:       btn.dataset.image
    };
    openEdit(btn.dataset.id, p);
}
</script>
@endpush
