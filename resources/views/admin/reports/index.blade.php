@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'التقارير':'Reports')
@section('content')
<div class="admin-layout">
  @include('admin._sidebar')
  <main class="admin-main">
    <div class="admin-topbar">
      <button class="sidebar-toggle-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
      <h1 style="font-size:20px;font-weight:800"><i class="fas fa-chart-pie" style="color:var(--primary)"></i> {{ app()->getLocale()==='ar'?'التقارير والإحصائيات':'Reports & Statistics' }}</h1>
      <div style="display:flex;gap:8px">
        <a href="{{ route('admin.reports.csv', ['from'=>$from,'to'=>$to]) }}" class="btn btn-outline btn-sm">
          <i class="fas fa-file-csv" style="color:var(--success)"></i> {{ app()->getLocale()==='ar'?'تصدير CSV':'Export CSV' }}
        </a>
        <a href="{{ route('admin.reports.low_stock') }}" class="btn btn-outline btn-sm">
          <i class="fas fa-exclamation-triangle" style="color:var(--danger)"></i> {{ app()->getLocale()==='ar'?'مخزون منخفض':'Low Stock' }}
        </a>
      </div>
    </div>
    <div class="admin-content">

      {{-- DATE FILTER --}}
      <form method="GET" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;margin-bottom:24px;background:var(--surface);padding:16px;border-radius:12px;border:1.5px solid var(--border)">
        <label style="font-size:14px;font-weight:700">{{ app()->getLocale()==='ar'?'من:':'From:' }}</label>
        <input type="date" name="from" value="{{ $from }}" class="form-control" style="max-width:160px">
        <label style="font-size:14px;font-weight:700">{{ app()->getLocale()==='ar'?'إلى:':'To:' }}</label>
        <input type="date" name="to" value="{{ $to }}" class="form-control" style="max-width:160px">
        <button class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> {{ app()->getLocale()==='ar'?'تطبيق':'Apply' }}</button>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline btn-sm">{{ app()->getLocale()==='ar'?'هذا الشهر':'This Month' }}</a>
      </form>

      {{-- KPIs --}}
      <div class="stats-grid" style="margin-bottom:28px">
        <div class="stat-card">
          <div class="stat-icon blue"><i class="fas fa-shopping-bag"></i></div>
          <div><div class="stat-value">{{ $stats['total_orders'] }}</div><div class="stat-label">{{ app()->getLocale()==='ar'?'إجمالي الطلبات':'Total Orders' }}</div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
          <div><div class="stat-value">{{ $stats['delivered'] }}</div><div class="stat-label">{{ app()->getLocale()==='ar'?'طلبات مكتملة':'Delivered' }}</div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon red"><i class="fas fa-times-circle"></i></div>
          <div><div class="stat-value">{{ $stats['cancelled'] }}</div><div class="stat-label">{{ app()->getLocale()==='ar'?'طلبات ملغاة':'Cancelled' }}</div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon teal"><i class="fas fa-pound-sign"></i></div>
          <div><div class="stat-value">{{ number_format($stats['total_revenue'],0) }}</div><div class="stat-label">{{ app()->getLocale()==='ar'?'الإيرادات (ج.م)':'Revenue (EGP)' }}</div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon orange"><i class="fas fa-calculator"></i></div>
          <div><div class="stat-value">{{ number_format($stats['avg_order'],0) }}</div><div class="stat-label">{{ app()->getLocale()==='ar'?'متوسط قيمة الطلب':'Avg Order Value' }}</div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon" style="background:#F3E5F5;color:#8E24AA"><i class="fas fa-user-plus"></i></div>
          <div><div class="stat-value">{{ $stats['new_customers'] }}</div><div class="stat-label">{{ app()->getLocale()==='ar'?'عملاء جدد':'New Customers' }}</div></div>
        </div>
      </div>

      {{-- DAILY CHART --}}
      @if($dailyRevenue->count())
      <div class="card" style="margin-bottom:24px">
        <div class="card-header"><i class="fas fa-chart-bar" style="color:var(--primary)"></i> {{ app()->getLocale()==='ar'?'الإيرادات اليومية':'Daily Revenue' }}</div>
        @php $maxD = $dailyRevenue->max('revenue') ?: 1; @endphp
        <div style="display:flex;align-items:flex-end;gap:4px;height:140px;padding:8px 0 0;overflow-x:auto">
          @foreach($dailyRevenue as $d)
          <div style="min-width:30px;flex:1;display:flex;flex-direction:column;align-items:center;gap:3px" title="{{ $d->day }}: {{ number_format($d->revenue) }} EGP / {{ $d->orders }} orders">
            <div style="font-size:9px;font-weight:700;color:var(--primary)">{{ number_format($d->revenue/1000,1) }}k</div>
            <div style="width:100%;background:var(--primary);border-radius:3px 3px 0 0;height:{{ max(4,($d->revenue/$maxD)*110) }}px"></div>
            <div style="font-size:9px;color:var(--text-muted);white-space:nowrap">{{ \Carbon\Carbon::parse($d->day)->format('d/m') }}</div>
          </div>
          @endforeach
        </div>
      </div>
      @endif

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">
        {{-- TOP PRODUCTS --}}
        <div class="card" style="padding:0;overflow:hidden">
          <div class="card-header" style="padding:16px 20px"><i class="fas fa-trophy" style="color:#F9A825"></i> {{ app()->getLocale()==='ar'?'أكثر المنتجات مبيعاً':'Top Products' }}</div>
          <table class="table" style="font-size:13px">
            <thead><tr><th>#</th><th>{{ app()->getLocale()==='ar'?'المنتج':'Product' }}</th><th>{{ app()->getLocale()==='ar'?'وحدات':'Units' }}</th><th>{{ app()->getLocale()==='ar'?'إيرادات':'Revenue' }}</th></tr></thead>
            <tbody>
              @foreach($topProducts as $i => $item)
              <tr>
                <td><strong style="color:{{ ['#F9A825','#9E9E9E','#CD7F32'][$i]??'var(--text-muted)' }}">{{ $i+1 }}</strong></td>
                <td style="font-weight:600;font-size:13px">{{ $item->product?->name_ar ?? '—' }}</td>
                <td><strong style="color:var(--primary)">{{ $item->qty }}</strong></td>
                <td>{{ number_format($item->rev) }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        {{-- ORDERS TABLE --}}
        <div class="card" style="padding:0;overflow:hidden">
          <div class="card-header" style="padding:16px 20px"><i class="fas fa-list" style="color:var(--primary)"></i> {{ app()->getLocale()==='ar'?'الطلبات':'Orders' }} ({{ $orders->count() }})</div>
          <div style="max-height:400px;overflow-y:auto">
            <table class="table" style="font-size:12px">
              <thead><tr><th>{{ app()->getLocale()==='ar'?'رقم':'#' }}</th><th>{{ app()->getLocale()==='ar'?'العميل':'Customer' }}</th><th>{{ app()->getLocale()==='ar'?'المبلغ':'Amount' }}</th><th>{{ app()->getLocale()==='ar'?'الحالة':'Status' }}</th><th></th></tr></thead>
              <tbody>
                @foreach($orders as $order)
                <tr>
                  <td style="font-family:monospace;font-size:11px"><a href="{{ route('admin.orders.show',$order) }}" style="color:var(--primary)">{{ $order->order_number }}</a></td>
                  <td>{{ $order->user->name }}</td>
                  <td style="font-weight:700">{{ number_format($order->total,0) }}</td>
                  <td>@php $cls=['pending'=>'badge-orange','confirmed'=>'badge-blue','preparing'=>'badge-blue','shipped'=>'badge-blue','delivered'=>'badge-green','cancelled'=>'badge-red']; @endphp
                    <span class="badge {{ $cls[$order->status]??'badge-gray' }}" style="font-size:10px">{{ $order->status_label[app()->getLocale()] }}</span></td>
                  <td><a href="{{ route('admin.reports.invoice',$order) }}" target="_blank" class="btn btn-outline btn-sm" title="Invoice"><i class="fas fa-file-invoice"></i></a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
@endsection
