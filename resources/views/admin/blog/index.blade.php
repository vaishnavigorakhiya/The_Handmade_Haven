@extends('layouts.app')

@section('title', 'Blog — 🪡 Soochikaari')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,400&family=Lato:wght@300;400&display=swap" rel="stylesheet">
<style>
.blog-page *, .blog-page *::before, .blog-page *::after { box-sizing: border-box; }
.blog-page { font-family: 'Lato', sans-serif; color: #555; }
.blog-header {
    background: #d4c5a9;
    text-align: center;
    padding: 52px 20px 48px;
    position: relative;
    overflow: hidden;
}
.blog-header::before {
    content: '✦  ✦  ✦';
    display: block;
    font-size: .65rem;
    letter-spacing: .35em;
    color: #8a7260;
    margin-bottom: 18px;
}
.blog-header-eyebrow {
    font-size: .68rem; letter-spacing: .28em;
    text-transform: uppercase; color: #8a7260;
    margin-bottom: 14px; display: block;
}
.blog-header h1 {
    font-family: 'Playfair Display', serif;
    font-style: italic; font-weight: 400;
    font-size: clamp(2rem, 4.5vw, 3rem);
    color: #3d3529; line-height: 1.2;
    margin-bottom: 16px; letter-spacing: .01em;
}
.blog-header h1 span { font-style: normal; font-weight: 600; }
.blog-header-desc {
    font-size: .85rem; line-height: 1.75;
    color: #6b5d4f; max-width: 540px;
    margin: 0 auto 28px; font-weight: 300;
}
.header-divider {
    width: 48px; height: 1.5px;
    background: #8a7260; margin: 0 auto 28px;
}
.subscribe-label {
    font-size: .68rem; letter-spacing: .2em;
    text-transform: uppercase; color: #8a7260;
    margin-bottom: 12px; display: block;
}
.subscribe-form { display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; }
.subscribe-form input {
    padding: 9px 16px; border: 1px solid #b8a88a;
    background: rgba(255,255,255,.6);
    font-family: 'Lato', sans-serif; font-size: .78rem;
    color: #555; outline: none; min-width: 155px;
}
.subscribe-form input::placeholder { color: #aaa; }
.subscribe-form .btn-sub {
    padding: 9px 22px; background: #8a9e7a; border: none; color: #fff;
    font-family: 'Lato', sans-serif; font-size: .68rem;
    letter-spacing: .2em; text-transform: uppercase; cursor: pointer;
    transition: background .2s;
}
.subscribe-form .btn-sub:hover { background: #6f8361; }

/* ── BLOG ROWS ─── */
.blog-posts { max-width: 1080px; margin: 0 auto; }

.post-row {
    display: grid; grid-template-columns: 1fr 1fr;
    min-height: 340px; border-bottom: 1px solid #ece8e0;
}
.post-row:last-child { border-bottom: none; }
.post-row.flipped .post-img  { order: 2; }
.post-row.flipped .post-body { order: 1; }

.post-img { overflow: hidden; }
.post-img img {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform .5s ease;
}
.post-row:hover .post-img img { transform: scale(1.03); }

.post-body {
    display: flex; flex-direction: column;
    justify-content: center; padding: 48px 52px; background: #fff;
}
.post-row:nth-child(even) .post-body { background: #f9f6f0; }

.post-tag {
    font-size: .63rem; letter-spacing: .22em;
    text-transform: uppercase; color: #8a9e7a; margin-bottom: 10px;
    display: block;
}
.post-body h3 {
    font-family: 'Playfair Display', serif;
    font-style: italic; font-weight: 400;
    font-size: 1.4rem; color: #3d3529;
    line-height: 1.35; margin-bottom: 16px;
}
.post-body p {
    font-size: .83rem; line-height: 1.85;
    color: #888; font-weight: 300; margin-bottom: 24px;
}
.btn-read {
    display: inline-block; padding: 9px 22px;
    background: #8a9e7a; color: #fff;
    font-size: .66rem; letter-spacing: .2em;
    text-transform: uppercase; text-decoration: none;
    align-self: flex-start; transition: background .2s;
}
.btn-read:hover { background: #6f8361; }

/* ── POPULAR POSTS ─── */
.popular-section { background: #6b7a5a; padding: 60px 20px 72px; }
.popular-section h2 {
    font-family: 'Playfair Display', serif;
    font-style: italic; font-weight: 400;
    font-size: 1.7rem; color: #fff;
    text-align: center; margin-bottom: 40px;
}
.popular-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px; max-width: 1080px; margin: 0 auto;
}
.pop-card { position: relative; overflow: hidden; cursor: pointer; }
.pop-card img {
    width: 100%; aspect-ratio: 4/5; object-fit: cover; display: block;
    transition: transform .5s ease; filter: brightness(.78);
}
.pop-card:hover img { transform: scale(1.05); filter: brightness(.65); }
.pop-card-info {
    position: absolute; inset: 0;
    display: flex; flex-direction: column; justify-content: flex-end;
    padding: 18px 16px;
    background: linear-gradient(to top, rgba(20,18,14,.65) 0%, transparent 55%);
}
.pop-card-info h4 {
    font-family: 'Playfair Display', serif;
    font-style: italic; font-size: .95rem;
    color: #fff; margin-bottom: 10px; line-height: 1.3;
}
.pop-card-info a {
    font-size: .6rem; letter-spacing: .18em;
    text-transform: uppercase; color: #d4c5a9;
    text-decoration: none; border-bottom: 1px solid #d4c5a9;
    padding-bottom: 2px;
}
.pop-card-info a:hover { color: #fff; border-color: #fff; }

@media (max-width: 700px) {
    .post-row, .post-row.flipped { display: flex; flex-direction: column; }
    .post-row.flipped .post-img,
    .post-row.flipped .post-body { order: unset; }
    .post-img { min-height: 240px; }
    .post-body { padding: 30px 22px; }
}
</style>
@endpush

@section('content')
<div class="blog-page">

    {{-- WELCOME HEADER --}}
    <div class="blog-header">
        <span class="blog-header-eyebrow">Soochikaari</span>
        <h1>Welcome to Our<br><span>Embroidery Blog</span></h1>
        <p class="blog-header-desc">
            Discover the rich stories, techniques, and traditions woven into every thread.
            From Bengal's Kantha to Kashmir's Kashida — explore India's most beautiful
            handcrafted embroidery arts, curated with love from our studio to you.
        </p>
    </div>

    {{-- BLOG POSTS --}}
    <section class="blog-posts">

        @php
        $posts = [
            ['flip'=>false, 'tag'=>'Traditional Craft',        
             'img'=>'kantha',   'fallback'=>'photo-1607082348824-0a96f2a4b9da',
             'title'=>'Kantha — The Running Stitch of Bengal',
             'body'=>"Kantha is one of India's oldest forms of embroidery, born from the riverine heartland of Bengal. Women layered old saris and quilted them with a simple running stitch, turning worn fabric into luminous storytelling cloth. Motifs of fish, birds, the lotus, and the tree of life dance across the surface in threads the colour of turmeric and indigo.",
             'slug'=>'kantha-embroidery'],

            ['flip'=>true,  'tag'=>'Gujarat Heritage',          'img'=>'mirror-work',  'fallback'=>'photo-1607082348824-0a96f2a4b9da',
             'title'=>'Mirror Work — Light Woven Into Fabric',
             'body'=>'Known as Shisha, mirror-work embroidery was born in the arid brilliance of Kutch and Saurashtra. Tiny convex mirrors are anchored to cloth with intricate stitches — chain, buttonhole, and herringbone — so that every movement sends light scattering like stars. Originally protective talismans, they are now the jewels of Gujarati folk dress.',
             'slug'=>'mirror-work-embroidery'],

            ['flip'=>false, 'tag'=>'Nomadic Traditions',        
             'img'=>'Rabari',       'fallback'=>'photo-1607082348824-0a96f2a4b9da',
             'title'=>'Rabari — Embroidery of the Desert Nomads',
             'body'=>'The Rabari pastoralists of Rajasthan and Gujarat have carried their needles across the Thar Desert for centuries. Dense chain stitches, mirrors, and colourful wool tassels narrate a nomadic cosmology — camels, peacocks, and geometric patterns that encode clan identity across generations.',
             'slug'=>'rabari-embroidery'],

            ['flip'=>true,  'tag'=>'Saurashtra Pride',          'img'=>'kathiyawadi',  'fallback'=>'photo-1599643477877-530eb83abc8e',
             'title'=>'Kathiyawadi — Bold Colours of the Peninsula',
             'body'=>'From the Kathiawar peninsula of Gujarat, this style bursts with crimson, emerald, and royal blue in chain and satin stitches on coarse hand-woven cloth. Floral medallions, elephant processions, and geometric borders celebrate every rite of passage — weddings, harvests, and births.',
             'slug'=>'kathiyawadi-embroidery'],

            ['flip'=>false, 'tag'=>'Karnataka Legacy',          'img'=>'Kasuti',       'fallback'=>'photo-1558769132-cb1aea458c5e',
             'title'=>'Kasuti — The Reversible Art of Karnataka',
             'body'=>'Kasuti is the traditional folk embroidery of northern Karnataka, worked in four distinct stitches so precisely that the design looks identical on both sides. Temple towers, palanquins, and lotus blooms are rendered in silk on Ilkal sarees — a GI-tagged craft practised since the Chalukya era.',
             'slug'=>'kasuti-embroidery'],

            ['flip'=>true,  'tag'=>"Punjab's Garden of Thread", 'img'=>'phulkari',     'fallback'=>'photo-1583292650898-7d22cd27ca6f',
             'title'=>'Phulkari — Flowers Blooming in Silk Floss',
             'body'=>'Phul means flower, kari means craft — and Phulkari is exactly that: a garden in thread. Women embroider the reverse side of coarse khaddar with long, overlapping darning stitches in bright silk floss, creating geometric flowers that cover the surface entirely.',
             'slug'=>'phulkari-embroidery'],

            ['flip'=>false, 'tag'=>'Himachal Heirlooms',        'img'=>'chambarumal',  'fallback'=>'photo-1617038220319-276d3cfab638',
             'title'=>'Chamba Rumal — Miniature Paintings in Thread',
             'body'=>'The Chamba Rumal of Himachal Pradesh translates the elegance of Pahari miniature painting into untwisted silk on fine muslin. Scenes from the Ramayana and Mahabharata are rendered in double satin stitch with no knots on either side — historically prized as royal gifts and temple offerings.',
             'slug'=>'chamba-rumal-embroidery'],

            ['flip'=>true,  'tag'=>"Kashmir's Crown Jewel",     'img'=>'Kashida',      'fallback'=>'photo-1606760227091-3dd870d97f1d',
             'title'=>'Kashida — The Soul of Kashmir in Every Stitch',
             'body'=>'Kashida is the centuries-old embroidery of the Kashmir Valley, worked on the finest woollen and silk grounds. The sozni needlework produces delicate floral vines — chinar leaves, irises, paisleys — while the bold aari hook fills large shawls with lush motifs that can take months or years to complete.',
             'slug'=>'kashida-embroidery'],
        ];
        @endphp

        @foreach($posts as $post)
        <article class="post-row {{ $post['flip'] ? 'flipped' : '' }}">
            <div class="post-img">
                <img src="{{ asset('images/blog/'.$post['img'].'.jpg') }}"
                     onerror="this.src='https://images.unsplash.com/{{ $post['fallback'] }}?w=700&q=80'"
                     alt="{{ $post['title'] }}">
            </div>
            <div class="post-body">
                <span class="post-tag">{{ $post['tag'] }}</span>
                <h3>{{ $post['title'] }}</h3>
                <p>{{ $post['body'] }}</p>
                <a class="btn-read" href="{{ route('blog.show', $post['slug']) }}">Read More</a>
            </div>
        </article>
        @endforeach

    </section>

    @if(isset($blogs) && $blogs->count())
    <section class="blog-posts" style="padding: 28px 0 0;">
        <div style="padding: 0 20px 22px; max-width: 1080px; margin: 0 auto;">
            <span class="blog-header-eyebrow" style="margin-bottom: 10px;">Latest from Soochikaari</span>
            <h2 style="font-family: 'Playfair Display', serif; color: #3d3529; font-size: clamp(1.6rem, 3vw, 2.2rem); margin: 0 0 8px;">{{ ($isAdminView ?? false) ? 'Manage your published and draft posts' : 'Fresh stories from the studio' }}</h2>
            <p class="blog-header-desc" style="margin: 0; max-width: 780px;">{{ ($isAdminView ?? false) ? 'Use this list to review the content currently stored in the database before you edit, publish, or unpublish a post.' : 'These posts come directly from your admin blog manager, so edits on the live server now appear here without crashing the page.' }}</p>
        </div>

        @foreach($blogs as $blog)
        <article class="post-row {{ $loop->even ? 'flipped' : '' }}">
            <div class="post-img">
                <img src="{{ $blog->image ? asset('storage/' . $blog->image) : asset('images/blog/kantha.jpg') }}" alt="{{ $blog->title }}">
            </div>
            <div class="post-body">
                <span class="post-tag">{{ $blog->tag ?: (($blog->published ?? false) ? 'Published Story' : 'Draft Post') }}</span>
                <h3>{{ $blog->title }}</h3>
                <p>{{ $blog->excerpt }}</p>
                <div style="display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
                    @if($blog->published)
                        <a class="btn-read" href="{{ route('blog.show', $blog->slug) }}">Read More</a>
                    @endif
                    @if($isAdminView ?? false)
                        <a class="btn-read" style="background:#d4956a;" href="{{ route('admin.blog.edit', $blog) }}">Edit Post</a>
                    @endif
                </div>
            </div>
        </article>
        @endforeach
    </section>
    @endif

    <section class="popular-section">
        <h2>Popular Posts</h2>
        <div class="popular-grid">
            @php
            $popular = [
                ['title'=>'Kantha Embroidery', 'img'=>'kantha',      'fallback'=>'photo-1558618666-fcd25c85cd64', 'slug'=>'kantha-embroidery'],
                ['title'=>'Mirror Work',        'img'=>'mirror-work', 'fallback'=>'photo-1607082348824-0a96f2a4b9da','slug'=>'mirror-work-embroidery'],
                ['title'=>'Phulkari',           'img'=>'phulkari',    'fallback'=>'photo-1583292650898-7d22cd27ca6f','slug'=>'phulkari-embroidery'],
                ['title'=>'Kashida',            'img'=>'kashida',     'fallback'=>'photo-1606760227091-3dd870d97f1d','slug'=>'kashida-embroidery'],
            ];
            @endphp
            @foreach($popular as $p)
            <div class="pop-card">
                <img src="{{ asset('images/blog/'.$p['img'].'.jpg') }}"
                     onerror="this.src='https://images.unsplash.com/{{ $p['fallback'] }}?w=500&q=80'"
                     alt="{{ $p['title'] }}">
                <div class="pop-card-info">
                    <h4>{{ $p['title'] }}</h4>
                    <a href="{{ route('blog.show', $p['slug']) }}">Read More</a>
                </div>
            </div>
            @endforeach
        </div>
    </section>

</div>
@endsection
