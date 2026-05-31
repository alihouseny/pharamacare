@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'لوحة التحكم':'Dashboard')

@section('content')
<div class="admin-layout">
  @include('admin._sidebar')
  <main class="admin-main">
    <div class="admin-topbar">
      <div style="display:flex;align-items:center;gap:14px">
        <button class="sidebar-toggle-btn" onclick="toggleSidebar()">
          <i class="fas fa-bars"></i>
        </button>
        <div>
          <h1 style="font-size:20px;font-weight:800;">{{ app()->getLocale()==='ar'?'لوحة التحكم':'Dashboard' }}</h1>
          <div style="font-size:12px;color:var(--text-muted)">{{ now()->translatedFormat('l، d F Y') }}</div>
        </div>
      </div>
      <div style="display:flex;align-items:center;gap:10px">
        <div style="text-align:end">
          <div style="font-size:14px;font-weight:700">{{ auth()->user()->name }}</div>
          <div style="font-size:12px;color:var(--primary)">{{ app()->getLocale()==='ar'?'مدير النظام':'Administrator' }}</div>
        </div>
        <div style="width:40px;height:40px;background:var(--primary);border-radius:12px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px">
          <i class="fas fa-user-shield"></i>
        </div>
      </div>
    </div>

    <div class="admin-content">

      {{-- KPI --}}
      <div class="stats-grid" style="margin-bottom:28px">
        <div class="stat-card">
          <div class="stat-icon green"><i class="fas fa-shopping-bag"></i></div>
          <div>
            <div class="stat-value">{{ $stats['total_orders'] }}</div>
            <div class="stat-label">{{ app()->getLocale()==='ar'?'إجمالي الطلبات':'Total Orders' }}</div>
            <div style="font-size:12px;color:var(--success);margin-top:2px">{{ app()->getLocale()==='ar'?'اليوم:':'Today:' }} <strong>{{ $stats['today_orders'] }}</strong></div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
          <div>
            <div class="stat-value">{{ $stats['pending_orders'] }}</div>
            <div class="stat-label">{{ app()->getLocale()==='ar'?'طلبات معلقة':'Pending' }}</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon teal"><i class="fas fa-pound-sign"></i></div>
          <div>
            <div class="stat-value">{{ number_format($stats['total_revenue']) }}</div>
            <div class="stat-label">{{ app()->getLocale()==='ar'?'الإيرادات (ج.م)':'Revenue (EGP)' }}</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon blue"><i class="fas fa-pills"></i></div>
          <div>
            <div class="stat-value">{{ $stats['total_products'] }}</div>
            <div class="stat-label">{{ app()->getLocale()==='ar'?'منتجات نشطة':'Active Products' }}</div>
            @if($stats['low_stock'])
              <div style="font-size:12px;color:var(--danger);margin-top:2px"><i class="fas fa-exclamation-triangle"></i> {{ $stats['low_stock'] }} {{ app()->getLocale()==='ar'?'منخفض':'low stock' }}</div>
            @endif
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon" style="background:#F3E5F5;color:#8E24AA"><i class="fas fa-users"></i></div>
          <div>
            <div class="stat-value">{{ $stats['total_customers'] }}</div>
            <div class="stat-label">{{ app()->getLocale()==='ar'?'العملاء':'Customers' }}</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon" style="background:#E3F2FD;color:var(--info)"><i class="fas fa-file-prescription"></i></div>
          <div>
            <div class="stat-value">{{ $stats['pending_rx'] }}</div>
            <div class="stat-label">{{ app()->getLocale()==='ar'?'روشيتات معلقة':'Pending Rx' }}</div>
          </div>
        </div>
      </div>

      {{-- REVENUE CHART --}}
      <div class="card" style="margin-bottom:24px">
        <div class="card-header"><i class="fas fa-chart-line" style="color:var(--primary)"></i> {{ app()->getLocale()==='ar'?'الإيرادات — آخر 12 شهر':'Revenue — Last 12 Months' }}</div>
        @php
          $months = collect(); for ($i=11;$i>=0;$i--) $months->push(now()->subMonths($i));
          $revenueByMonth = \App\Models\Order::where('status','delivered')->where('created_at','>=',now()->subMonths(12))
            ->selectRaw('DATE_FORMAT(created_at,"%Y-%m") as month, SUM(total) as revenue')->groupBy('month')->pluck('revenue','month');
          $maxRev = $revenueByMonth->max() ?: 1;
        @endphp
        <div style="display:flex;align-items:flex-end;gap:6px;height:150px;padding:8px 0 0">
          @foreach($months as $m)
            @php $key=$m->format('Y-m'); $rev=$revenueByMonth[$key]??0; @endphp
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px" title="{{ $m->format('M Y') }}: {{ number_format($rev) }} EGP">
              @if($rev>0)<div style="font-size:9px;font-weight:700;color:var(--primary)">{{ number_format($rev/1000,0) }}k</div>@else<div style="font-size:9px;color:transparent">0</div>@endif
              <div style="width:100%;background:{{ $rev>0?'var(--primary)':'var(--border)' }};border-radius:4px 4px 0 0;height:{{ max(4,($rev/$maxRev)*120) }}px;opacity:{{ $rev>0?'1':'0.3' }}"></div>
              <div style="font-size:9px;color:var(--text-muted)">{{ $m->format('M') }}</div>
            </div>
          @endforeach
        </div>
        <div style="display:flex;justify-content:space-between;font-size:13px;color:var(--text-muted);margin-top:12px;padding-top:12px;border-top:1px solid var(--border)">
          <span>{{ app()->getLocale()==='ar'?'الإجمالي:':'Total:' }} <strong style="color:var(--primary)">{{ number_format($revenueByMonth->sum()) }} {{ __('main.sar') }}</strong></span>
          <span>{{ app()->getLocale()==='ar'?'متوسط شهري:':'Avg/month:' }} <strong>{{ number_format($revenueByMonth->avg()) }} {{ __('main.sar') }}</strong></span>
        </div>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px">
        {{-- RECENT ORDERS --}}
        <div class="card" style="padding:0;overflow:hidden">
          <div class="card-header" style="padding:16px 20px"><i class="fas fa-clock" style="color:var(--primary)"></i> {{ app()->getLocale()==='ar'?'آخر الطلبات':'Recent Orders' }}</div>
          <table class="table" style="font-size:13px">
            <thead><tr><th>{{ app()->getLocale()==='ar'?'رقم الطلب':'Order' }}</th><th>{{ app()->getLocale()==='ar'?'العميل':'Customer' }}</th><th>{{ __('main.total') }}</th><th>{{ __('main.order_status') }}</th></tr></thead>
            <tbody>
              @foreach($recentOrders as $order)
              <tr>
                <td><a href="{{ route('admin.orders.show',$order) }}" style="color:var(--primary);font-weight:700;font-family:monospace;font-size:12px">{{ $order->order_number }}</a></td>
                <td>{{ $order->user->name }}</td>
                <td style="font-weight:700">{{ number_format($order->total,0) }}</td>
                <td>@php $cls=['pending'=>'badge-orange','confirmed'=>'badge-blue','preparing'=>'badge-blue','shipped'=>'badge-blue','delivered'=>'badge-green','cancelled'=>'badge-red']; @endphp
                  <span class="badge {{ $cls[$order->status]??'badge-gray' }}">{{ $order->status_label[app()->getLocale()] }}</span></td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div style="padding:12px 16px"><a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm">{{ __('main.view_all') }}</a></div>
        </div>

        {{-- EXPIRING SOON --}}
        <div class="card" style="padding:0;overflow:hidden">
          <div class="card-header" style="padding:16px 20px"><i class="fas fa-exclamation-triangle" style="color:var(--warning)"></i> {{ app()->getLocale()==='ar'?'قريبة الانتهاء':'Near Expiry' }}</div>
          @if($expiringSoon->isEmpty())
            <div style="padding:24px;text-align:center;color:var(--text-muted)"><i class="fas fa-check-circle" style="color:var(--success);font-size:24px"></i><p style="margin-top:8px;font-size:14px">{{ app()->getLocale()==='ar'?'لا توجد':'None' }}</p></div>
          @else
          <table class="table" style="font-size:13px">
            <thead><tr><th>{{ app()->getLocale()==='ar'?'المنتج':'Product' }}</th><th>{{ app()->getLocale()==='ar'?'الانتهاء':'Expiry' }}</th><th>{{ app()->getLocale()==='ar'?'أيام':'Days' }}</th><th>{{ app()->getLocale()==='ar'?'كمية':'Qty' }}</th></tr></thead>
            <tbody>
              @foreach($expiringSoon as $exp)
              @php $days=now()->diffInDays($exp->expiry_date,false); @endphp
              <tr>
                <td style="font-weight:600">{{ $exp->product->name_ar }}</td>
                <td>{{ $exp->expiry_date->format('d/m/Y') }}</td>
                <td><span style="font-weight:700;color:{{ $days<=30?'var(--danger)':'var(--warning)' }}">{{ $days }}</span></td>
                <td>{{ $exp->remaining_quantity }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @endif
        </div>
      </div>

      {{-- TOP PRODUCTS --}}
      @php
        $topProducts = \App\Models\OrderItem::with('product')
          ->join('orders','orders.id','=','order_items.order_id')
          ->whereIn('orders.status',['delivered','shipped','confirmed','preparing'])
          ->selectRaw('product_id, SUM(quantity) as total_qty, SUM(order_items.total) as total_rev')
          ->groupBy('product_id')->orderByDesc('total_qty')->limit(5)->get();
      @endphp
      @if($topProducts->count())
      <div class="card">
        <div class="card-header"><i class="fas fa-trophy" style="color:#F9A825"></i> {{ app()->getLocale()==='ar'?'الأكثر مبيعاً':'Top Selling' }}</div>
        <table class="table">
          <thead><tr><th>#</th><th>{{ app()->getLocale()==='ar'?'المنتج':'Product' }}</th><th>{{ app()->getLocale()==='ar'?'مبيعات':'Units' }}</th><th>{{ app()->getLocale()==='ar'?'إيرادات':'Revenue' }}</th><th>{{ app()->getLocale()==='ar'?'مخزون':'Stock' }}</th><th></th></tr></thead>
          <tbody>
            @foreach($topProducts as $i => $item)
            <tr>
              <td><span style="font-weight:900;font-size:16px;color:{{ ['#F9A825','#9E9E9E','#CD7F32'][$i]??'var(--text-muted)' }}">{{ $i+1 }}</span></td>
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  @if($item->product?->image)
                    <img src="{{ asset('storage/'.$item->product->image) }}" style="width:36px;height:36px;object-fit:cover;border-radius:8px">
                  @else
                    <div style="width:36px;height:36px;background:var(--primary-light);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--primary)"><i class="fas fa-pills" style="font-size:14px"></i></div>
                  @endif
                  <span style="font-weight:700;font-size:14px">{{ $item->product?->name_ar ?? '—' }}</span>
                </div>
              </td>
              <td><strong style="color:var(--primary)">{{ number_format($item->total_qty) }}</strong></td>
              <td>{{ number_format($item->total_rev) }} {{ __('main.sar') }}</td>
              <td><span style="color:{{ $item->product?->stock<=($item->product?->min_stock_alert??10)?'var(--danger)':'var(--success)' }};font-weight:700">{{ $item->product?->stock??0 }}</span></td>
              <td>@if($item->product)<a href="{{ route('admin.products.analytics',$item->product) }}" class="btn btn-outline btn-sm"><i class="fas fa-chart-bar"></i></a>@endif</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endif
    </div>
  </main>
</div>
@endsection
