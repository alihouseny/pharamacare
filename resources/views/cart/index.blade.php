@extends('layouts.app')
@section('title', __('main.your_cart'))

@section('content')
<div class="container" style="padding:40px 20px;">
  <h1 style="font-size:26px;font-weight:800;margin-bottom:28px;">
    <i class="fas fa-shopping-cart" style="color:var(--primary)"></i>
    {{ __('main.your_cart') }}
  </h1>

  @if(empty($items))
    <div class="empty-state">
      <div class="empty-state-icon">🛒</div>
      <h3>{{ __('main.cart_empty') }}</h3>
      <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top:20px">{{ __('main.continue_shopping') }}</a>
    </div>
  @else
    <div style="display:grid;grid-template-columns:1fr 340px;gap:28px;">
      <div>
        @foreach($items as $item)
        <div class="card" style="display:flex;align-items:center;gap:20px;margin-bottom:16px;padding:16px;">
          <a href="{{ route('shop.product', $item['product']->slug) }}">
            @if($item['product']->image)
              <img src="{{ asset('storage/'.$item['product']->image) }}" style="width:90px;height:90px;object-fit:cover;border-radius:10px;">
            @else
              <div style="width:90px;height:90px;background:var(--primary-light);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:32px;color:var(--primary)"><i class="fas fa-pills"></i></div>
            @endif
          </a>
          <div style="flex:1">
            <div style="font-size:12px;color:var(--primary);font-weight:600;">{{ $item['product']->category->name }}</div>
            <h3 style="font-size:16px;font-weight:700;margin:4px 0">{{ $item['product']->name }}</h3>
            @if($item['product']->active_ingredient)
              <div style="font-size:12px;color:var(--text-muted)"><i class="fas fa-atom"></i> {{ $item['product']->active_ingredient }}</div>
            @endif
          </div>
          <div style="display:flex;align-items:center;gap:12px;">
            <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" style="display:flex;align-items:center;gap:6px">
              @csrf @method('PATCH')
              <button type="submit" name="qty" value="{{ $item['qty'] - 1 }}" class="btn btn-outline btn-sm" style="padding:4px 10px">−</button>
              <span style="font-size:16px;font-weight:700;min-width:24px;text-align:center">{{ $item['qty'] }}</span>
              <button type="submit" name="qty" value="{{ $item['qty'] + 1 }}" class="btn btn-outline btn-sm" style="padding:4px 10px">+</button>
            </form>
            <span style="font-size:17px;font-weight:800;color:var(--primary);min-width:90px;text-align:end">
              {{ number_format($item['subtotal'], 2) }} {{ __('main.sar') }}
            </span>
            <a href="{{ route('cart.remove', $item['product']->id) }}" onclick="return confirm('Remove?')" style="color:var(--danger);font-size:16px"><i class="fas fa-trash-alt"></i></a>
          </div>
        </div>
        @endforeach
      </div>

      <div>
        <div class="card order-summary-card">
          <div class="card-header"><i class="fas fa-receipt"></i> {{ app()->getLocale()==='ar'?'ملخص الطلب':'Order Summary' }}</div>
          <div class="order-row"><span>{{ __('main.subtotal') }}</span><span>{{ number_format($total,2) }} {{ __('main.sar') }}</span></div>
          <div class="order-row"><span>{{ __('main.delivery_fee') }}</span>
            <span>{{ $total >= 200 ? __('main.free') : '25.00 '.__('main.sar') }}</span>
          </div>
          <div class="order-row" style="margin-top:8px">
            <strong>{{ __('main.total') }}</strong>
            <strong style="color:var(--primary)">{{ number_format($total + ($total >= 200 ? 0 : 25), 2) }} {{ __('main.sar') }}</strong>
          </div>
          <a href="{{ route('checkout') }}" class="btn btn-primary btn-block" style="margin-top:20px">
            <i class="fas fa-lock"></i> {{ __('main.checkout') }}
          </a>
          <a href="{{ route('shop') }}" class="btn btn-outline btn-block" style="margin-top:10px">
            {{ __('main.continue_shopping') }}
          </a>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection
