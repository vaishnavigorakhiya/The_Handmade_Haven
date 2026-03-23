@extends('layouts.admin')
@section('title', 'Blog Posts')
@section('page-name', 'Blog Posts')

@section('content')

<div class="admin-page-header">
  <div>
    <div class="admin-section-tag">📝 Content</div>
    <div class="admin-page-title">Blog Posts</div>
  </div>
  <a href="#" class="admin-add-btn">✍ New Post</a>
</div>

<div class="admin-card">
  <div class="rangoli-strip"></div>
  <div class="admin-card-header">
    <div class="admin-card-title">All Posts</div>
    <div class="admin-card-actions">
      <input class="admin-search" placeholder="🔍 Search posts…"
             oninput="filterTable(this.value,'blogTbody')" />
    </div>
  </div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Image</th><th>Title</th><th>Tag</th>
          <th>Status</th><th>Date</th><th>Actions</th>
        </tr>
      </thead>
      <tbody id="blogTbody">
        @forelse($blogs as $blog)
          <tr data-search="{{ strtolower($blog->title.' '.($blog->tag ?? '')) }}">
            <td>
              <div class="prod-thumb" style="background:var(--bg1)">
                @if($blog->image)
                  <img src="{{ asset('storage/'.$blog->image) }}" alt="{{ $blog->title }}"
                       onerror="this.style.display='none'" />
                @else
                  📝
                @endif
              </div>
            </td>
            <td>
              <strong>{{ $blog->title }}</strong>
              <div style="font-size:0.75rem;color:var(--mid);margin-top:2px;">
                {{ Str::limit(strip_tags($blog->body), 60) }}
              </div>
            </td>
            <td>
              @if($blog->tag)
                <span class="pill pill-purple">{{ $blog->tag }}</span>
              @else
                <span style="color:var(--mid);font-size:0.78rem;">—</span>
              @endif
            </td>
            <td>
              <span class="pill {{ $blog->published ? 'pill-green' : 'pill-red' }}">
                {{ $blog->published ? 'Published' : 'Draft' }}
              </span>
            </td>
            <td style="color:var(--mid)">{{ $blog->created_at->format('d M Y') }}</td>
            <td>
              <a href="{{ route('admin.blog.edit', $blog) }}" class="act-btn">✏ Edit</a>
              <form action="{{ route('admin.blog.toggle', $blog) }}" method="POST" style="display:inline">
                @csrf @method('PATCH')
                <button type="submit" class="act-btn act-teal">
                  {{ $blog->published ? '🙈 Unpublish' : '🌸 Publish' }}
                </button>
              </form>
              <button class="act-btn act-del"
                onclick="openDel(
                  '{{ route('admin.blog.destroy', $blog) }}',
                  'Delete Post?',
                  'Delete &quot;{{ addslashes($blog->title) }}&quot;? This cannot be undone.'
                )">🗑</button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" style="text-align:center;padding:40px;color:var(--mid);font-weight:700;">
              <div style="font-size:2.5rem;margin-bottom:8px;">📝</div>
              No blog posts yet.
              <a href="{{ route('admin.blog.create') }}" style="color:var(--p1);font-weight:800;display:block;margin-top:8px;">Write your first post →</a>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="table-empty" id="blogTbodyEmpty">
      <div style="font-size:2rem;margin-bottom:6px;">🔍</div>No posts match.
    </div>
  </div>
  @if($blogs->hasPages())
    <div style="padding:14px 20px;border-top:2px solid var(--bg);">
      {{ $blogs->links() }}
    </div>
  @endif
</div>

@endsection
