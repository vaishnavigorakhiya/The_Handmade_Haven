@extends('layouts.app')

@section('title', $blog->title . ' — Blog')

@push('styles')
<style>
.blog-show{max-width:900px;margin:0 auto;padding:36px 20px 72px;}
.blog-show-card{background:#fff;border:2px solid var(--border);border-radius:28px;overflow:hidden;box-shadow:8px 8px 0 rgba(58,44,35,.08);}
.blog-show-cover{width:100%;max-height:420px;object-fit:cover;background:#f6efe7;display:block;}
.blog-show-body{padding:28px;}
.blog-meta{display:flex;flex-wrap:wrap;gap:12px;align-items:center;color:var(--mid);margin-bottom:14px;}
.blog-content{line-height:1.85;color:var(--dark);}
</style>
@endpush

@section('content')
<div class="blog-show">
    <article class="blog-show-card">
        @if($blog->image)
            <img class="blog-show-cover" src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}">
        @else
            <img class="blog-show-cover" src="{{ asset('images/blog/kantha.jpg') }}" alt="{{ $blog->title }}">
        @endif

        <div class="blog-show-body">
            <div class="section-tag" style="background: var(--bg2); color: var(--p2);">📖 Article</div>
            <h1>{{ $blog->title }}</h1>
            <div class="blog-meta">
                @if($blog->tag)
                    <span>{{ $blog->tag }}</span>
                    <span>•</span>
                @endif
                <span>Published {{ $blog->created_at->format('M j, Y') }}</span>
            </div>

            <div class="blog-content">{!! nl2br(e($blog->body)) !!}</div>

            <div style="margin-top: 28px;">
                <a href="{{ route('blog.index') }}" class="btn-secondary">← Back to blog</a>
            </div>
        </div>
    </article>
</div>
@endsection