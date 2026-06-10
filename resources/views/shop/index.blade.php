@extends('layouts.app')
@section('title', $activeCategory ? $activeCategory->name : __('main.shop'))

@section('content')
<div class="container">
  <div class="shop-layout">

    {{-- FILTERS SIDEBAR --}}
    <aside class="shop-filters">
      <div class="card" style="padding:20px">
        <div style="font-weight:800;font-size:15px;margin-bottom:18px;display:flex;align-items:center;gap:8px">
          <i class="fas fa-filter" style="color:var(--primary)"></i>
          {{ app()->getLocale()==='ar'?'تصفية':'Filter' }}
        </div>

        <div class="filter-section">
          <div class="filter-section-title">{{ app()->getLocale()==='ar'?'الأقسام':'Categories' }}</div>
          <a href="{{ route('shop') }}" class="filter-link {{ !request('category') && !request('filter') ? 'active' : '' }}">
            🏪 {{ app()->getLocale()==='ar'?'جميع المنتجات':'All Products' }}
          </a>
          @foreach($categories as $cat)
            <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="filter-link {{ request('category') === $cat->slug ? 'active' : '' }}">
              {{ $cat->icon ?? '💊' }} {{ $cat->name }}
              @if($cat->products_count ?? 0)
                <span style="margin-inline-start:auto;font-size:11px;color:var(--text-muted)">{{ $cat->products_count }}</span>
              @endif
            </a>
          @endforeach
        </div>

        <div class="filter-section" style="border-top:1px solid var(--border);padding-top:16px">
          <div class="filter-section-title">{{ app()->getLocale()==='ar'?'النوع':'Type' }}</div>
          <a href="{{ route('shop', array_merge(request()->except('filter'), ['filter' => 'otc'])) }}" class="filter-link {{ request('filter') === 'otc' ? 'active' : '' }}">
            <i class="fas fa-check-circle" style="color:var(--success);font-size:13px"></i> {{ app()->getLocale()==='ar'?'بدون روشيتة':'OTC' }}
          </a>
          <a href="{{ route('shop', array_merge(request()->except('filter'), ['filter' => 'rx'])) }}" class="filter-link {{ request('filter') === 'rx' ? 'active' : '' }}">
            <i class="fas fa-prescription" style="color:var(--info);font-size:13px"></i> {{ app()->getLocale()==='ar'?'يستلزم روشيتة':'Requires Rx' }}
          </a>
          <a href="{{ route('shop', array_merge(request()->except('filter'), ['filter' => 'sale'])) }}" class="filter-link {{ request('filter') === 'sale' ? 'active' : '' }}">
            🔥 {{ app()->getLocale()==='ar'?'عروض':'On Sale' }}
          </a>
          <a href="{{ route('shop', array_merge(request()->except('filter'), ['filter' => 'featured'])) }}" class="filter-link {{ request('filter') === 'featured' ? 'active' : '' }}">
            ⭐ {{ app()->getLocale()==='ar'?'مميزة':'Featured' }}
          </a>
        </div>
      </div>
    </aside>

    {{-- PRODUCTS AREA --}}
    <div style="min-width:0">

      {{-- TOOLBAR --}}
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
        <div>
          <h1 style="font-size:20px;font-weight:900">
            {{ $activeCategory ? $activeCategory->name : (app()->getLocale()==='ar'?'جميع المنتجات':'All Products') }}
          </h1>
          <div style="font-size:13px;color:var(--text-muted)">
            {{ $products->total() }} {{ app()->getLocale()==='ar'?'منتج':'product(s)' }}
            @if(request('q')) — "{{ request('q') }}" @endif
          </div>
        </div>
        <form action="{{ route('shop') }}" method="GET" style="display:flex;gap:8px">
          @foreach(request()->except('sort') as $k => $v)
            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
          @endforeach
          <select name="sort" class="form-select" style="font-size:13px;padding:7px 12px;width:auto" onchange="this.form.submit()">
            <option value="">{{ app()->getLocale()==='ar'?'الأحدث':'Latest' }}</option>
            <option value="price_asc"  {{ request('sort') === 'price_asc'  ? 'selected' : '' }}>{{ app()->getLocale()==='ar'?'السعر ↑':'Price ↑' }}</option>
            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>{{ app()->getLocale()==='ar'?'السعر ↓':'Price ↓' }}</option>
            <option value="name"       {{ request('sort') === 'name'       ? 'selected' : '' }}>{{ app()->getLocale()==='ar'?'الاسم أ-ي':'Name A-Z' }}</option>
          </select>
        </form>
      </div>

      {{-- ACTIVE FILTERS --}}
      @if(request('q') || request('category') || request('filter'))
      <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px">
        @if(request('q'))
          <a href="{{ route('shop', request()->except('q')) }}" class="badge badge-blue" style="text-decoration:none">
            🔍 {{ request('q') }} ✕
          </a>
        @endif
        @if(request('category') && $activeCategory)
          <a href="{{ route('shop', request()->except('category')) }}" class="badge badge-green" style="text-decoration:none">
            {{ $activeCategory->name }} ✕
          </a>
        @endif
        @if(request('filter'))
          <a href="{{ route('shop', request()->except('filter')) }}" class="badge badge-orange" style="text-decoration:none">
            {{ request('filter') }} ✕
          </a>
        @endif
        <a href="{{ route('shop') }}" style="font-size:13px;color:var(--danger);text-decoration:none">
          {{ app()->getLocale()==='ar'?'مسح الكل':'Clear all' }}
        </a>
      </div>
      @endif

      {{-- PRODUCTS GRID --}}
      @if($products->isEmpty())
        <div class="empty-state">
          <div class="empty-state-icon">🔍</div>
          <h3>{{ app()->getLocale()==='ar'?'لا توجد نتائج':'No products found' }}</h3>
          <p style="margin-top:8px;color:var(--text-muted)">{{ app()->getLocale()==='ar'?'جرّب البحث بكلمات مختلفة':'Try different search terms' }}</p>
          <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top:20px">{{ app()->getLocale()==='ar'?'عرض الكل':'View All' }}</a>
        </div>
      @else
        <div class="products-grid">
          @foreach($products as $product)
            @include('shop._product_card')
          @endforeach
        </div>
        <div style="margin-top:28px;display:flex;justify-content:center">
          {{ $products->withQueryString()->links() }}
        </div>
      @endif
    </div>

    {{-- CART SIDEBAR --}}
    <div id="cart-sidebar" style="width:270px;flex-shrink:0;position:sticky;top:90px;display:none">
      <div class="card" style="padding:0;overflow:hidden">
        <div style="padding:14px 18px;font-weight:800;font-size:15px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center">
          <span><i class="fas fa-shopping-cart" style="color:var(--primary)"></i> {{ app()->getLocale()==='ar'?'السلة':'Cart' }}</span>
          <span id="cart-sidebar-count" class="badge badge-green">0</span>
        </div>
        <div id="cart-sidebar-items" style="max-height:380px;overflow-y:auto;padding:12px 16px">
          <div style="text-align:center;padding:20px;color:var(--text-muted);font-size:13px">
            <i class="fas fa-shopping-cart" style="font-size:28px;opacity:.3;display:block;margin-bottom:8px"></i>
            {{ app()->getLocale()==='ar'?'السلة فارغة':'Cart is empty' }}
          </div>
        </div>
        <div id="cart-sidebar-footer" style="padding:14px 16px;border-top:1px solid var(--border);display:none">
          <div style="display:flex;justify-content:space-between;font-weight:800;font-size:15px;margin-bottom:12px">
            <span>{{ app()->getLocale()==='ar'?'الإجمالي':'Total' }}</span>
            <span id="cart-sidebar-total" style="color:var(--primary)">0</span>
          </div>
          <a href="{{ route('cart') }}" class="btn btn-outline btn-block btn-sm" style="margin-bottom:8px">
            <i class="fas fa-eye"></i> {{ app()->getLocale()==='ar'?'عرض السلة':'View Cart' }}
          </a>
          <a href="{{ route('checkout') }}" class="btn btn-primary btn-block btn-sm">
            <i class="fas fa-credit-card"></i> {{ app()->getLocale()==='ar'?'إتمام الشراء':'Checkout' }}
          </a>
        </div>
      </div>
    </div>

  </div>
</div>

{{-- TOAST --}}
<div id="cart-toast" style="position:fixed;bottom:24px;{{ app()->getLocale()==='ar'?'left':'right' }}:24px;background:var(--primary);color:#fff;padding:12px 20px;border-radius:12px;box-shadow:var(--shadow-lg);font-weight:600;font-size:14px;display:none;align-items:center;gap:10px;z-index:9999">
  <i class="fas fa-check-circle"></i> <span id="cart-toast-msg"></span>
</div>

@push('scripts')
<script>
const CART_ADD_URL = "{{ route('cart.add') }}";
const CSRF_TOKEN   = "{{ csrf_token() }}";
const LANG_SAR     = "{{ __('main.sar') }}";
const LANG_ADDED   = "{{ app()->getLocale()==='ar'?'تمت الإضافة':'Added to cart' }}";

async function removeFromSidebar(productId) {
  var res  = await fetch('/cart/' + productId, {method:'DELETE', headers:{'X-CSRF-TOKEN':CSRF_TOKEN,'Accept':'application/json'}});
  var data = await res.json();
  if (data.success) { updateCartSidebar(data); updateCartBadge(data.count); }
}

function updateCartSidebar(data) {
  var sidebar  = document.getElementById('cart-sidebar');
  var itemsEl  = document.getElementById('cart-sidebar-items');
  var footerEl = document.getElementById('cart-sidebar-footer');
  var countEl  = document.getElementById('cart-sidebar-count');
  var totalEl  = document.getElementById('cart-sidebar-total');
  if (data.count > 0) {
    sidebar.style.display = 'block';
    footerEl.style.display = 'block';
    countEl.textContent = data.count;
    totalEl.textContent = parseFloat(data.total).toFixed(2) + ' ' + LANG_SAR;
    var html = '';
    data.items.forEach(function(item) {
      html += '<div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--border)">'
        + (item.image ? '<img src="'+item.image+'" style="width:40px;height:40px;object-fit:cover;border-radius:8px;flex-shrink:0">' : '<div style="width:40px;height:40px;background:var(--primary-light);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--primary);flex-shrink:0"><i class="fas fa-pills"></i></div>')
        + '<div style="flex:1;min-width:0"><div style="font-size:13px;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">'+item.name+'</div>'
        + '<div style="font-size:12px;color:var(--text-muted)">'+item.qty+' × '+parseFloat(item.price).toFixed(2)+' '+LANG_SAR+'</div></div>'
        + '<button onclick="removeFromSidebar('+item.id+')" style="background:none;border:none;color:var(--danger);cursor:pointer;font-size:14px;padding:0;flex-shrink:0"><i class="fas fa-times"></i></button>'
        + '</div>';
    });
    itemsEl.innerHTML = html;
  } else {
    sidebar.style.display = 'none';
  }
}

function showToast(msg) {
  var toast = document.getElementById('cart-toast');
  document.getElementById('cart-toast-msg').textContent = msg;
  toast.style.display = 'flex';
  setTimeout(function(){ toast.style.display = 'none'; }, 2500);
}

// Override addToCart for shop page (also updates sidebar)
window._origAddToCart = window.addToCart;
window.addToCart = async function(productId, btn) {
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
  try {
    var res  = await fetch(CART_ADD_URL, {method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF_TOKEN,'Accept':'application/json'},body:JSON.stringify({product_id:productId,qty:1})});
    var data = await res.json();
    btn.disabled = false;
    if (data.success) {
      btn.innerHTML = '<i class="fas fa-check"></i>';
      updateCartBadge(data.count);
      updateCartSidebar(data);
      showToast(LANG_ADDED + ': ' + btn.dataset.name);
      checkCartInteractions();
      setTimeout(function(){ btn.innerHTML = '<i class="fas fa-cart-plus"></i>'; }, 1500);
    } else { btn.innerHTML = '<i class="fas fa-cart-plus"></i>'; }
  } catch(e) { btn.disabled = false; btn.innerHTML = '<i class="fas fa-cart-plus"></i>'; }
};

// Load cart on page load
window.addEventListener('DOMContentLoaded', async function() {
  try {
    var res  = await fetch('/cart/sidebar', {headers:{'Accept':'application/json'}});
    var data = await res.json();
    if (data.count > 0) updateCartSidebar(data);
    updateCartBadge(data.count);
  } catch(e) {}
});
</script>
@endpush
@endsection
