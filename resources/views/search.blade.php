@extends('layouts.app')
@section('title', 'Search: ' . $query . ' — Soochikaari')

@section('content')
<div class="section">
    <div class="section-header">
        <div class="section-tag" style="background: var(--bg2);">🔍 Search</div>
        <h2>
            @if($products->count() > 0)
                {{ $products->count() }} result{{ $products->count() !== 1 ? 's' : '' }} for
                "<em style="color:var(--p1);">{{ $query }}</em>"
            @else
                No results for "<em style="color:var(--p1);">{{ $query }}</em>"
            @endif
        </h2>
    </div>

    @if($products->count() > 0)
        <div class="products-grid">
            @foreach($products as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    @else
        <div style="text-align:center; padding: 60px 20px;">
            <div style="font-size: 4rem; margin-bottom: 16px;">🧵</div>
            <p style="font-size: 1.1rem; font-weight: 700; color: var(--mid); margin-bottom: 24px;">
                We couldn't find anything matching "{{ $query }}".<br>
                Try a different word or browse all products.
            </p>
            <a href="{{ route('shop') }}" class="btn-primary">Browse All Products</a>
        </div>
    @endif
</div>
@endsection