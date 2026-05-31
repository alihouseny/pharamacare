@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'حسابي':'My Account')

@section('content')
<div class="container" style="padding:40px 20px;">
  <h1 style="font-size:26px;font-weight:900;margin-bottom:8px;">
    <i class="fas fa-user-circle" style="color:var(--primary)"></i>
    {{ app()->getLocale()==='ar'?'مرحباً,':'Hello,' }} {{ auth()->user()->name }}
  </h1>
  <p style="color:var(--text-muted);margin-bottom:32px;">{{ auth()->user()->email }}</p>

  {{-- STATS --}}
  <div class="stats-grid" style="margin-bottom:32px">
    <div class="stat-card">
      <div class="stat-icon blue"><i class="fas fa-shopping-bag"></i></div>
      <div><div class="stat-value">{{ $orders->count() }}</div><div class="stat-label">{{ __('main.orders') }}</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon green"><i class="fas fa-sync-alt"></i></div>
      <div><div class="stat-value">{{ $subscriptions }}</div><div class="stat-label">{{ __('main.subscriptions') }}</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon orange"><i class="fas fa-file-prescription"></i></div>
      <div><div class="stat-value">{{ $prescriptions }}</div><div class="stat-label">{{ __('main.prescriptions') }}</div></div>
    </div>
  </div>

  {{-- QUICK LINKS --}}
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px;margin-bottom:40px;">
    <a href="{{ route('account.orders') }}" class="card" style="display:flex;align-items:center;gap:14px;padding:20px;text-decoration:none;color:inherit;transition:box-shadow .15s">
      <div class="stat-icon blue" style="width:44px;height:44px;font-size:18px;flex-shrink:0"><i class="fas fa-list-alt"></i></div>
      <div><div style="font-weight:700">{{ __('main.orders') }}</div><div style="font-size:13px;color:var(--text-muted)">{{ app()->getLocale()==='ar'?'عرض كل طلباتك':'View all your orders' }}</div></div>
    </a>
    <a href="{{ route('account.addresses') }}" class="card" style="display:flex;align-items:center;gap:14px;padding:20px;text-decoration:none;color:inherit">
      <div class="stat-icon teal" style="width:44px;height:44px;font-size:18px;flex-shrink:0"><i class="fas fa-map-marker-alt"></i></div>
      <div><div style="font-weight:700">{{ app()->getLocale()==='ar'?'عناوين التوصيل':'Delivery Addresses' }}</div><div style="font-size:13px;color:var(--text-muted)">{{ app()->getLocale()==='ar'?'إدارة عناوينك':'Manage your addresses' }}</div></div>
    </a>
    <a href="{{ route('prescriptions.index') }}" class="card" style="display:flex;align-items:center;gap:14px;padding:20px;text-decoration:none;color:inherit">
      <div class="stat-icon orange" style="width:44px;height:44px;font-size:18px;flex-shrink:0"><i class="fas fa-file-prescription"></i></div>
      <div><div style="font-weight:700">{{ __('main.prescriptions') }}</div><div style="font-size:13px;color:var(--text-muted)">{{ app()->getLocale()==='ar'?'روشيتاتي':'My prescriptions' }}</div></div>
    </a>
    <a href="{{ route('subscriptions.index') }}" class="card" style="display:flex;align-items:center;gap:14px;padding:20px;text-decoration:none;color:inherit">
      <div class="stat-icon green" style="width:44px;height:44px;font-size:18px;flex-shrink:0"><i class="fas fa-sync-alt"></i></div>
      <div><div style="font-weight:700">{{ __('main.subscriptions') }}</div><div style="font-size:13px;color:var(--text-muted)">{{ app()->getLocale()==='ar'?'اشتراكاتي':'My subscriptions' }}</div></div>
    </a>
    <a href="{{ route('profile.edit') }}" class="card" style="display:flex;align-items:center;gap:14px;padding:20px;text-decoration:none;color:inherit">
      <div class="stat-icon" style="background:#E8EAF6;width:44px;height:44px;font-size:18px;flex-shrink:0;display:flex;align-items:center;justify-content:center;border-radius:12px;color:#5C6BC0"><i class="fas fa-user-edit"></i></div>
      <div><div style="font-weight:700">{{ app()->getLocale()==='ar'?'تعديل الملف الشخصي':'Edit Profile' }}</div><div style="font-size:13px;color:var(--text-muted)">{{ app()->getLocale()==='ar'?'البيانات الشخصية':'Personal data' }}</div></div>
    </a>
  </div>

  {{-- RECENT ORDERS --}}
  @if($orders->count())
  <div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center">
      <span><i class="fas fa-clock"></i> {{ app()->getLocale()==='ar'?'آخر الطلبات':'Recent Orders' }}</span>
      <a href="{{ route('account.orders') }}" class="btn btn-outline btn-sm">{{ __('main.view_all') }}</a>
    </div>
    <table class="table">
      <thead><tr>
        <th>{{ __('main.order_number') }}</th>
        <th>{{ __('main.total') }}</th>
        <th>{{ __('main.order_status') }}</th>
        <th>{{ __('main.order_date') }}</th>
      </tr></thead>
      <tbody>
        @foreach($orders as $order)
        <tr>
          <td><a href="{{ route('account.order', $order) }}" style="color:var(--primary);font-weight:700">{{ $order->order_number }}</a></td>
          <td style="font-weight:700">{{ number_format($order->total,2) }} {{ __('main.sar') }}</td>
          <td>
            @php $cls=['pending'=>'badge-orange','confirmed'=>'badge-blue','preparing'=>'badge-blue','shipped'=>'badge-blue','delivered'=>'badge-green','cancelled'=>'badge-red']; @endphp
            <span class="badge {{ $cls[$order->status]??'badge-gray' }}">{{ $order->status_label[app()->getLocale()] }}</span>
          </td>
          <td style="font-size:13px;color:var(--text-muted)">{{ $order->created_at->format('d/m/Y') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>
@endsection
