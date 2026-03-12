@extends('layouts.app')
@section('title', 'Admin Dashboard — Stitch & Bloom')

@push('styles')
<style>
  .admin-container { max-width: 1100px; margin: 0 auto; }
  .admin-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 40px; }
  .stat-card { background: white; border: 3px solid var(--dark); border-radius: 16px; padding: 20px; box-shadow: 5px 5px 0 var(--dark); text-align: center; }
  .stat-emoji { font-size: 2rem; margin-bottom: 8px; }
  .stat-value { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 900; color: var(--coral); }
  .stat-label { font-size: 0.8rem; font-weight: 800; color: var(--mid); text-transform: uppercase; letter-spacing: 0.05em; margin-top: 4px; }
  .admin-table-wrap { background: white; border: 3px solid var(--dark); border-radius: 20px; overflow: hidden; box-shadow: 6px 6px 0 var(--dark); margin-bottom: 40px; overflow-x: auto; }
  .admin-table { width: 100%; border-collapse: collapse; }
  .admin-table th { background: var(--dark); color: white; padding: 16px 20px; text-align: left; font-size: 0.85rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.07em; }
  .admin-table td { padding: 14px 20px; border-bottom: 2px solid var(--cream); font-weight: 600; vertical-align: middle; }
  .admin-table tr:last-child td { border-bottom: none; }
  .admin-table tr:hover td { background: var(--cream); }
  .product-thumb { width: 48px; height: 48px; border-radius: 10px; border: 2px solid var(--dark); object-fit: cover; }
  .product-thumb-emoji { width: 48px; height: 48px; border-radius: 10px; border: 2px solid var(--dark); display: flex; align-items: center; justify-content: center; font-size: 1.6rem; }
  .stock-badge { padding: 4px 12px; border-radius: 50px; font-size: 0.78rem; font-weight: 800; border: 2px solid var(--dark); }
  .stock-in { background: var(--green); }
  .stock-low { background: var(--gold); }
  .stock-out { background: var(--coral); color: white; border-color: var(--coral); }
  .action-btns { display: flex; gap: 8px; flex-wrap: wrap; }
  .edit-btn, .del-btn { padding: 6px 14px; border-radius: 50px; font-family: 'Nunito', sans-serif; font-size: 0.8rem; font-weight: 800; cursor: pointer; border: 2px solid var(--dark); transition: all 0.15s; }
  .edit-btn { background: var(--lavender); }
  .edit-btn:hover { background: var(--dark); color: white; }
  .del-btn { background: var(--coral); color: white; border-color: var(--coral); }
  .del-btn:hover { background: #c0392b; }

  /* ADD PRODUCT FORM */
  .add-product-section { background: white; border: 3px solid var(--dark); border-radius: 20px; padding: 32px; box-shadow: 6px 6px 0 var(--dark); }
  .add-product-section h3 { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 800; margin-bottom: 24px; }
  .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
  .form-group { display: flex; flex-direction: column; gap: 6px; }
  .form-group.full { grid-column: 1 / -1; }
  .form-label { font-size: 0.85rem; font-weight: 800; color: var(--mid); text-transform: uppercase; letter-spacing: 0.05em; }
  .form-input, .form-select, .form-textarea { padding: 12px 16px; border: 2.5px solid var(--dark); border-radius: 12px; font-family: 'Nunito', sans-serif; font-size: 0.95rem; font-weight: 600; background: var(--cream); outline: none; transition: border-color 0.2s; }
  .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: var(--coral); background: white; }
  .form-textarea { resize: vertical; min-height: 80px; }
  .form-error { color: var(--coral); font-size: 0.8rem; font-weight: 700; }
  .form-submit { margin-top: 20px; padding: 14px 36px; background: var(--teal); color: var(--dark); border: 3px solid var(--dark); border-radius: 50px; font-family: 'Nunito', sans-serif; font-size: 1rem; font-weight: 800; cursor: pointer; box-shadow: 4px 4px 0 var(--dark); transition: all 0.15s; }
  .form-submit:hover { transform: translate(-2px, -2px); box-shadow: 6px 6px 0 var(--dark); }

  /* IMAGE UPLOAD */
  .image-upload-area {
    border: 2.5px dashed var(--dark); border-radius: 16px;
    background: var(--cream); padding: 24px;
    text-align: center; cursor: pointer; transition: all 0.2s;
    position: relative; overflow: hidden;
  }
  .image-upload-area:hover { border-color: var(--coral); background: #FFF0EC; }
  .image-upload-area.dragover { border-color: var(--teal); background: #E8F8F5; transform: scale(1.01); }
  .image-upload-area input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
  .upload-icon { font-size: 2.5rem; margin-bottom: 8px; }
  .upload-title { font-weight: 800; font-size: 0.95rem; margin-bottom: 4px; }
  .upload-sub { font-size: 0.8rem; color: var(--mid); font-weight: 600; }
  .image-preview-wrap { display: none; flex-direction: column; align-items: center; gap: 10px; }
  .image-preview { width: 120px; height: 120px; object-fit: cover; border-radius: 12px; border: 3px solid var(--dark); box-shadow: 4px 4px 0 var(--dark); }
  .image-preview-name { font-size: 0.82rem; font-weight: 700; color: var(--mid); }
  .remove-preview { background: var(--coral); color: white; border: none; border-radius: 50px; padding: 4px 14px; font-size: 0.8rem; font-weight: 800; cursor: pointer; }

  /* SECTION DIVIDER */
  .form-section-divider { grid-column: 1/-1; display: flex; align-items: center; gap: 12px; margin: 8px 0 4px; }
  .form-section-divider span { font-size: 0.78rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--mid); white-space: nowrap; }
  .form-section-divider::before, .form-section-divider::after { content:''; flex:1; height:2px; background: var(--cream); border-radius:2px; }

  @media (max-width: 900px) { .admin-stats { grid-template-columns: 1fr 1fr; } .form-grid { grid-template-columns: 1fr; } .form-group.full { grid-column: 1; } .form-section-divider { grid-column:1; } }
</style>
@endpush

@section('content')

<div class="section">
  <div class="admin-container">

    {{-- Header --}}
    <div style="margin-bottom: 36px;">
      <div class="section-tag" style="background: var(--lavender); display:inline-block; margin-bottom:8px;">⚙ Admin</div>
      <h2 style="font-family:'Playfair Display',serif; font-size:2rem; font-weight:900;">Dashboard</h2>
    </div>

    {{-- Stats --}}
    <div class="admin-stats">
      <div class="stat-card">
        <div class="stat-emoji">🧵</div>
        <div class="stat-value">{{ $products->count() }}</div>
        <div class="stat-label">Products</div>
      </div>
      <div class="stat-card">
        <div class="stat-emoji">📦</div>
        <div class="stat-value">{{ $totalOrders }}</div>
        <div class="stat-label">Orders</div>
      </div>
      <div class="stat-card">
        <div class="stat-emoji">💰</div>
        <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
        <div class="stat-label">Revenue</div>
      </div>
      <div class="stat-card">
        <div class="stat-emoji">⚠️</div>
        <div class="stat-value">{{ $lowStock }}</div>
        <div class="stat-label">Low Stock</div>
      </div>
    </div>

    {{-- Products Table --}}
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $product)
            <tr>
              <td>
                @if($product->image)
                  <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-thumb" />
                @else
                  <div class="product-thumb-emoji" style="background:{{ $product->color }}">{{ $product->emoji }}</div>
                @endif
              </td>
              <td><strong>{{ $product->name }}</strong></td>
              <td>{{ $product->category }}</td>
              <td><strong>${{ number_format($product->price, 2) }}</strong></td>
              <td>{{ $product->stock }}</td>
              <td>
                @if($product->stock === 0)
                  <span class="stock-badge stock-out">Out of Stock</span>
                @elseif($product->stock <= 3)
                  <span class="stock-badge stock-low">Low Stock</span>
                @else
                  <span class="stock-badge stock-in">In Stock</span>
                @endif
              </td>
              <td>
                <div class="action-btns">
                  <form action="{{ route('admin.products.restock', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="edit-btn">📦 Restock</button>
                  </form>
                  <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                        onsubmit="return confirm('Delete {{ $product->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="del-btn">🗑 Delete</button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Add Product Form --}}
    <div class="add-product-section">
      <h3>➕ Add New Product</h3>

      <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-grid">

          {{-- Basic Info --}}
          <div class="form-section-divider"><span>Basic Info</span></div>

          <div class="form-group">
            <label class="form-label">Product Name *</label>
            <input class="form-input" name="name" value="{{ old('name') }}" placeholder="e.g. Floral Hoop Art" required />
            @error('name') <span class="form-error">{{ $message }}</span> @enderror
          </div>
          <div class="form-group">
            <label class="form-label">Price ($) *</label>
            <input class="form-input" name="price" type="number" step="0.01" value="{{ old('price') }}" placeholder="24.99" required />
            @error('price') <span class="form-error">{{ $message }}</span> @enderror
          </div>
          <div class="form-group">
            <label class="form-label">Category *</label>
            <select class="form-select" name="category" required>
              <option value="Embroidery Hoop">Embroidery Hoop</option>
              <option value="Pillowcase">Pillowcase</option>
              <option value="Sofa Cover">Sofa Cover</option>
              <option value="Custom">Custom</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Stock Qty *</label>
            <input class="form-input" name="stock" type="number" value="{{ old('stock') }}" placeholder="10" required />
            @error('stock') <span class="form-error">{{ $message }}</span> @enderror
          </div>

          {{-- Visual Identity --}}
          <div class="form-section-divider"><span>Visual Identity</span></div>

          {{-- IMAGE UPLOAD --}}
          <div class="form-group full">
            <label class="form-label">Product Image <span style="color:var(--teal)">(Recommended: 800×800px, JPG/PNG/WEBP)</span></label>
            <div class="image-upload-area" id="uploadArea"
                 ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)">
              <input type="file" name="image" id="imageInput" accept="image/*" onchange="previewImage(event)" />
              <div id="uploadPlaceholder">
                <div class="upload-icon">📸</div>
                <div class="upload-title">Click to upload or drag & drop</div>
                <div class="upload-sub">JPG, PNG, WEBP · Max 2MB · Recommended 800×800px</div>
              </div>
              <div class="image-preview-wrap" id="imagePreviewWrap">
                <img id="imagePreview" class="image-preview" src="" alt="Preview" />
                <div class="image-preview-name" id="imagePreviewName"></div>
                <button type="button" class="remove-preview" onclick="removeImage()">Remove Image</button>
              </div>
            </div>
            @error('image') <span class="form-error">{{ $message }}</span> @enderror
          </div>

          <div class="form-group">
            <label class="form-label">Emoji Icon <span style="color:var(--mid);font-size:0.75rem;font-weight:600;">(shown when no image)</span></label>
            <input class="form-input" name="emoji" value="{{ old('emoji') }}" placeholder="🌸" />
          </div>
          <div class="form-group">
            <label class="form-label">Card Color Theme</label>
            <select class="form-select" name="color">
              <option value="#FFE8D6">🍑 Peach</option>
              <option value="#E8F8F5">🌿 Mint</option>
              <option value="#F5E8FF">💜 Lavender</option>
              <option value="#FFE8F0">🌸 Rose</option>
              <option value="#FFFDE8">🌟 Yellow</option>
            </select>
          </div>

          {{-- Description --}}
          <div class="form-section-divider"><span>Description</span></div>

          <div class="form-group full">
            <label class="form-label">Product Description *</label>
            <textarea class="form-textarea" name="description" placeholder="Describe this beautiful piece — materials, size, care instructions..." required>{{ old('description') }}</textarea>
            @error('description') <span class="form-error">{{ $message }}</span> @enderror
          </div>

        </div>
        <button type="submit" class="form-submit">✨ Add Product</button>
      </form>
    </div>

  </div>
</div>

@endsection

@push('scripts')
<script>
function previewImage(event) {
  const file = event.target.files[0];
  if (!file) return;
  showPreview(file);
}

function showPreview(file) {
  const reader = new FileReader();
  reader.onload = e => {
    document.getElementById('imagePreview').src = e.target.result;
    document.getElementById('imagePreviewName').textContent = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
    document.getElementById('uploadPlaceholder').style.display = 'none';
    document.getElementById('imagePreviewWrap').style.display = 'flex';
  };
  reader.readAsDataURL(file);
}

function removeImage() {
  document.getElementById('imageInput').value = '';
  document.getElementById('imagePreview').src = '';
  document.getElementById('uploadPlaceholder').style.display = 'block';
  document.getElementById('imagePreviewWrap').style.display = 'none';
}

function handleDragOver(e) { e.preventDefault(); document.getElementById('uploadArea').classList.add('dragover'); }
function handleDragLeave(e) { document.getElementById('uploadArea').classList.remove('dragover'); }
function handleDrop(e) {
  e.preventDefault();
  document.getElementById('uploadArea').classList.remove('dragover');
  const file = e.dataTransfer.files[0];
  if (file && file.type.startsWith('image/')) {
    const dt = new DataTransfer();
    dt.items.add(file);
    document.getElementById('imageInput').files = dt.files;
    showPreview(file);
  }
}
</script>
@endpush
