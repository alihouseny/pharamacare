@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'تواريخ الصلاحية':'Expiry Dates')

@section('content')
<div class="admin-layout">
  @include('admin._sidebar')
  <main class="admin-main">
    <div class="admin-topbar"><button class="sidebar-toggle-btn" onclick="toggleSidebar()" style="margin-inline-end:8px"><i class="fas fa-bars"></i></button>
      <h1 style="font-size:20px;font-weight:800"><i class="fas fa-calendar-times"></i> {{ app()->getLocale()==='ar'?'تواريخ الصلاحية':'Expiry Dates' }}</h1>
    </div>
    <div class="admin-content">

      {{-- SUMMARY CARDS --}}
      <div class="stats-grid" style="margin-bottom:24px">
        <div class="stat-card">
          <div class="stat-icon red"><i class="fas fa-skull-crossbones"></i></div>
          <div><div class="stat-value expiry-danger">{{ $summary['expired'] }}</div><div class="stat-label">{{ app()->getLocale()==='ar'?'منتهية الصلاحية':'Expired' }}</div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon orange"><i class="fas fa-exclamation-triangle"></i></div>
          <div><div class="stat-value expiry-near">{{ $summary['near_expiry'] }}</div><div class="stat-label">{{ app()->getLocale()==='ar'?'تنتهي خلال 90 يوم':'Expiring in 90 days' }}</div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
          <div><div class="stat-value expiry-ok">{{ $summary['ok'] }}</div><div class="stat-label">{{ app()->getLocale()==='ar'?'صالحة':'Valid' }}</div></div>
        </div>
      </div>

      {{-- FILTER TABS --}}
      <div style="display:flex;gap:8px;margin-bottom:20px;">
        @foreach(['all'=>(app()->getLocale()==='ar'?'الكل':'All'),'expired'=>(app()->getLocale()==='ar'?'منتهية':'Expired'),'near'=>(app()->getLocale()==='ar'?'قريبة الانتهاء':'Near Expiry'),'ok'=>(app()->getLocale()==='ar'?'صالحة':'Valid')] as $key=>$label)
          <a href="{{ route('admin.expiry.index', ['filter'=>$key]) }}" class="btn {{ $filter===$key?'btn-primary':'btn-outline' }} btn-sm">{{ $label }}</a>
        @endforeach
      </div>

      <div class="card" style="padding:0;overflow:hidden">
        <table class="table">
          <thead><tr>
            <th>{{ app()->getLocale()==='ar'?'المنتج':'Product' }}</th>
            <th>{{ app()->getLocale()==='ar'?'رقم الدفعة':'Batch #' }}</th>
            <th>{{ app()->getLocale()==='ar'?'تاريخ الإنتاج':'Manufacture' }}</th>
            <th>{{ app()->getLocale()==='ar'?'تاريخ الانتهاء':'Expiry Date' }}</th>
            <th>{{ app()->getLocale()==='ar'?'الأيام المتبقية':'Days Left' }}</th>
            <th>{{ app()->getLocale()==='ar'?'الكمية المتبقية':'Remaining' }}</th>
          </tr></thead>
          <tbody>
            @foreach($batches as $batch)
            <tr>
              <td>
                <div style="font-weight:700;font-size:14px">{{ $batch->product->name_ar }}</div>
                <div style="font-size:12px;color:var(--text-muted)">{{ $batch->product->active_ingredient }}</div>
              </td>
              <td style="font-size:13px;font-family:monospace">{{ $batch->batch_number }}</td>
              <td style="font-size:13px">{{ $batch->manufacture_date?->format('d/m/Y') ?? '—' }}</td>
              <td>
                <span class="{{ $batch->is_expired() ? 'expiry-danger' : ($batch->is_near_expiry() ? 'expiry-near' : 'expiry-ok') }}" style="font-weight:700">
                  {{ $batch->expiry_date->format('d/m/Y') }}
                </span>
              </td>
              <td>
                <span data-expiry="{{ $batch->days_until_expiry }}" style="font-weight:700"
                  class="{{ $batch->days_until_expiry < 0 ? 'expiry-danger' : ($batch->days_until_expiry <= 30 ? 'expiry-danger' : ($batch->days_until_expiry <= 90 ? 'expiry-near' : 'expiry-ok')) }}">
                  {{ $batch->days_until_expiry < 0 ? (app()->getLocale()==='ar'?'منتهية':'Expired') : $batch->days_until_expiry.' '.(app()->getLocale()==='ar'?'يوم':'days') }}
                </span>
              </td>
              <td style="font-weight:700">{{ $batch->remaining_quantity }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div style="padding:16px">{{ $batches->links() }}</div>
      </div>
    </div>
  </main>
</div>
@endsection
