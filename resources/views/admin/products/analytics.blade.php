@extends('layouts.app')
@section('title', 'تحليل: '.$product->name_ar)

@section('content')
<div class="admin-layout">
  @include('admin._sidebar')
  <main class="admin-main">
    <div class="admin-topbar"><button class="sidebar-toggle-btn" onclick="toggleSidebar()" style="margin-inline-end:8px"><i class="fas fa-bars"></i></button>
      <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
        <div>
          <h1 style="font-size:20px;font-weight:900">{{ $product->name_ar }}</h1>
          <div style="font-size:13px;color:var(--text-muted)">{{ app()->getLocale()==='ar'?'تحليل المبيعات والأداء':'Sales & Performance Analytics' }}</div>
        </div>
      </div>
      <div style="display:flex;gap:8px">
        <a href="{{ route('admin.products.edit',$product) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i></a>
        <a href="{{ route('admin.products.expiry',$product) }}" class="btn btn-outline btn-sm"><i class="fas fa-calendar-times"></i></a>
      </div>
    </div>
    <div class="admin-content">

      {{-- KPI CARDS --}}
      <div class="stats-grid" style="margin-bottom:28px">
        <div class="stat-card">
          <div class="stat-icon blue"><i class="fas fa-shopping-bag"></i></div>
          <div><div class="stat-value">{{ number_format($totalSold) }}</div><div class="stat-label">{{ app()->getLocale()==='ar'?'إجمالي المبيعات (وحدة)':'Total Units Sold' }}</div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon green"><i class="fas fa-money-bill-wave"></i></div>
          <div><div class="stat-value">{{ number_format($totalRevenue,0) }}</div><div class="stat-label">{{ app()->getLocale()==='ar'?'إجمالي الإيرادات (ج.م)':'Total Revenue (EGP)' }}</div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon orange"><i class="fas fa-receipt"></i></div>
          <div><div class="stat-value">{{ number_format($totalOrders) }}</div><div class="stat-label">{{ app()->getLocale()==='ar'?'عدد الطلبات':'Orders Count' }}</div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon {{ $product->stock <= $product->min_stock_alert ? 'red' : 'teal' }}"><i class="fas fa-boxes"></i></div>
          <div><div class="stat-value">{{ $product->stock }}</div><div class="stat-label">{{ app()->getLocale()==='ar'?'المخزون الحالي':'Current Stock' }}</div></div>
        </div>
      </div>

      <div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;margin-bottom:24px">

        {{-- SALES CHART --}}
        <div class="card">
          <div class="card-header"><i class="fas fa-chart-bar" style="color:var(--primary)"></i> {{ app()->getLocale()==='ar'?'المبيعات الشهرية (12 شهر)':'Monthly Sales (12 months)' }}</div>
          @if($salesByMonth->isEmpty())
            <div style="text-align:center;padding:40px;color:var(--text-muted)">
              <i class="fas fa-chart-bar" style="font-size:40px;opacity:.3"></i>
              <p style="margin-top:12px">{{ app()->getLocale()==='ar'?'لا توجد مبيعات بعد':'No sales data yet' }}</p>
            </div>
          @else
            <div style="display:flex;align-items:flex-end;gap:6px;height:180px;padding:8px 0">
              @php $maxQty = $salesByMonth->max('qty') ?: 1; @endphp
              @foreach($salesByMonth as $m)
                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px">
                  <div style="font-size:11px;font-weight:700;color:var(--primary)">{{ $m->qty }}</div>
                  <div style="width:100%;background:var(--primary);border-radius:4px 4px 0 0;height:{{ max(4, ($m->qty/$maxQty)*140) }}px;transition:height .3s"></div>
                  <div style="font-size:10px;color:var(--text-muted);white-space:nowrap">{{ \Carbon\Carbon::parse($m->month.'-01')->format('M y') }}</div>
                </div>
              @endforeach
            </div>
            <div style="display:flex;justify-content:space-between;font-size:13px;color:var(--text-muted);margin-top:12px;padding-top:12px;border-top:1px solid var(--border)">
              <span>{{ app()->getLocale()==='ar'?'أعلى شهر:':'Best Month:' }} <strong>{{ $salesByMonth->sortByDesc('qty')->first()->month }}</strong></span>
              <span>{{ app()->getLocale()==='ar'?'إجمالي الإيرادات:':'Total Revenue:' }} <strong>{{ number_format($salesByMonth->sum('revenue'),2) }} {{ __('main.sar') }}</strong></span>
            </div>
          @endif
        </div>

        {{-- PRODUCT INFO --}}
        <div class="card">
          <div class="card-header"><i class="fas fa-pills" style="color:var(--info)"></i> {{ app()->getLocale()==='ar'?'معلومات المنتج':'Product Info' }}</div>
          <div style="display:flex;flex-direction:column;gap:10px;font-size:14px">
            <div class="order-row"><span style="color:var(--text-muted)">{{ __('main.active_ingredient') }}</span><strong>{{ $product->active_ingredient ?? '—' }}</strong></div>
            <div class="order-row"><span style="color:var(--text-muted)">{{ __('main.manufacturer') }}</span><strong>{{ $product->manufacturer ?? '—' }}</strong></div>
            <div class="order-row"><span style="color:var(--text-muted)">{{ __('main.dosage_form') }}</span><strong>{{ $product->dosage_form ?? '—' }}</strong></div>
            <div class="order-row"><span style="color:var(--text-muted)">{{ __('main.strength') }}</span><strong>{{ $product->strength ?? '—' }}</strong></div>
            <div class="order-row"><span style="color:var(--text-muted)">{{ __('main.package_size') }}</span><strong>{{ $product->package_size ?? '—' }}</strong></div>
            <div class="order-row"><span style="color:var(--text-muted)">{{ app()->getLocale()==='ar'?'السعر':'Price' }}</span>
              <strong style="color:var(--primary)">
                {{ number_format($product->current_price,2) }} {{ __('main.sar') }}
                @if($product->sale_price)<span style="text-decoration:line-through;color:var(--text-muted);font-weight:400;font-size:12px"> {{ $product->price }}</span>@endif
              </strong>
            </div>
            <div class="order-row"><span style="color:var(--text-muted)">{{ app()->getLocale()==='ar'?'يستلزم روشيتة':'Requires Rx' }}</span>
              <span class="badge {{ $product->requires_prescription ? 'badge-blue' : 'badge-green' }}">
                {{ $product->requires_prescription ? (app()->getLocale()==='ar'?'نعم':'Yes') : (app()->getLocale()==='ar'?'لا':'No') }}
              </span>
            </div>
            <div class="order-row"><span style="color:var(--text-muted)">{{ app()->getLocale()==='ar'?'الحالة':'Status' }}</span>
              <span class="badge {{ $product->is_active ? 'badge-green' : 'badge-gray' }}">
                {{ $product->is_active ? (app()->getLocale()==='ar'?'نشط':'Active') : (app()->getLocale()==='ar'?'غير نشط':'Inactive') }}
              </span>
            </div>
          </div>
        </div>
      </div>

      {{-- EXPIRY BATCHES --}}
      <div class="card" style="margin-bottom:24px">
        <div class="card-header"><i class="fas fa-calendar-times" style="color:var(--warning)"></i> {{ app()->getLocale()==='ar'?'دفعات الصلاحية':'Expiry Batches' }}</div>
        @if($batches->isEmpty())
          <div style="text-align:center;padding:24px;color:var(--text-muted)">{{ app()->getLocale()==='ar'?'لا توجد دفعات مسجلة':'No batches registered' }}</div>
        @else
          <table class="table">
            <thead><tr>
              <th>{{ app()->getLocale()==='ar'?'رقم الدفعة':'Batch #' }}</th>
              <th>{{ app()->getLocale()==='ar'?'تاريخ الانتهاء':'Expiry' }}</th>
              <th>{{ app()->getLocale()==='ar'?'الأيام المتبقية':'Days Left' }}</th>
              <th>{{ app()->getLocale()==='ar'?'الكمية':'Qty' }}</th>
              <th>{{ app()->getLocale()==='ar'?'المتبقي':'Remaining' }}</th>
              <th>{{ app()->getLocale()==='ar'?'الحالة':'Status' }}</th>
            </tr></thead>
            <tbody>
              @foreach($batches as $b)
              @php $days = now()->diffInDays($b->expiry_date, false); @endphp
              <tr>
                <td style="font-family:monospace;font-weight:700">{{ $b->batch_number }}</td>
                <td>{{ $b->expiry_date->format('d/m/Y') }}</td>
                <td>
                  <span style="font-weight:700;color:{{ $days < 0 ? 'var(--danger)' : ($days <= 90 ? 'var(--warning)' : 'var(--success)') }}">
                    {{ $days < 0 ? (app()->getLocale()==='ar'?'منتهية':'Expired') : $days.' '.(app()->getLocale()==='ar'?'يوم':'days') }}
                  </span>
                </td>
                <td>{{ $b->quantity }}</td>
                <td style="font-weight:700">{{ $b->remaining_quantity }}</td>
                <td>
                  @if($days < 0)
                    <span class="badge badge-red">{{ app()->getLocale()==='ar'?'منتهية الصلاحية':'Expired' }}</span>
                  @elseif($days <= 30)
                    <span class="badge badge-red">{{ app()->getLocale()==='ar'?'حرج':'Critical' }}</span>
                  @elseif($days <= 90)
                    <span class="badge badge-orange">{{ app()->getLocale()==='ar'?'قريبة':'Near Expiry' }}</span>
                  @else
                    <span class="badge badge-green">{{ app()->getLocale()==='ar'?'جيدة':'Good' }}</span>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>

      {{-- RECENT ORDERS --}}
      <div class="card">
        <div class="card-header"><i class="fas fa-clock" style="color:var(--primary)"></i> {{ app()->getLocale()==='ar'?'آخر الطلبات التي تحتوي هذا المنتج':'Recent Orders Containing This Product' }}</div>
        @if($recentOrders->isEmpty())
          <div style="text-align:center;padding:24px;color:var(--text-muted)">{{ app()->getLocale()==='ar'?'لا توجد طلبات بعد':'No orders yet' }}</div>
        @else
          <table class="table">
            <thead><tr>
              <th>{{ __('main.order_number') }}</th>
              <th>{{ app()->getLocale()==='ar'?'العميل':'Customer' }}</th>
              <th>{{ app()->getLocale()==='ar'?'الكمية':'Qty' }}</th>
              <th>{{ app()->getLocale()==='ar'?'المبلغ':'Amount' }}</th>
              <th>{{ __('main.order_status') }}</th>
              <th>{{ app()->getLocale()==='ar'?'التاريخ':'Date' }}</th>
            </tr></thead>
            <tbody>
              @foreach($recentOrders as $item)
              <tr>
                <td><a href="{{ route('admin.orders.show',$item->order) }}" style="color:var(--primary);font-weight:700">{{ $item->order->order_number }}</a></td>
                <td>{{ $item->order->user->name }}</td>
                <td style="font-weight:700">{{ $item->quantity }}</td>
                <td>{{ number_format($item->total,2) }} {{ __('main.sar') }}</td>
                <td>
                  @php $cls=['pending'=>'badge-orange','confirmed'=>'badge-blue','preparing'=>'badge-blue','shipped'=>'badge-blue','delivered'=>'badge-green','cancelled'=>'badge-red']; @endphp
                  <span class="badge {{ $cls[$item->order->status]??'badge-gray' }}">{{ $item->order->status_label[app()->getLocale()] }}</span>
                </td>
                <td style="font-size:13px;color:var(--text-muted)">{{ $item->created_at->format('d/m/Y') }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>

    </div>
  </main>
</div>
@endsection
