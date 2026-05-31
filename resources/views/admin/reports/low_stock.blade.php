@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'المخزون المنخفض':'Low Stock Alert')
@section('content')
<div class="admin-layout">
  @include('admin._sidebar')
  <main class="admin-main">
    <div class="admin-topbar">
      <button class="sidebar-toggle-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
      <h1 style="font-size:20px;font-weight:800"><i class="fas fa-exclamation-triangle" style="color:var(--danger)"></i> {{ app()->getLocale()==='ar'?'تنبيه مخزون منخفض':'Low Stock Alert' }}</h1>
      <a href="{{ route('admin.reports.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
    </div>
    <div class="admin-content">
      @if($products->isEmpty())
        <div class="empty-state"><div class="empty-state-icon">✅</div><h3>{{ app()->getLocale()==='ar'?'المخزون كافٍ لجميع المنتجات':'All products have sufficient stock' }}</h3></div>
      @else
        <div class="card" style="padding:0;overflow:hidden">
          <table class="table">
            <thead><tr>
              <th>{{ app()->getLocale()==='ar'?'المنتج':'Product' }}</th>
              <th>{{ app()->getLocale()==='ar'?'القسم':'Category' }}</th>
              <th>{{ app()->getLocale()==='ar'?'المخزون الحالي':'Current Stock' }}</th>
              <th>{{ app()->getLocale()==='ar'?'حد التنبيه':'Alert Level' }}</th>
              <th>{{ app()->getLocale()==='ar'?'الحالة':'Status' }}</th>
              <th></th>
            </tr></thead>
            <tbody>
              @foreach($products as $p)
              <tr style="background:{{ $p->stock == 0 ? '#FFF8F8' : 'inherit' }}">
                <td>
                  <div style="display:flex;align-items:center;gap:10px">
                    @if($p->image)
                      <img src="{{ asset('storage/'.$p->image) }}" style="width:36px;height:36px;object-fit:cover;border-radius:8px">
                    @else
                      <div style="width:36px;height:36px;background:var(--primary-light);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--primary)"><i class="fas fa-pills" style="font-size:14px"></i></div>
                    @endif
                    <div>
                      <div style="font-weight:700">{{ $p->name_ar }}</div>
                      <div style="font-size:12px;color:var(--info)">{{ $p->active_ingredient }}</div>
                    </div>
                  </div>
                </td>
                <td style="font-size:13px">{{ $p->category?->name_ar }}</td>
                <td><span style="font-weight:900;font-size:18px;color:{{ $p->stock==0?'var(--danger)':'var(--warning)' }}">{{ $p->stock }}</span></td>
                <td style="color:var(--text-muted)">{{ $p->min_stock_alert }}</td>
                <td>
                  @if($p->stock == 0)
                    <span class="badge badge-red">{{ app()->getLocale()==='ar'?'نفذ المخزون':'Out of Stock' }}</span>
                  @else
                    <span class="badge badge-orange">{{ app()->getLocale()==='ar'?'منخفض':'Low Stock' }}</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('admin.products.edit',$p) }}" class="btn btn-primary btn-sm">{{ app()->getLocale()==='ar'?'تحديث':'Update' }}</a>
                </td>
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
