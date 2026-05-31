@extends('layouts.app')
@section('title', __('main.checkout'))

@section('content')
<div class="container checkout-grid">

  {{-- LEFT --}}
  <div>

    {{-- ADDRESS --}}
    <div class="checkout-section">
      <div class="card-header" style="font-size:18px;font-weight:800;margin-bottom:20px">
        <i class="fas fa-map-marker-alt" style="color:var(--primary)"></i> {{ __('main.delivery_address') }}
      </div>

      @if($addresses->isNotEmpty())
        {{-- Saved addresses --}}
        <div id="saved-addresses" style="display:grid;gap:12px;margin-bottom:16px;">
          @foreach($addresses as $addr)
            <label class="address-card card" style="cursor:pointer;padding:16px;border-radius:var(--radius);border:2px solid var(--border);transition:border-color .15s">
              <input type="radio" name="address_id" form="checkout-form" value="{{ $addr->id }}" {{ $loop->first ? 'checked' : '' }} style="display:none">
              <div style="font-weight:700;font-size:15px">{{ $addr->label }}</div>
              <div style="font-size:14px;color:var(--text-muted)"><i class="fas fa-user" style="width:16px"></i> {{ $addr->recipient_name }}</div>
              <div style="font-size:14px;color:var(--text-muted)"><i class="fas fa-phone" style="width:16px"></i> {{ $addr->phone }}</div>
              <div style="font-size:14px"><i class="fas fa-map-pin" style="width:16px;color:var(--primary)"></i> {{ $addr->street }}, {{ $addr->city }}</div>
            </label>
          @endforeach
        </div>
        <button type="button" onclick="document.getElementById('manual-addr').classList.toggle('hidden-addr')"
          style="font-size:13px;color:var(--primary);background:none;border:none;cursor:pointer;padding:0;margin-bottom:16px">
          <i class="fas fa-plus"></i> {{ app()->getLocale()==='ar'?'أو أدخل عنواناً جديداً':'Or enter a new address' }}
        </button>
      @endif

      {{-- Manual address form (always shown if no saved addresses) --}}
      <div id="manual-addr" class="{{ $addresses->isNotEmpty() ? 'hidden-addr' : '' }}">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
          <div class="form-group">
            <label class="form-label">{{ app()->getLocale()==='ar'?'اسم المستلم':'Recipient Name' }} *</label>
            <input type="text" name="recipient_name" form="checkout-form"
              class="form-control" value="{{ auth()->user()->name }}" placeholder="{{ app()->getLocale()==='ar'?'الاسم الكامل':'Full name' }}">
          </div>
          <div class="form-group">
            <label class="form-label">{{ app()->getLocale()==='ar'?'رقم الهاتف':'Phone Number' }} *</label>
            <input type="tel" name="phone" form="checkout-form"
              class="form-control" value="{{ auth()->user()->phone }}" placeholder="01xxxxxxxxx">
          </div>
          <div class="form-group" style="grid-column:1/-1">
            <label class="form-label">{{ app()->getLocale()==='ar'?'المدينة':'City' }} *</label>
            <input type="text" name="city" form="checkout-form" class="form-control" placeholder="{{ app()->getLocale()==='ar'?'القاهرة':'Cairo' }}">
          </div>
          <div class="form-group" style="grid-column:1/-1">
            <label class="form-label">{{ app()->getLocale()==='ar'?'العنوان التفصيلي':'Street Address' }} *</label>
            <input type="text" name="street" form="checkout-form" class="form-control" placeholder="{{ app()->getLocale()==='ar'?'الشارع، العمارة، الشقة...':'Street, building, apartment...' }}">
          </div>
          <div class="form-group">
            <label class="form-label">{{ app()->getLocale()==='ar'?'الحي (اختياري)':'Area (optional)' }}</label>
            <input type="text" name="area" form="checkout-form" class="form-control">
          </div>
          <div class="form-group" style="display:flex;align-items:center;gap:8px;margin-top:28px">
            <input type="checkbox" name="save_address" form="checkout-form" value="1" id="save_address" checked>
            <label for="save_address" style="cursor:pointer;font-size:14px">{{ app()->getLocale()==='ar'?'حفظ العنوان لاحقاً':'Save address for later' }}</label>
          </div>
        </div>
      </div>
    </div>

    {{-- PRESCRIPTION --}}
    @if($needsPrescription)
    <div class="checkout-section">
      <div class="card-header" style="font-size:18px;font-weight:800;margin-bottom:20px">
        <i class="fas fa-file-prescription" style="color:var(--info)"></i> {{ __('main.prescriptions') }}
      </div>
      @if($prescriptions->isEmpty())
        <div style="background:#E3F2FD;border-radius:10px;padding:16px;font-size:14px">
          <strong>{{ app()->getLocale()==='ar'?'بعض المنتجات تستلزم روشيتة طبية':'Some items require a prescription' }}</strong><br>
          <a href="{{ route('prescriptions.create') }}" class="btn btn-rx btn-sm" style="margin-top:10px">{{ __('main.upload_prescription') }}</a>
        </div>
      @else
        <select name="prescription_id" form="checkout-form" class="form-select">
          <option value="">{{ app()->getLocale()==='ar'?'اختر الروشيتة...':'Select prescription...' }}</option>
          @foreach($prescriptions as $rx)
            <option value="{{ $rx->id }}">{{ app()->getLocale()==='ar'?'روشيتة':'Prescription' }} #{{ $rx->id }} — {{ $rx->created_at->format('d/m/Y') }}</option>
          @endforeach
        </select>
      @endif
    </div>
    @endif

    {{-- PAYMENT --}}
    <div class="checkout-section">
      <div class="card-header" style="font-size:18px;font-weight:800;margin-bottom:20px">
        <i class="fas fa-credit-card" style="color:var(--primary)"></i> {{ __('main.payment_method') }}
      </div>
      <div style="display:grid;gap:10px;">
        <label style="display:flex;align-items:center;gap:14px;padding:16px;border:2px solid var(--border);border-radius:12px;cursor:pointer;transition:border-color .15s" onclick="this.style.borderColor='var(--primary)'">
          <input type="radio" name="payment_method" form="checkout-form" value="cod" checked>
          <i class="fas fa-money-bill-wave" style="font-size:22px;color:var(--success)"></i>
          <div><div style="font-weight:700">{{ app()->getLocale()==='ar'?'الدفع عند الاستلام':'Cash on Delivery' }}</div><div style="font-size:13px;color:var(--text-muted)">{{ app()->getLocale()==='ar'?'ادفع لما توصلك البضاعة':'Pay when you receive' }}</div></div>
        </label>
        <label style="display:flex;align-items:center;gap:14px;padding:16px;border:2px solid var(--border);border-radius:12px;cursor:pointer;transition:border-color .15s">
          <input type="radio" name="payment_method" form="checkout-form" value="card">
          <i class="fas fa-credit-card" style="font-size:22px;color:var(--info)"></i>
          <div><div style="font-weight:700">{{ app()->getLocale()==='ar'?'بطاقة ائتمان':'Credit Card' }}</div><div style="font-size:13px;color:var(--text-muted)">Visa / Mastercard</div></div>
        </label>
      </div>
    </div>

    {{-- NOTES --}}
    <div class="checkout-section">
      <label class="form-label"><i class="fas fa-comment"></i> {{ app()->getLocale()==='ar'?'ملاحظات للطلب (اختياري)':'Order notes (optional)' }}</label>
      <textarea name="notes" form="checkout-form" class="form-control" rows="3"
        placeholder="{{ app()->getLocale()==='ar'?'أي تعليمات خاصة للتوصيل...':'Any special delivery instructions...' }}"></textarea>
    </div>
  </div>

  {{-- RIGHT: ORDER SUMMARY --}}
  <div>
    <div class="card order-summary-card" style="position:sticky;top:90px">
      <div class="card-header"><i class="fas fa-receipt"></i> {{ app()->getLocale()==='ar'?'ملخص الطلب':'Order Summary' }}</div>

      @foreach($items as $item)
      <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border)">
        @if($item['product']->image)
          <img src="{{ asset('storage/'.$item['product']->image) }}" style="width:52px;height:52px;object-fit:cover;border-radius:8px;flex-shrink:0">
        @else
          <div style="width:52px;height:52px;background:var(--primary-light);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--primary);flex-shrink:0"><i class="fas fa-pills"></i></div>
        @endif
        <div style="flex:1;min-width:0">
          <div style="font-size:14px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $item['product']->name }}</div>
          <div style="font-size:13px;color:var(--text-muted)">{{ $item['qty'] }} × {{ number_format($item['product']->current_price,2) }}</div>
        </div>
        <div style="font-weight:700;flex-shrink:0">{{ number_format($item['subtotal'],2) }}</div>
      </div>
      @endforeach

      <div class="order-row" style="margin-top:12px"><span>{{ __('main.subtotal') }}</span><span>{{ number_format($subtotal,2) }} {{ __('main.sar') }}</span></div>
      <div class="order-row"><span>{{ __('main.delivery_fee') }}</span>
        <span style="color:{{ $deliveryFee==0?'var(--success)':'inherit' }}">
          {{ $deliveryFee==0 ? __('main.free') : number_format($deliveryFee,2).' '.__('main.sar') }}
        </span>
      </div>
      @if($deliveryFee > 0)
        <div style="font-size:12px;color:var(--text-muted);margin-bottom:8px">
          <i class="fas fa-info-circle"></i> {{ app()->getLocale()==='ar'?'التوصيل مجاني للطلبات أكثر من 200 ج.م':'Free delivery for orders over 200 EGP' }}
        </div>
      @endif
      <div class="order-row"><strong>{{ __('main.total') }}</strong><strong style="color:var(--primary);font-size:20px">{{ number_format($total,2) }} {{ __('main.sar') }}</strong></div>

      <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">@csrf</form>
      <button type="submit" form="checkout-form" class="btn btn-primary btn-block btn-lg" style="margin-top:20px">
        <i class="fas fa-lock"></i> {{ __('main.place_order') }}
      </button>
      <div style="text-align:center;font-size:12px;color:var(--text-muted);margin-top:10px">
        <i class="fas fa-shield-alt"></i> {{ app()->getLocale()==='ar'?'معاملة آمنة ومشفرة':'Secure & encrypted transaction' }}
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>
.hidden-addr { display:none !important; }
.address-card:has(input:checked) { border-color:var(--primary)!important; background:var(--primary-light); }
</style>
@endpush
@endsection
