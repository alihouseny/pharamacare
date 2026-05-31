@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'الطلبات':'Orders')

@section('content')
<div class="admin-layout">
  @include('admin._sidebar')
  <main class="admin-main">
    <div class="admin-topbar"><button class="sidebar-toggle-btn" onclick="toggleSidebar()" style="margin-inline-end:8px"><i class="fas fa-bars"></i></button>
      <h1 style="font-size:20px;font-weight:800"><i class="fas fa-shopping-bag"></i> {{ app()->getLocale()==='ar'?'الطلبات':'Orders' }}</h1>
    </div>
    <div class="admin-content">
      <form method="GET" style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" style="max-width:240px" placeholder="{{ app()->getLocale()==='ar'?'رقم الطلب أو اسم العميل...':'Order # or customer...' }}">
        <select name="status" class="form-select" style="max-width:180px">
          <option value="">{{ app()->getLocale()==='ar'?'كل الحالات':'All Status' }}</option>
          @foreach(['pending','confirmed','preparing','shipped','delivered','cancelled'] as $s)
            <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ $s }}</option>
          @endforeach
        </select>
        <button class="btn btn-primary">{{ app()->getLocale()==='ar'?'بحث':'Search' }}</button>
      </form>

      <div class="card" style="padding:0;overflow:hidden">
        <table class="table">
          <thead><tr>
            <th>{{ app()->getLocale()==='ar'?'رقم الطلب':'Order #' }}</th>
            <th>{{ app()->getLocale()==='ar'?'العميل':'Customer' }}</th>
            <th>{{ app()->getLocale()==='ar'?'الإجمالي':'Total' }}</th>
            <th>{{ app()->getLocale()==='ar'?'الحالة':'Status' }}</th>
            <th>{{ app()->getLocale()==='ar'?'التاريخ':'Date' }}</th>
            <th></th>
          </tr></thead>
          <tbody>
            @foreach($orders as $order)
            <tr>
              <td style="font-weight:700;font-family:monospace"><a href="{{ route('admin.orders.show',$order) }}" style="color:var(--primary)">{{ $order->order_number }}</a></td>
              <td>
                <div style="font-weight:600">{{ $order->user->name }}</div>
                <div style="font-size:12px;color:var(--text-muted)">{{ $order->user->phone }}</div>
              </td>
              <td style="font-weight:700">{{ number_format($order->total,2) }} {{ __('main.sar') }}</td>
              <td>
                @php $cls=['pending'=>'badge-orange','confirmed'=>'badge-blue','preparing'=>'badge-blue','shipped'=>'badge-blue','delivered'=>'badge-green','cancelled'=>'badge-red']; @endphp
                <span class="badge {{ $cls[$order->status]??'badge-gray' }}">{{ $order->status_label[app()->getLocale()] }}</span>
              </td>
              <td style="font-size:13px">{{ $order->created_at->format('d/m/Y') }}</td>
              <td><a href="{{ route('admin.orders.show',$order) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div style="padding:16px">{{ $orders->links() }}</div>
      </div>
    </div>
  </main>
</div>
@endsection
