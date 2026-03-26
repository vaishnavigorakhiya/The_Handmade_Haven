@extends('layouts.admin')
@section('title', 'Manage Users')
@section('page-name', 'Manage Users')

@section('content')

<div class="admin-page-header">
  <div>
    <div class="admin-section-tag">👥 People</div>
    <div class="admin-page-title">Manage Users</div>
  </div>
  <span style="font-size:0.82rem;font-weight:700;color:var(--mid);">
    {{ $users->total() }} users
  </span>
</div>

<div class="admin-card">
  <div class="rangoli-strip"></div>
  <div class="admin-card-header">
    <div class="admin-card-title">All Users</div>
    <div class="admin-card-actions">
      <input class="admin-search" placeholder="🔍 Search users…"
             oninput="filterTable(this.value,'userTbody')" />
    </div>
  </div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>#</th><th>Name</th><th>Email</th>
          <th>Phone</th><th>Status</th><th>Joined</th><th>Actions</th>
        </tr>
      </thead>
      <tbody id="userTbody">
        @forelse($users as $user)
          <tr data-search="{{ strtolower($user->name.' '.($user->email ?? '').' '.($user->phone ?? '')) }}">
            <td style="color:var(--mid)">{{ $user->id }}</td>
            <td><strong>{{ $user->name }}</strong></td>
            <td>{{ $user->email ?? '—' }}</td>
            <td>{{ $user->phone ?? '—' }}</td>
            <td>
              <span class="pill {{ $user->is_active ? 'pill-green' : 'pill-red' }}">
                {{ $user->is_active ? 'Active' : 'Inactive' }}
              </span>
            </td>
            <td style="color:var(--mid)">{{ $user->created_at->format('d M Y') }}</td>
            <td>
              <a href="{{ route('admin.users.show', $user) }}" class="act-btn">View</a>
              <form action="{{ route('admin.users.toggle', $user) }}" method="POST" style="display:inline">
                @csrf @method('PATCH')
                <button type="submit" class="act-btn {{ $user->is_active ? '' : 'act-teal' }}">
                  {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                </button>
              </form>
              <button class="act-btn act-del"
                onclick="openDel(
                  '{{ route('admin.users.destroy', $user) }}',
                  'Delete User?',
                  'Delete {{ addslashes($user->name) }}? This cannot be undone.'
                )">🗑</button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" style="text-align:center;padding:32px;color:var(--mid);font-weight:700;">
              No users found.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="table-empty" id="userTbodyEmpty">
      <div style="font-size:2rem;margin-bottom:6px;">🔍</div>No users match.
    </div>
  </div>
  @if($users->hasPages())
    <div style="padding:16px 20px;">{{ $users->links() }}</div>
  @endif
</div>

@endsection