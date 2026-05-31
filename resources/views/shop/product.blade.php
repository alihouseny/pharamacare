@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="container" style="padding:40px 20px;">

  {{-- BREADCRUMB --}}
  <div style="font-size:13px;color:var(--text-muted);margin-bottom:24px;">
    <a href="{{ route('home') }}" style="color:var(--primary);text-decoration:none">{{ __('main.home') }}</a> /
    <a href="{{ route('shop',['category'=>$product->category->slug]) }}" style="color:var(--primary);text-decoration:none">{{ $product->category->name }}</a> /
    {{ $product->name }}
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:40px;">

    {{-- IMAGE --}}
    <div>
      @if($product->image)
        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="width:100%;border-radius:var(--radius-lg);object-fit:cover;max-height:420px;">
      @else
        <div style="width:100%;height:380px;background:var(--primary-light);border-radius:var(--radius-lg);display:flex;align-items:center;justify-content:center;font-size:80px;color:var(--primary)"><i class="fas fa-pills"></i></div>
      @endif
    </div>

    {{-- INFO --}}
    <div>
      <div style="font-size:13px;color:var(--primary);font-weight:600;margin-bottom:6px;">{{ $product->category->name }}</div>
      <h1 style="font-size:26px;font-weight:900;margin-bottom:8px;">{{ $product->name }}</h1>

      @if($product->requires_prescription)
        <div style="background:#E3F2FD;border:1.5px solid #90CAF9;border-radius:10px;padding:12px 16px;margin-bottom:16px;font-size:14px;display:flex;gap:10px;align-items:center;">
          <i class="fas fa-file-prescription" style="color:var(--info);font-size:20px;"></i>
          <div>
            <strong>{{ __('main.requires_prescription') }}</strong><br>
            <span style="color:var(--text-muted)">{{ app()->getLocale()==='ar'?'يجب رفع الروشيتة الطبية قبل الطلب':'You must upload a valid prescription before ordering' }}</span>
          </div>
        </div>
      @endif

      <div style="margin-bottom:20px;">
        <span style="font-size:32px;font-weight:900;color:var(--primary);">{{ number_format($product->current_price,2) }} {{ __('main.sar') }}</span>
        @if($product->sale_price)
          <span style="font-size:18px;color:var(--text-muted);text-decoration:line-through;margin-start:10px;">{{ number_format($product->price,2) }}</span>
          <span style="background:var(--danger);color:#fff;font-size:12px;font-weight:700;padding:3px 8px;border-radius:6px;margin-start:8px">
            {{ round((1 - $product->sale_price / $product->price) * 100) }}% {{ app()->getLocale()==='ar'?'خصم':'OFF' }}
          </span>
        @endif
      </div>

      {{-- SPECS TABLE --}}
      <table style="width:100%;border-collapse:collapse;margin-bottom:24px;">
        @if($product->active_ingredient)
        <tr style="border-bottom:1px solid var(--border)">
          <td style="padding:8px 0;font-size:14px;font-weight:600;color:var(--text-muted);width:40%">{{ __('main.active_ingredient') }}</td>
          <td style="padding:8px 0;font-size:14px;font-weight:700;color:var(--info)">{{ $product->active_ingredient }}</td>
        </tr>
        @endif
        @if($product->manufacturer)
        <tr style="border-bottom:1px solid var(--border)">
          <td style="padding:8px 0;font-size:14px;color:var(--text-muted)">{{ __('main.manufacturer') }}</td>
          <td style="padding:8px 0;font-size:14px;">{{ $product->manufacturer }}</td>
        </tr>
        @endif
        @if($product->dosage_form)
        <tr style="border-bottom:1px solid var(--border)">
          <td style="padding:8px 0;font-size:14px;color:var(--text-muted)">{{ __('main.dosage_form') }}</td>
          <td style="padding:8px 0;font-size:14px;">{{ $product->dosage_form }}</td>
        </tr>
        @endif
        @if($product->strength)
        <tr style="border-bottom:1px solid var(--border)">
          <td style="padding:8px 0;font-size:14px;color:var(--text-muted)">{{ __('main.strength') }}</td>
          <td style="padding:8px 0;font-size:14px;font-weight:700;">{{ $product->strength }}</td>
        </tr>
        @endif
        @if($product->package_size)
        <tr>
          <td style="padding:8px 0;font-size:14px;color:var(--text-muted)">{{ __('main.package_size') }}</td>
          <td style="padding:8px 0;font-size:14px;">{{ $product->package_size }}</td>
        </tr>
        @endif
      </table>

      {{-- STOCK STATUS --}}
      <div style="margin-bottom:20px;">
        @if($product->stock > 0)
          <span class="badge badge-green"><i class="fas fa-check-circle"></i> {{ __('main.in_stock') }} ({{ $product->stock }})</span>
        @else
          <span class="badge badge-red">{{ __('main.out_of_stock') }}</span>
        @endif
      </div>

      {{-- ADD TO CART / SUBSCRIBE --}}
      <div style="display:flex;gap:12px;flex-wrap:wrap;">
        @if($product->stock > 0)
          @if($product->requires_prescription)
            <a href="{{ route('prescriptions.create') }}" class="btn btn-rx btn-lg">
              <i class="fas fa-file-prescription"></i> {{ __('main.upload_prescription') }}
            </a>
          @else
            <div style="display:flex;gap:10px;align-items:center;">
              <div class="qty-wrap" style="display:flex;align-items:center;gap:6px;border:2px solid var(--border);border-radius:50px;padding:4px 8px;">
                <button type="button" class="qty-btn" data-dir="down" style="background:none;border:none;font-size:18px;cursor:pointer;color:var(--text)">−</button>
                <input type="number" id="product-qty" value="1" min="1" max="{{ $product->stock }}" style="width:40px;text-align:center;border:none;outline:none;font-size:16px;font-weight:700;font-family:inherit;">
                <button type="button" class="qty-btn" data-dir="up" style="background:none;border:none;font-size:18px;cursor:pointer;color:var(--text)">+</button>
              </div>
              <button id="add-cart-btn" onclick="addToCartProduct()" class="btn btn-primary btn-lg">
                <i class="fas fa-cart-plus"></i> {{ __('main.add_to_cart') }}
              </button>
            </div>
            <div id="product-toast" style="display:none;margin-top:12px;background:#E8F5E9;border:1.5px solid var(--success);border-radius:10px;padding:10px 16px;color:var(--success);font-weight:600;font-size:14px">
              <i class="fas fa-check-circle"></i> {{ app()->getLocale()==='ar'?'تمت الإضافة للسلة':'Added to cart!' }}
            </div>
            <script>
            async function addToCartProduct() {
              const btn = document.getElementById('add-cart-btn');
              const qty = document.getElementById('product-qty').value;
              btn.disabled = true;
              btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ app()->getLocale()==="ar"?"جاري الإضافة...":"Adding..." }}';
              const res = await fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'},
                body: JSON.stringify({product_id: {{ $product->id }}, qty: parseInt(qty)})
              });
              const data = await res.json();
              btn.disabled = false;
              btn.innerHTML = '<i class="fas fa-check"></i> {{ app()->getLocale()==="ar"?"تمت الإضافة":"Added!" }}';
              if (data.success) {
                document.getElementById('product-toast').style.display = 'block';
                // Update cart badge in header
                document.querySelectorAll('.cart-badge').forEach(b => {
                  b.textContent = data.count; b.style.display = 'flex';
                });
                setTimeout(() => {
                  btn.innerHTML = '<i class="fas fa-cart-plus"></i> {{ __("main.add_to_cart") }}';
                  document.getElementById('product-toast').style.display = 'none';
                }, 2500);
              }
            }
            document.querySelectorAll('.qty-btn').forEach(btn => {
              btn.addEventListener('click', function() {
                const input = document.getElementById('product-qty');
                const val = parseInt(input.value) || 1;
                const max = parseInt(input.max) || 99;
                if (this.dataset.dir === 'up' && val < max) input.value = val + 1;
                if (this.dataset.dir === 'down' && val > 1) input.value = val - 1;
              });
            });
            </script>
          @endif

          {{-- SUBSCRIPTION BUTTON --}}
          @auth
          <button onclick="document.getElementById('sub-modal').style.display='flex'" class="btn btn-outline btn-lg">
            <i class="fas fa-sync-alt"></i> {{ __('main.subscribe_now') }}
          </button>
          @endauth
        @else
          <span class="btn-disabled btn-lg">{{ __('main.out_of_stock') }}</span>
        @endif
      </div>
    </div>
  </div>

  {{-- DESCRIPTION --}}
  @if($product->description)
  <div style="margin-top:48px;">
    <h2 style="font-size:20px;font-weight:800;margin-bottom:16px;padding-bottom:10px;border-bottom:2px solid var(--border)">
      {{ app()->getLocale()==='ar'?'وصف المنتج':'Description' }}
    </h2>
    <p style="color:var(--text-muted);line-height:1.9;">{{ $product->description }}</p>
  </div>
  @endif

  {{-- RELATED PRODUCTS --}}
  @if($related->count())
  <div style="margin-top:56px;">
    <h2 style="font-size:22px;font-weight:800;margin-bottom:24px;">{{ app()->getLocale()==='ar'?'منتجات ذات صلة':'Related Products' }}</h2>
    <div class="product-grid">
      @foreach($related as $p)
        @include('shop._product_card', ['product' => $p])
      @endforeach
    </div>
  </div>
  @endif
</div>

{{-- SUBSCRIPTION MODAL --}}
<div id="sub-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:200;align-items:center;justify-content:center;">
  <div class="card" style="width:440px;max-width:90vw;padding:28px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
      <h3 style="font-size:18px;font-weight:800;"><i class="fas fa-sync-alt" style="color:var(--primary)"></i> {{ __('main.subscribe_now') }}</h3>
      <button onclick="document.getElementById('sub-modal').style.display='none'" style="background:none;border:none;font-size:20px;cursor:pointer;color:var(--text-muted)">✕</button>
    </div>
    <form action="{{ route('subscriptions.store') }}" method="POST">
      @csrf
      <input type="hidden" name="product_id" value="{{ $product->id }}">
      <div class="form-group">
        <label class="form-label">{{ app()->getLocale()==='ar'?'الكمية':'Quantity' }}</label>
        <input type="number" name="quantity" class="form-control" value="1" min="1">
      </div>
      <div class="form-group">
        <label class="form-label">{{ __('main.frequency') }}</label>
        <select name="frequency_days" class="form-select">
          <option value="7">{{ app()->getLocale()==='ar'?'كل أسبوع':'Every Week' }}</option>
          <option value="14">{{ app()->getLocale()==='ar'?'كل أسبوعين':'Every 2 Weeks' }}</option>
          <option value="30" selected>{{ app()->getLocale()==='ar'?'كل شهر':'Every Month' }}</option>
          <option value="60">{{ app()->getLocale()==='ar'?'كل شهرين':'Every 2 Months' }}</option>
          <option value="90">{{ app()->getLocale()==='ar'?'كل 3 أشهر':'Every 3 Months' }}</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">{{ __('main.delivery_address') }}</label>
        <select name="address_id" class="form-select" required>
          <option value="">{{ app()->getLocale()==='ar'?'اختر العنوان...':'Choose address...' }}</option>
         @foreach(auth()->user()?->addresses ?? [] as $addr)
            <option value="{{ $addr->id }}">{{ $addr->label }} — {{ $addr->street }}, {{ $addr->city }}</option>
          @endforeach
        </select>
      </div>
     @if(empty(auth()->user()?->addresses?->toArray()))
        <p style="font-size:13px;color:var(--warning);margin-bottom:12px"><i class="fas fa-exclamation-triangle"></i> {{ app()->getLocale()==='ar'?'يجب إضافة عنوان أولاً':'Please add an address first' }}</p>
        <a href="{{ route('account.addresses') }}" class="btn btn-outline btn-block">{{ app()->getLocale()==='ar'?'إضافة عنوان':'Add Address' }}</a>
      @else
        <button type="submit" class="btn btn-primary btn-block">
          <i class="fas fa-check"></i> {{ app()->getLocale()==='ar'?'تأكيد الاشتراك':'Confirm Subscription' }}
        </button>
      @endif
    </form>
  </div>
</div>
@endsection
