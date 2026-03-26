@extends('layouts.admin')
@section('title', 'Contact Inquiries')
@section('page-name', 'Contact Inquiries')

@section('content')

<div class="admin-page-header">
  <div>
    <div class="admin-section-tag">📬 People</div>
    <div class="admin-page-title">Contact Inquiries</div>
  </div>
  <span style="font-size:0.82rem;font-weight:700;color:var(--mid);">
    {{ $contacts->total() }} total
  </span>
</div>

<div class="admin-card">
  <div class="rangoli-strip"></div>
  <div class="admin-card-header">
    <div class="admin-card-title">All Inquiries</div>
    <div class="admin-card-actions">
      <input class="admin-search" placeholder="🔍 Search…"
             oninput="filterTable(this.value,'contactTbody')" />
    </div>
  </div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>#</th><th>Name</th><th>Email</th>
          <th>Phone</th><th>Status</th><th>Date</th><th>Actions</th>
        </tr>
      </thead>
      <tbody id="contactTbody">
        @forelse($contacts as $contact)
          <tr data-search="{{ strtolower($contact->name.' '.$contact->email) }}"
              style="{{ $contact->status === 'new' ? 'font-weight:700' : '' }}">
            <td style="color:var(--mid)">{{ $contact->id }}</td>
            <td><strong>{{ $contact->name }}</strong></td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->phone ?? '—' }}</td>
            <td>
              @if($contact->status === 'new')<span class="pill pill-new">New</span>
              @elseif($contact->status === 'replied')<span class="pill pill-replied">Replied</span>
              @else<span class="pill pill-read">Read</span>@endif
            </td>
            <td style="color:var(--mid)">{{ $contact->created_at->format('d M Y') }}</td>
            <td>
              <a href="{{ route('admin.contacts.show', $contact) }}" class="act-btn">View</a>
              <button class="act-btn act-del"
                onclick="openDel(
                  '{{ route('admin.contacts.destroy', $contact) }}',
                  'Delete Inquiry?',
                  'This cannot be undone.'
                )">🗑</button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" style="text-align:center;padding:32px;color:var(--mid);font-weight:700;">
              No contact inquiries yet.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="table-empty" id="contactTbodyEmpty">
      <div style="font-size:2rem;margin-bottom:6px;">🔍</div>No inquiries match.
    </div>
  </div>
  @if($contacts->hasPages())
    <div style="padding:16px 20px;">{{ $contacts->links() }}</div>
  @endif
</div>

@endsection