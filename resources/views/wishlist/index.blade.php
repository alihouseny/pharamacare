@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'المفضلة':'Wishlist')
@section('content')
<div class="container" style="padding:40px 20px">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px">
    <h1 style="font-size:24px;font-weight:900">
      <i class="fas fa-heart" style="color:var(--danger)"></i>
      {{ app()->getLocale()==='ar'?'قائمة المفضلة':'My Wishlist' }}
      <span style="font-size:16px;color:var(--text-muted);font-weight:400">({{ $items->total() }})</span>
    </h1>
    <a href="{{ route('shop') }}" class="btn btn-outline btn-sm"><i class="fas fa-store"></i> {{ app()->getLocale()==='ar'?'تصفح المتجر':'Browse Store' }}</a>
  </div>

  @if($items->isEmpty())
    <div class="empty-state">
      <div class="empty-state-icon">💔</div>
      <h3>{{ app()->getLocale()==='ar'?'قائمة المفضلة فارغة':'Your wishlist is empty' }}</h3>
      <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top:20px">{{ app()->getLocale()==='ar'?'تصفح المنتجات':'Browse Products' }}</a>
    </div>
  @else
    <div class="products-grid">
      @foreach($items as $item)
        @if($item->product)
          @php $product = $item->product; @endphp
          <div class="product-card" style="position:relative">
            {{-- Remove from wishlist --}}
            <form action="{{ route('wishlist.toggle', $product) }}" method="POST" style="position:absolute;top:10px;{{ app()->getLocale()==='ar'?'left':'right' }}:10px;z-index:2">
              @csrf
              <button type="submit" style="background:white;border:none;border-radius:50%;width:34px;height:34px;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 2px 8px rgba(0,0,0,.15);color:var(--danger);font-size:16px">
                <i class="fas fa-heart"></i>
              </button>
            </form>

            <a href="{{ route('shop.product', $product->slug) }}" class="card-img-link">
              @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" loading="lazy">
              @else
                <div class="card-img-placeholder"><i class="fas fa-pills"></i></div>
              @endif
            </a>
            <div class="card-body">
              <div class="card-category">{{ $product->category?->name }}</div>
              <h3 class="card-title"><a href="{{ route('shop.product', $product->slug) }}">{{ $product->name }}</a></h3>
              <div class="card-footer">
                <div class="card-price">
                  <span class="price-current">{{ number_format($product->current_price,2) }} {{ __('main.sar') }}</span>
                  @if($product->sale_price)<span class="price-old">{{ number_format($product->price,2) }}</span>@endif
                </div>
                @if($product->stock < 1)
                  <span class="btn-disabled">{{ __('main.out_of_stock') }}</span>
                @else
                  <button class="btn btn-primary btn-sm add-to-cart-btn" data-id="{{ $product->id }}" data-name="{{ $product->name }}" onclick="addToCart({{ $product->id }}, this)">
                    <i class="fas fa-cart-plus"></i>
                  </button>
                @endif
              </div>
            </div>
          </div>
        @endif
      @endforeach
    </div>
    <div style="margin-top:32px">{{ $items->links() }}</div>
  @endif
</div>
@endsection
