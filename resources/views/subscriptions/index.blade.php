@extends('layouts.app')
@section('title', __('main.subscriptions'))

@section('content')
<div class="container" style="padding:40px 20px;">
  <h1 style="font-size:26px;font-weight:800;margin-bottom:8px;"><i class="fas fa-sync-alt" style="color:var(--primary)"></i> {{ __('main.monthly_subscription') }}</h1>
  <p style="color:var(--text-muted);margin-bottom:32px;">{{ app()->getLocale()==='ar'?'استلم أدويتك المزمنة تلقائياً كل شهر':'Receive your chronic medicines automatically every month' }}</p>

  @if($subscriptions->isEmpty())
    <div class="empty-state">
      <div class="empty-state-icon">🔄</div>
      <h3>{{ app()->getLocale()==='ar'?'لا توجد اشتراكات بعد':'No subscriptions yet' }}</h3>
      <p>{{ app()->getLocale()==='ar'?'تصفح الأدوية واشترك في الأدوية التي تأخذها باستمرار':'Browse medicines and subscribe to ones you take regularly' }}</p>
      <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top:20px">{{ __('main.shop') }}</a>
    </div>
  @else
    <div style="display:grid;gap:16px;">
      @foreach($subscriptions as $sub)
      <div class="card" style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
        <div style="flex:1">
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
            <h3 style="font-size:17px;font-weight:700;">{{ $sub->product->name }}</h3>
            <span class="badge {{ $sub->status==='active'?'badge-green':($sub->status==='paused'?'badge-orange':'badge-red') }}">
              {{ ['active'=>(app()->getLocale()==='ar'?'نشط':'Active'),'paused'=>(app()->getLocale()==='ar'?'متوقف':'Paused'),'cancelled'=>(app()->getLocale()==='ar'?'ملغي':'Cancelled')][$sub->status] }}
            </span>
          </div>
          <div style="font-size:14px;color:var(--text-muted)">
            {{ __('main.every_x_days', ['days' => $sub->frequency_days]) }} ·
            {{ app()->getLocale()==='ar'?'الكمية:':'Qty:' }} {{ $sub->quantity }}
          </div>
          <div style="font-size:14px;margin-top:4px;">
            <i class="fas fa-calendar-alt" style="color:var(--primary)"></i>
            {{ __('main.next_delivery') }}: <strong>{{ $sub->next_order_date->format('d M Y') }}</strong>
          </div>
        </div>
        <div style="display:flex;gap:8px;">
          @if($sub->status !== 'cancelled')
            <form action="{{ route('subscriptions.toggle', $sub) }}" method="POST">
              @csrf @method('PATCH')
              <button class="btn {{ $sub->status==='active'?'btn-outline':'btn-primary' }} btn-sm">
                {{ $sub->status==='active'?__('main.pause'):(app()->getLocale()==='ar'?'استئناف':'Resume') }}
              </button>
            </form>
            <form action="{{ route('subscriptions.destroy', $sub) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale()==='ar'?'تأكيد الإلغاء؟':'Confirm cancel?' }}')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm">{{ __('main.cancel_subscription') }}</button>
            </form>
          @endif
        </div>
      </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
