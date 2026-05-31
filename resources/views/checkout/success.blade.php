@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'تم الطلب بنجاح':'Order Placed')

@section('content')
<div class="container" style="max-width:600px;padding:60px 20px;text-align:center;">
  <div style="width:80px;height:80px;background:#E8F5E9;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:36px;color:var(--success);margin:0 auto 24px;">✓</div>
  <h1 style="font-size:28px;font-weight:900;margin-bottom:10px;">{{ app()->getLocale()==='ar'?'تم استلام طلبك!':'Order Received!' }}</h1>
  <p style="color:var(--text-muted);margin-bottom:32px;">{{ app()->getLocale()==='ar'?'سيقوم فريقنا بتجهيز طلبك والتواصل معك قريباً':'Our team will prepare your order and contact you soon' }}</p>

  @if($order)
  <div class="card" style="text-align:start;margin-bottom:32px;">
    <div style="font-size:14px;color:var(--text-muted);margin-bottom:4px">{{ __('main.order_number') }}</div>
    <div style="font-size:22px;font-weight:900;color:var(--primary);margin-bottom:16px;">{{ $order->order_number }}</div>
    <div style="display:flex;justify-content:space-between;padding:8px 0;border-top:1px solid var(--border)">
      <span style="color:var(--text-muted)">{{ __('main.total') }}</span>
      <strong>{{ number_format($order->total,2) }} {{ __('main.sar') }}</strong>
    </div>
  </div>
  @endif

  <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
    <a href="{{ route('account.orders') }}" class="btn btn-primary"><i class="fas fa-list-alt"></i> {{ __('main.orders') }}</a>
    <a href="{{ route('shop') }}" class="btn btn-outline"><i class="fas fa-shopping-bag"></i> {{ app()->getLocale()==='ar'?'مواصلة التسوق':'Continue Shopping' }}</a>
  </div>
</div>
@endsection
