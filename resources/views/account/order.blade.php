@extends('layouts.app')
@section('title', __('main.order_number').' '.$order->order_number)

@section('content')
<div class="container" style="max-width:800px;padding:40px 20px;">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
      <h1 style="font-size:22px;font-weight:900;margin-bottom:4px;">{{ __('main.order_number') }}: {{ $order->order_number }}</h1>
      <div style="font-size:14px;color:var(--text-muted)">{{ $order->created_at->format('d/m/Y H:i') }}</div>
    </div>
    <a href="{{ route('account.orders') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> {{ __('main.orders') }}</a>
  </div>

  {{-- STATUS --}}
  @php $cls=['pending'=>'badge-orange','confirmed'=>'badge-blue','preparing'=>'badge-blue','shipped'=>'badge-blue','delivered'=>'badge-green','cancelled'=>'badge-red']; @endphp
  <div class="card" style="margin-bottom:20px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:12px;">
    <div><div style="font-size:13px;color:var(--text-muted);margin-bottom:4px">{{ __('main.order_status') }}</div>
    <span class="badge {{ $cls[$order->status]??'badge-gray' }}" style="font-size:14px;padding:6px 14px">{{ $order->status_label[app()->getLocale()] }}</span></div>
    <div><div style="font-size:13px;color:var(--text-muted);margin-bottom:4px">{{ __('main.payment_method') }}</div>
    <strong>{{ __('main.'.$order->payment_method) }}</strong></div>
    @if($order->address)
    <div><div style="font-size:13px;color:var(--text-muted);margin-bottom:4px">{{ __('main.delivery_address') }}</div>
    <div style="font-size:14px">{{ $order->address->street }}, {{ $order->address->city }}</div></div>
    @endif
  </div>

  {{-- ITEMS --}}
  <div class="card" style="margin-bottom:20px;">
    <div class="card-header"><i class="fas fa-box"></i> {{ app()->getLocale()==='ar'?'المنتجات':'Items' }}</div>
    @foreach($order->items as $item)
    <div style="display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid var(--border)">
      @if($item->product?->image)
        <img src="{{ asset('storage/'.$item->product->image) }}" style="width:60px;height:60px;object-fit:cover;border-radius:8px">
      @else
        <div style="width:60px;height:60px;background:var(--primary-light);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--primary)"><i class="fas fa-pills"></i></div>
      @endif
      <div style="flex:1">
        <div style="font-weight:700">{{ $item->product?->name ?? app()->getLocale()==='ar'?'منتج محذوف':'Deleted product' }}</div>
        <div style="font-size:13px;color:var(--text-muted)">{{ $item->quantity }} × {{ number_format($item->price,2) }} {{ __('main.sar') }}</div>
      </div>
      <div style="font-weight:800;color:var(--primary)">{{ number_format($item->total,2) }} {{ __('main.sar') }}</div>
    </div>
    @endforeach
    <div style="margin-top:16px">
      <div class="order-row"><span>{{ __('main.subtotal') }}</span><span>{{ number_format($order->subtotal,2) }} {{ __('main.sar') }}</span></div>
      <div class="order-row"><span>{{ __('main.delivery_fee') }}</span>
        <span>{{ $order->delivery_fee == 0 ? __('main.free') : number_format($order->delivery_fee,2).' '.__('main.sar') }}</span></div>
      <div class="order-row" style="margin-top:8px"><strong>{{ __('main.total') }}</strong><strong style="color:var(--primary);font-size:18px">{{ number_format($order->total,2) }} {{ __('main.sar') }}</strong></div>
    </div>
  </div>

  {{-- PRESCRIPTION --}}
  @if($order->prescription)
  <div class="card">
    <div class="card-header"><i class="fas fa-file-prescription"></i> {{ __('main.prescriptions') }}</div>
    <a href="{{ asset('storage/'.$order->prescription->image) }}" target="_blank">
      <img src="{{ asset('storage/'.$order->prescription->image) }}" style="max-width:200px;border-radius:8px">
    </a>
  </div>
  @endif
</div>
@endsection
