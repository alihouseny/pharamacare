<div class="product-card" id="pcard-{{ $product->id }}">
  @if($product->sale_price)
    <span class="badge-sale">{{ app()->getLocale()==='ar'?'خصم':'Sale' }}</span>
  @endif
  @if($product->is_featured)
    <span class="badge-featured">⭐</span>
  @endif
  @if($product->requires_prescription)
    <span class="badge-rx"><i class="fas fa-prescription"></i> Rx</span>
  @endif

  <a href="{{ route('shop.product', $product->slug) }}" class="card-img-link">
    @if($product->image)
      <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" loading="lazy">
    @else
      <div class="card-img-placeholder"><i class="fas fa-pills"></i></div>
    @endif
  </a>

  <div class="card-body">
    <div class="card-category">{{ $product->category->name ?? '' }}</div>
    <h3 class="card-title">
      <a href="{{ route('shop.product', $product->slug) }}">{{ $product->name }}</a>
    </h3>
    @if($product->active_ingredient)
      <div class="card-ingredient"><i class="fas fa-atom"></i> {{ $product->active_ingredient }}</div>
    @endif
    @if($product->strength)
      <div class="card-strength">{{ $product->strength }}</div>
    @endif

    <div class="card-footer">
      <div class="card-price">
        <span class="price-current">{{ number_format($product->current_price, 2) }} {{ __('main.sar') }}</span>
        @if($product->sale_price)
          <span class="price-old">{{ number_format($product->price, 2) }}</span>
        @endif
      </div>

      @if($product->stock < 1)
        <span class="btn-disabled">{{ __('main.out_of_stock') }}</span>
      @elseif($product->requires_prescription)
        <a href="{{ route('prescriptions.create') }}" class="btn btn-rx btn-sm">
          <i class="fas fa-file-prescription"></i> Rx
        </a>
      @else
        <button class="btn btn-primary btn-sm add-to-cart-btn"
                data-id="{{ $product->id }}"
                data-name="{{ $product->name }}"
                onclick="addToCart({{ $product->id }}, this)">
          <i class="fas fa-cart-plus"></i>
        </button>
      @endif
    </div>
  </div>
</div>
