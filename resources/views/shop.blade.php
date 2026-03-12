@extends('layouts.app')
@section('title', 'Shop — All Embroidery Pieces')

@push('styles')
<style>
  .filter-bar { display: flex; gap: 10px; flex-wrap: wrap; justify-content: center; margin-bottom: 40px; }
  .filter-btn { padding: 8px 20px; border: 2.5px solid var(--dark); border-radius: 50px; background: white; font-family: 'Nunito', sans-serif; font-weight: 700; font-size: 0.9rem; cursor: pointer; box-shadow: 3px 3px 0 var(--dark); text-decoration: none; color: var(--dark); transition: all 0.15s; }
  .filter-btn:hover, .filter-btn.active { background: var(--dark); color: white; }
  .empty-state { grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--mid); font-weight: 700; font-size: 1.1rem; }
</style>
@endpush

@section('content')

<div class="section">
  <div class="section-header">
    <div class="section-tag" style="background: var(--teal);">🧵 Collection</div>
    <h2>All Embroidery Pieces</h2>
  </div>

  {{-- Category Filters --}}
  <div class="filter-bar">
    <a href="{{ route('shop') }}"
       class="filter-btn {{ !$category ? 'active' : '' }}">All</a>
    @foreach($categories as $cat)
      <a href="{{ route('shop', ['category' => $cat]) }}"
         class="filter-btn {{ $category === $cat ? 'active' : '' }}">{{ $cat }}</a>
    @endforeach
  </div>

  {{-- Products Grid --}}
  <div class="products-grid">
    @forelse($products as $product)
      @include('components.product-card', ['product' => $product])
    @empty
      <div class="empty-state">
        <div style="font-size:3rem; margin-bottom:12px;">🔍</div>
        No products found in this category.
      </div>
    @endforelse
  </div>
</div>

@endsection
