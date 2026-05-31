@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'تفاصيل الطلب':'Order Details')

@section('content')
<div class="admin-layout">
  @include('admin._sidebar')
  <main class="admin-main">
    <div class="admin-topbar"><button class="sidebar-toggle-btn" onclick="toggleSidebar()" style="margin-inline-end:8px"><i class="fas fa-bars"></i></button>
      <div style="display:flex;align-items:center;gap:12px;">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
        <h1 style="font-size:20px;font-weight:800">{{ $order->order_number }}</h1>
        @php $cls=['pending'=>'badge-orange','confirmed'=>'badge-blue','preparing'=>'badge-blue','shipped'=>'badge-blue','delivered'=>'badge-green','cancelled'=>'badge-red']; @endphp
        <span class="badge {{ $cls[$order->status]??'badge-gray' }}">{{ $order->status_label[app()->getLocale()] }}</span>
      </div>
    </div>
    <div class="admin-content">
      <div style="display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start;">

        {{-- LEFT --}}
        <div>
          {{-- UPDATE STATUS --}}
          <div class="card" style="margin-bottom:20px">
            <div class="card-header"><i class="fas fa-edit"></i> {{ app()->getLocale()==='ar'?'تحديث الحالة':'Update Status' }}</div>
            <form action="{{ route('admin.orders.status',$order) }}" method="POST" style="display:flex;gap:10px;flex-wrap:wrap">
              @csrf @method('PATCH')
              <select name="status" class="form-select" style="max-width:220px">
                @foreach(['pending','confirmed','preparing','shipped','delivered','cancelled'] as $s)
                  <option value="{{ $s }}" {{ $order->status===$s?'selected':'' }}>{{ $s }}</option>
                @endforeach
              </select>
              <button class="btn btn-primary">{{ __('main.save') }}</button>
            </form>
          </div>

          {{-- ORDER ITEMS --}}
          <div class="card" style="margin-bottom:20px">
            <div class="card-header"><i class="fas fa-box"></i> {{ app()->getLocale()==='ar'?'المنتجات':'Items' }}</div>
            @foreach($order->items as $item)
            <div style="display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid var(--border)">
              @if($item->product?->image)
                <img src="{{ asset('storage/'.$item->product->image) }}" style="width:54px;height:54px;object-fit:cover;border-radius:8px">
              @else
                <div style="width:54px;height:54px;background:var(--primary-light);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--primary)"><i class="fas fa-pills"></i></div>
              @endif
              <div style="flex:1">
                <div style="font-weight:700">{{ $item->product?->name_ar ?? 'Deleted' }}</div>
                <div style="font-size:13px;color:var(--text-muted)">{{ $item->quantity }} × {{ number_format($item->price,2) }} {{ __('main.sar') }}</div>
              </div>
              <div style="font-weight:800">{{ number_format($item->total,2) }} {{ __('main.sar') }}</div>
            </div>
            @endforeach
            <div style="margin-top:16px">
              <div class="order-row"><span>{{ __('main.subtotal') }}</span><span>{{ number_format($order->subtotal,2) }} {{ __('main.sar') }}</span></div>
              <div class="order-row"><span>{{ __('main.delivery_fee') }}</span><span>{{ number_format($order->delivery_fee,2) }} {{ __('main.sar') }}</span></div>
              <div class="order-row" style="margin-top:8px"><strong>{{ __('main.total') }}</strong><strong style="color:var(--primary)">{{ number_format($order->total,2) }} {{ __('main.sar') }}</strong></div>
            </div>
          </div>

          {{-- PRESCRIPTION --}}
          @if($order->prescription)
          <div class="card">
            <div class="card-header"><i class="fas fa-file-prescription"></i> {{ __('main.prescriptions') }}</div>
            <a href="{{ asset('storage/'.$order->prescription->image) }}" target="_blank">
              <img src="{{ asset('storage/'.$order->prescription->image) }}" style="max-width:200px;border-radius:8px">
            </a>
            @if($order->prescription->pharmacist_notes)
              <div style="font-size:13px;margin-top:10px;color:var(--text-muted)">{{ $order->prescription->pharmacist_notes }}</div>
            @endif
          </div>
          @endif
        </div>

        {{-- RIGHT --}}
        <div>
          {{-- CUSTOMER --}}
          <div class="card" style="margin-bottom:16px">
            <div class="card-header"><i class="fas fa-user"></i> {{ app()->getLocale()==='ar'?'العميل':'Customer' }}</div>
            <div style="font-weight:700;font-size:16px">{{ $order->user->name }}</div>
            <div style="font-size:13px;color:var(--text-muted);margin-top:4px">{{ $order->user->email }}</div>
            <div style="font-size:13px;color:var(--text-muted)">{{ $order->user->phone }}</div>
          </div>

          {{-- ADDRESS --}}
          @if($order->address)
          <div class="card" style="margin-bottom:16px">
            <div class="card-header"><i class="fas fa-map-marker-alt"></i> {{ __('main.delivery_address') }}</div>
            <div style="font-weight:700">{{ $order->address->label }}</div>
            <div style="font-size:14px;color:var(--text-muted);margin-top:4px">{{ $order->address->recipient_name }} · {{ $order->address->phone }}</div>
            <div style="font-size:14px">{{ $order->address->street }}, {{ $order->address->city }}</div>
          </div>
          @endif

          {{-- ORDER INFO --}}
          <div class="card">
            <div class="card-header"><i class="fas fa-info-circle"></i> {{ app()->getLocale()==='ar'?'معلومات الطلب':'Order Info' }}</div>
            <div style="font-size:14px;display:grid;gap:8px">
              <div class="order-row"><span>{{ __('main.payment_method') }}</span><strong>{{ __('main.'.$order->payment_method) }}</strong></div>
              <div class="order-row"><span>{{ app()->getLocale()==='ar'?'تاريخ الطلب':'Order Date' }}</span><span>{{ $order->created_at->format('d/m/Y H:i') }}</span></div>
              @if($order->delivered_at)
              <div class="order-row"><span>{{ app()->getLocale()==='ar'?'تاريخ التسليم':'Delivered At' }}</span><span>{{ $order->delivered_at->format('d/m/Y H:i') }}</span></div>
              @endif
              @if($order->notes)
              <div style="margin-top:8px;padding:10px;background:var(--primary-light);border-radius:8px;font-size:13px">{{ $order->notes }}</div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
@endsection
