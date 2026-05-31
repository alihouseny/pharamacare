@extends('layouts.app')
@section('title', __('main.orders'))

@section('content')
<div class="container" style="padding:40px 20px;">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;">
    <h1 style="font-size:26px;font-weight:900;">
      <i class="fas fa-list-alt" style="color:var(--primary)"></i> {{ __('main.orders') }}
    </h1>
    <a href="{{ route('account.dashboard') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> {{ __('main.back') }}</a>
  </div>

  @if($orders->isEmpty())
    <div class="empty-state">
      <div class="empty-state-icon">📦</div>
      <h3>{{ app()->getLocale()==='ar'?'لا توجد طلبات بعد':'No orders yet' }}</h3>
      <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top:20px">{{ __('main.shop') }}</a>
    </div>
  @else
    <div class="card" style="padding:0;overflow:hidden">
      <table class="table">
        <thead><tr>
          <th>{{ __('main.order_number') }}</th>
          <th>{{ app()->getLocale()==='ar'?'المنتجات':'Items' }}</th>
          <th>{{ __('main.total') }}</th>
          <th>{{ __('main.order_status') }}</th>
          <th>{{ __('main.order_date') }}</th>
          <th></th>
        </tr></thead>
        <tbody>
          @foreach($orders as $order)
          <tr>
            <td style="font-weight:700;font-family:monospace">
              <a href="{{ route('account.order', $order) }}" style="color:var(--primary)">{{ $order->order_number }}</a>
            </td>
            <td style="font-size:13px">{{ $order->items->count() }} {{ app()->getLocale()==='ar'?'منتج':'item(s)' }}</td>
            <td style="font-weight:700">{{ number_format($order->total,2) }} {{ __('main.sar') }}</td>
            <td>
              @php $cls=['pending'=>'badge-orange','confirmed'=>'badge-blue','preparing'=>'badge-blue','shipped'=>'badge-blue','delivered'=>'badge-green','cancelled'=>'badge-red']; @endphp
              <span class="badge {{ $cls[$order->status]??'badge-gray' }}">{{ $order->status_label[app()->getLocale()] }}</span>
            </td>
            <td style="font-size:13px;color:var(--text-muted)">{{ $order->created_at->format('d/m/Y') }}</td>
            <td><a href="{{ route('account.order', $order) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div style="padding:16px">{{ $orders->links() }}</div>
    </div>
  @endif
</div>
@endsection
