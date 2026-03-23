@extends('layouts.admin')
@section('title', isset($blog) ? 'Edit Post' : 'New Post')
@section('page-name', isset($blog) ? 'Edit Blog Post' : 'New Blog Post')

@push('admin-styles')
<style>
.blog-form-wrap{max-width:820px;}
.word-count{font-size:0.72rem;font-weight:700;color:var(--mid);margin-top:4px;text-align:right;}
</style>
@endpush

@section('content')

<div class="blog-form-wrap">
  <div class="admin-page-header">
    <div>
      <div class="admin-section-tag">📝 Content</div>
      <div class="admin-page-title">{{ isset($blog) ? 'Edit Post' : 'New Post' }}</div>
    </div>
    <a href="#" class="sec-btn">← Back to posts</a>
  </div>

  <div class="admin-card">
    <div class="rangoli-strip"></div>
    <div class="admin-card-header">
      <div class="admin-card-title">{{ isset($blog) ? '✏ Edit: ' . Str::limit($blog->title,40) : '✍ Write New Post' }}</div>
    </div>
    <div style="padding:24px;">
      <form
        action="{{ isset($blog) ? route('admin.blog.update', $blog) : route('admin.blog.store') }}"
        method="POST"
        enctype="multipart/form-data"
        id="blogForm"
        novalidate>
        @csrf
        @if(isset($blog))
          @method('PATCH')
        @endif

        <div class="form-grid">
          <div class="form-divider"><span>Post Details</span></div>

          <div class="form-group full">
            <label class="form-label">Post Title *</label>
            <input class="form-input {{ $errors->has('title') ? 'is-invalid' : '' }}"
                   name="title" id="blogTitle"
                   value="{{ old('title', $blog->title ?? '') }}"
                   placeholder="e.g. Kantha — The Running Stitch of Bengal"
                   oninput="updateSlugPreview(this.value)" />
            <div class="ferr" id="titleErr">@error('title'){{ $message }}@enderror</div>
            <div style="font-size:0.72rem;color:var(--mid);margin-top:4px;" id="slugPreview">
              @if(isset($blog))Slug: {{ $blog->slug }}@endif
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Tag / Category</label>
            <input class="form-input"
                   name="tag"
                   value="{{ old('tag', $blog->tag ?? '') }}"
                   placeholder="e.g. Traditional Craft, Gujarat Heritage…" />
            <div class="ferr">@error('tag'){{ $message }}@enderror</div>
          </div>

          <div class="form-group">
            <label class="form-label">Status</label>
            <select class="form-select" name="published">
              <option value="1" {{ old('published', $blog->published ?? true) ? 'selected' : '' }}>🌸 Published</option>
              <option value="0" {{ !old('published', $blog->published ?? true) ? 'selected' : '' }}>🙈 Draft</option>
            </select>
          </div>

          <div class="form-divider"><span>Cover Image</span></div>

          <div class="form-group full">
            <label class="form-label">Cover Image</label>
            @if(isset($blog) && $blog->image)
              <div style="display:flex;align-items:flex-start;gap:14px;background:var(--cream);border-radius:12px;padding:14px;margin-bottom:10px;">
                <img src="{{ asset('storage/'.$blog->image) }}"
                     alt="Current image"
                     style="width:80px;height:60px;object-fit:cover;border-radius:8px;border:2px solid var(--dark);" />
                <div>
                  <div style="font-size:0.75rem;font-weight:700;color:var(--mid);margin-bottom:5px;">Current image</div>
                  <div style="font-size:0.72rem;color:var(--mid)">Upload below to replace it</div>
                </div>
              </div>
            @endif
            <div class="img-upload-area">
              <input type="file" name="image" id="blogImgInput" accept="image/*"
                     onchange="previewImg(event,'bPreviewWrap','bPlaceholder','bImgEl','bImgName')" />
              <div id="bPlaceholder">
                <div style="font-size:2rem;margin-bottom:5px;">🖼</div>
                <div style="font-weight:800;font-size:0.85rem;margin-bottom:2px;">Click or drag & drop</div>
                <div style="font-size:0.72rem;color:var(--mid)">JPG · PNG · WEBP · max 2 MB</div>
              </div>
              <div class="img-preview-wrap" id="bPreviewWrap">
                <img class="img-preview" id="bImgEl" src="" alt="" />
                <div style="font-size:0.72rem;font-weight:700;color:var(--mid)" id="bImgName"></div>
                <button type="button" class="img-remove-btn"
                        onclick="removeImg('blogImgInput','bPreviewWrap','bPlaceholder')">✕ Remove</button>
              </div>
            </div>
            <div class="ferr">@error('image'){{ $message }}@enderror</div>
          </div>

          <div class="form-divider"><span>Content</span></div>

          <div class="form-group full">
            <label class="form-label">Body *</label>
            <textarea class="form-textarea {{ $errors->has('body') ? 'is-invalid' : '' }}"
                      name="body" id="blogBody"
                      style="min-height:320px;"
                      placeholder="Write your blog post here… Plain text or basic HTML is supported."
                      oninput="updateWordCount(this)">{{ old('body', $blog->body ?? '') }}</textarea>
            <div class="ferr" id="bodyErr">@error('body'){{ $message }}@enderror</div>
            <div class="word-count" id="wordCount">0 words</div>
          </div>
        </div>

        <div style="display:flex;gap:12px;margin-top:24px;flex-wrap:wrap;align-items:center;">
          <button type="button" class="form-submit" onclick="validateBlogForm()">
            {{ isset($blog) ? '💾 Save Changes' : '🌸 Publish Post' }}
          </button>
          <a href="#"
             style="padding:12px 26px;background:white;border:2.5px solid var(--dark);border-radius:50px;font-family:'Nunito',sans-serif;font-weight:800;cursor:pointer;box-shadow:3px 3px 0 var(--dark);text-decoration:none;color:var(--dark);display:inline-block;">
            Cancel
          </a>
        </div>

      </form>
    </div>
  </div>
</div>

@endsection

@push('admin-scripts')
<script>
function slugify(str){
  return str.toLowerCase().trim()
    .replace(/[^\w\s-]/g,'').replace(/[\s_-]+/g,'-').replace(/^-+|-+$/g,'');
}
function updateSlugPreview(val){
  const el=document.getElementById('slugPreview');
  if(el)el.textContent='Slug preview: '+slugify(val);
}
function updateWordCount(el){
  const words=el.value.trim().split(/\s+/).filter(w=>w.length>0);
  const wc=document.getElementById('wordCount');
  if(wc)wc.textContent=words.length+' word'+(words.length!==1?'s':'');
}
function validateBlogForm(){
  let ok=true;
  const title=document.getElementById('blogTitle');
  const body=document.getElementById('blogBody');
  const te=document.getElementById('titleErr');
  const be=document.getElementById('bodyErr');
  title.classList.remove('is-invalid');body.classList.remove('is-invalid');
  if(te)te.textContent='';if(be)be.textContent='';
  if(!title.value.trim()||title.value.trim().length<3){
    title.classList.add('is-invalid');if(te)te.textContent='Title must be at least 3 characters.';ok=false;
  }
  if(!body.value.trim()||body.value.trim().length<10){
    body.classList.add('is-invalid');if(be)be.textContent='Body must be at least 10 characters.';ok=false;
  }
  if(ok)document.getElementById('blogForm').submit();
  else{const f=document.querySelector('#blogForm .is-invalid');if(f)f.scrollIntoView({behavior:'smooth',block:'center'});}
}
/* init word count */
document.addEventListener('DOMContentLoaded',function(){
  const body=document.getElementById('blogBody');
  if(body)updateWordCount(body);
});
</script>
@endpush
