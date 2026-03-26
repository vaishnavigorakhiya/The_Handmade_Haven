@extends('layouts.admin')
@section('title', 'Inquiry #' . $contact->id)
@section('page-name', 'Contact Inquiry')

@section('content')

<div class="admin-page-header">
  <div>
    <div class="admin-section-tag">📬 People</div>
    <div class="admin-page-title">Inquiry #{{ $contact->id }}</div>
  </div>
  <a href="{{ route('admin.contacts.index') }}" class="sec-btn">← Back</a>
</div>

<div style="max-width:680px;">
  <div class="admin-card">
    <div class="rangoli-strip"></div>
    <div style="padding:26px;">

      {{-- PERSON INFO ── --}}
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
        <div>
          <div class="form-label" style="margin-bottom:5px;">Name</div>
          <div style="font-weight:700;font-size:0.95rem;">{{ $contact->name }}</div>
        </div>
        <div>
          <div class="form-label" style="margin-bottom:5px;">Status</div>
          @if($contact->status==='new')<span class="pill pill-new">New</span>
          @elseif($contact->status==='replied')<span class="pill pill-replied">Replied</span>
          @else<span class="pill pill-read">Read</span>@endif
        </div>
        <div>
          <div class="form-label" style="margin-bottom:5px;">Email</div>
          <a href="mailto:{{ $contact->email }}"
             style="color:var(--p1);font-weight:700;font-size:0.9rem;text-decoration:none;">
            {{ $contact->email }}
          </a>
        </div>
        <div>
          <div class="form-label" style="margin-bottom:5px;">Phone</div>
          <div style="font-weight:700;font-size:0.9rem;">{{ $contact->phone ?? '—' }}</div>
        </div>
        <div style="grid-column:1/-1;">
          <div class="form-label" style="margin-bottom:5px;">Received</div>
          <div style="font-weight:600;font-size:0.85rem;color:var(--mid);">
            {{ $contact->created_at->format('d M Y, h:i A') }}
          </div>
        </div>
      </div>

      {{-- MESSAGE ── --}}
      <div style="margin-bottom:24px;">
        <div class="form-label" style="margin-bottom:8px;">Message</div>
        <div style="background:var(--bg1);border:1.5px solid var(--border);border-left:4px solid var(--p1);border-radius:0 12px 12px 0;padding:16px 18px;font-size:0.9rem;font-weight:600;line-height:1.75;color:var(--dark);">
          {{ $contact->message }}
        </div>
      </div>

      {{-- ACTIONS ── --}}
      <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
        {{-- Update Status --}}
        <form action="{{ route('admin.contacts.status', $contact) }}" method="POST"
              style="display:flex;align-items:center;gap:8px;">
          @csrf @method('PATCH')
          <select name="status" class="form-select" style="width:auto;min-width:130px;">
            <option value="new"     {{ $contact->status==='new'     ? 'selected' : '' }}>New</option>
            <option value="read"    {{ $contact->status==='read'    ? 'selected' : '' }}>Read</option>
            <option value="replied" {{ $contact->status==='replied' ? 'selected' : '' }}>Replied</option>
          </select>
          <button type="submit" class="sec-btn">Update Status</button>
        </form>

        {{-- Reply by email --}}
        <a href="mailto:{{ $contact->email }}?subject=Re: Your inquiry to Soochikaari"
           class="admin-add-btn" style="box-shadow:3px 3px 0 var(--dark);padding:10px 20px;font-size:0.83rem;">
          ✉️ Reply via Email
        </a>

        {{-- Delete --}}
        <button class="act-btn act-del"
          onclick="openDel(
            '{{ route('admin.contacts.destroy', $contact) }}',
            'Delete Inquiry?',
            'This cannot be undone.'
          )"
          style="padding:10px 16px;">🗑 Delete</button>
      </div>

    </div>
  </div>
</div>

@endsection
