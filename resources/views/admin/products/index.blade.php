@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'إدارة المنتجات':'Manage Products')

@section('content')
<div class="admin-layout">
  @include('admin._sidebar')
  <main class="admin-main">
    <div class="admin-topbar"><button class="sidebar-toggle-btn" onclick="toggleSidebar()" style="margin-inline-end:8px"><i class="fas fa-bars"></i></button>
      <h1 style="font-size:20px;font-weight:800"><i class="fas fa-pills"></i> {{ app()->getLocale()==='ar'?'المنتجات':'Products' }}</h1>
      <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> {{ app()->getLocale()==='ar'?'منتج جديد':'New Product' }}</a>
    </div>
    <div class="admin-content">

      {{-- SEARCH & FILTER --}}
      <form method="GET" style="display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap;">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" style="max-width:280px" placeholder="{{ app()->getLocale()==='ar'?'بحث بالاسم أو المادة الفعالة...':'Search name or ingredient...' }}">
        <select name="category" class="form-select" style="max-width:200px">
          <option value="">{{ app()->getLocale()==='ar'?'كل الأقسام':'All Categories' }}</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category')==$cat->id?'selected':'' }}>{{ $cat->name_ar }}</option>
          @endforeach
        </select>
        <select name="stock" class="form-select" style="max-width:180px">
          <option value="">{{ app()->getLocale()==='ar'?'كل المخزون':'All Stock' }}</option>
          <option value="low" {{ request('stock')==='low'?'selected':'' }}>{{ app()->getLocale()==='ar'?'مخزون منخفض':'Low Stock' }}</option>
        </select>
        <button class="btn btn-primary">{{ app()->getLocale()==='ar'?'بحث':'Search' }}</button>
        @if(request()->hasAny(['q','category','stock']))
          <a href="{{ route('admin.products.index') }}" class="btn btn-outline">{{ app()->getLocale()==='ar'?'مسح':'Clear' }}</a>
        @endif
      </form>

      <div class="card" style="padding:0;overflow:hidden">
        <table class="table">
          <thead><tr>
            <th>{{ app()->getLocale()==='ar'?'المنتج':'Product' }}</th>
            <th>{{ app()->getLocale()==='ar'?'المادة الفعالة':'Ingredient' }}</th>
            <th>{{ app()->getLocale()==='ar'?'السعر':'Price' }}</th>
            <th>{{ app()->getLocale()==='ar'?'المخزون':'Stock' }}</th>
            <th>Rx</th>
            <th>{{ app()->getLocale()==='ar'?'الحالة':'Status' }}</th>
            <th></th>
          </tr></thead>
          <tbody>
            @foreach($products as $p)
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  @if($p->image)
                    <img src="{{ asset('storage/'.$p->image) }}" style="width:40px;height:40px;object-fit:cover;border-radius:8px">
                  @else
                    <div style="width:40px;height:40px;background:var(--primary-light);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--primary)"><i class="fas fa-pills"></i></div>
                  @endif
                  <div>
                    <div style="font-weight:700;font-size:14px">{{ $p->name_ar }}</div>
                    <div style="font-size:12px;color:var(--text-muted)">{{ $p->category->name_ar }}</div>
                  </div>
                </div>
              </td>
              <td style="font-size:13px;color:var(--info)">{{ $p->active_ingredient ?: '—' }}</td>
              <td>
                <span style="font-weight:700">{{ number_format($p->current_price,2) }}</span>
                @if($p->sale_price)<span style="font-size:12px;color:var(--text-muted);text-decoration:line-through;margin-start:4px">{{ number_format($p->price,2) }}</span>@endif
              </td>
              <td>
                <span class="{{ $p->isLowStock() ? 'expiry-danger' : '' }}" style="font-weight:700">{{ $p->stock }}</span>
                @if($p->isLowStock())<span class="badge badge-red" style="font-size:11px;margin-start:4px">{{ app()->getLocale()==='ar'?'منخفض':'Low' }}</span>@endif
              </td>
              <td>
                @if($p->requires_prescription)
                  <span class="badge badge-blue">Rx</span>
                @else
                  <span class="badge badge-green">OTC</span>
                @endif
              </td>
              <td><span class="badge {{ $p->is_active?'badge-green':'badge-gray' }}">{{ $p->is_active?'Active':'Inactive' }}</span></td>
              <td>
                <div style="display:flex;gap:6px">
                  <a href="{{ route('admin.products.analytics',$p) }}" class="btn btn-outline btn-sm" title="{{ app()->getLocale()==='ar'?'تحليل':'Analytics' }}"><i class="fas fa-chart-bar"></i></a><a href="{{ route('admin.products.edit',$p) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i></a>
                  <a href="{{ route('admin.products.expiry',$p) }}" class="btn btn-outline btn-sm" title="{{ app()->getLocale()==='ar'?'الصلاحية':'Expiry' }}"><i class="fas fa-calendar-times"></i></a>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div style="padding:16px">{{ $products->links() }}</div>
      </div>
    </div>
  </main>
</div>
@endsection
