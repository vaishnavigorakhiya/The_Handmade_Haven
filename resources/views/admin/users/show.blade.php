@extends('layouts.admin')
@section('title', 'User #' . $user->id)
@section('page-name', 'User Detail')

@section('content')

<div class="admin-page-header">
  <div>
    <div class="admin-section-tag">👥 People</div>
    <div class="admin-page-title">User #{{ $user->id }}</div>
  </div>
  <a href="{{ route('admin.users.index') }}" class="sec-btn">← Back</a>
</div>

<div style="max-width:680px;">
  <div class="admin-card">
    <div class="rangoli-strip"></div>
    <div style="padding:26px;">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
        <div>
          <div class="form-label" style="margin-bottom:5px;">Name</div>
          <div style="font-weight:700;font-size:0.95rem;">{{ $user->name }}</div>
        </div>
        <div>
          <div class="form-label" style="margin-bottom:5px;">Status</div>
          <span class="pill {{ $user->is_active ? 'pill-green' : 'pill-red' }}">
            {{ $user->is_active ? 'Active' : 'Inactive' }}
          </span>
        </div>
        <div>
          <div class="form-label" style="margin-bottom:5px;">Email</div>
          <div style="font-weight:700;font-size:0.9rem;">{{ $user->email ?? '—' }}</div>
        </div>
        <div>
          <div class="form-label" style="margin-bottom:5px;">Phone</div>
          <div style="font-weight:700;font-size:0.9rem;">{{ $user->phone ?? '—' }}</div>
        </div>
        <div>
          <div class="form-label" style="margin-bottom:5px;">Joined</div>
          <div style="font-weight:600;font-size:0.85rem;color:var(--mid);">
            {{ $user->created_at->format('d M Y, h:i A') }}
          </div>
        </div>
        <div>
          <div class="form-label" style="margin-bottom:5px;">Total Orders</div>
          <div style="font-weight:700;font-size:0.9rem;">{{ $user->orders()->count() }}</div>
        </div>
      </div>

      <div style="display:flex;gap:12px;flex-wrap:wrap;">
        <form action="{{ route('admin.users.toggle', $user) }}" method="POST">
          @csrf @method('PATCH')
          <button class="admin-add-btn" style="padding:10px 20px;font-size:0.83rem;
            {{ $user->is_active ? 'background:var(--p2)' : '' }}">
            {{ $user->is_active ? '🔒 Deactivate' : '✅ Activate' }}
          </button>
        </form>
        <button class="act-btn act-del" style="padding:10px 16px;"
          onclick="openDel(
            '{{ route('admin.users.destroy', $user) }}',
            'Delete User?',
            'Delete {{ addslashes($user->name) }}? This cannot be undone.'
          )">🗑 Delete User</button>
      </div>
    </div>
  </div>
</div>

@endsection