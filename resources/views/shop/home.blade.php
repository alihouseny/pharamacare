@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'الرئيسية':'Home')

@section('content')

{{-- HERO --}}
<section class="hero">
  <div class="container">
    <div class="hero-content">
      <div class="hero-badge"><i class="fas fa-shield-alt"></i> {{ app()->getLocale()==='ar'?'موثوق ومعتمد':'Trusted & Certified' }}</div>
      <h1>{{ app()->getLocale()==='ar'?'صحتك تبدأ من هنا':'Your Health Starts Here' }}</h1>
      <p>{{ app()->getLocale()==='ar'?'أدوية أصلية، عناية متكاملة، توصيل سريع لباب بيتك':'Authentic medicines, complete care, fast delivery to your door' }}</p>
      <div class="hero-actions">
        <a href="{{ route('shop') }}" class="btn btn-primary btn-lg">
          <i class="fas fa-pills"></i> {{ app()->getLocale()==='ar'?'تسوق الآن':'Shop Now' }}
        </a>
        @auth
          <a href="{{ route('prescriptions.create') }}" class="btn btn-outline-light btn-lg">
            <i class="fas fa-file-prescription"></i> {{ __('main.upload_prescription') }}
          </a>
        @else
          <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
            <i class="fas fa-user-plus"></i> {{ __('main.register') }}
          </a>
        @endauth
      </div>
      <div class="hero-stats">
        <div><strong>+1000</strong><span>{{ app()->getLocale()==='ar'?'منتج':'Products' }}</span></div>
        <div><strong>24/7</strong><span>{{ app()->getLocale()==='ar'?'دعم':'Support' }}</span></div>
        <div><strong>100%</strong><span>{{ app()->getLocale()==='ar'?'أصلي':'Authentic' }}</span></div>
      </div>
    </div>
    <div class="hero-image" style="display:flex;align-items:center;justify-content:center">
      <div style="position:relative;width:280px;height:280px">
        {{-- Central icon --}}
        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center">
          <div style="width:120px;height:120px;background:rgba(255,255,255,.18);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:54px;backdrop-filter:blur(4px)">
            💊
          </div>
        </div>
        {{-- Orbiting icons --}}
        <div style="position:absolute;top:10px;left:50%;transform:translateX(-50%);width:60px;height:60px;background:rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px;animation:float 3s ease-in-out infinite">❤️</div>
        <div style="position:absolute;bottom:10px;left:50%;transform:translateX(-50%);width:56px;height:56px;background:rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:22px;animation:float 3s ease-in-out infinite .8s">🩺</div>
        <div style="position:absolute;top:50%;left:10px;transform:translateY(-50%);width:52px;height:52px;background:rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;animation:float 3s ease-in-out infinite 1.4s">🔬</div>
        <div style="position:absolute;top:50%;right:10px;transform:translateY(-50%);width:52px;height:52px;background:rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;animation:float 3s ease-in-out infinite 2s">💉</div>
      </div>
    </div>
  </div>
</section>

<div class="container" style="padding-bottom:60px">

  {{-- CATEGORIES --}}
  @if($categories->count())
  <section style="margin-top:48px">
    <div class="section-header">
      <h2 class="section-title">{{ app()->getLocale()==='ar'?'تصفح الأقسام':'Browse Categories' }}</h2>
    </div>
    <div class="cats-grid">
      @foreach($categories as $cat)
      <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="cat-card">
        <div class="cat-icon">{{ $cat->icon ?? '💊' }}</div>
        <h4>{{ $cat->name }}</h4>
        @if($cat->products_count ?? null)
          <span>{{ $cat->products_count }} {{ app()->getLocale()==='ar'?'منتج':'items' }}</span>
        @endif
      </a>
      @endforeach
    </div>
  </section>
  @endif

  {{-- FEATURED PRODUCTS --}}
  @if($featured->count())
  <section style="margin-top:56px">
    <div class="section-header">
      <h2 class="section-title">{{ app()->getLocale()==='ar'?'منتجات مميزة':'Featured Products' }}</h2>
      <a href="{{ route('shop', ['filter' => 'featured']) }}" class="view-all">{{ __('main.view_all') }} ←</a>
    </div>
    <div class="products-grid">
      @foreach($featured as $product)
        @include('shop._product_card')
      @endforeach
    </div>
  </section>
  @endif

  {{-- SUBSCRIPTION BANNER --}}
  <section style="margin-top:56px;background:linear-gradient(135deg,var(--primary-dark),var(--primary));border-radius:24px;padding:40px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:24px;color:#fff">
    <div>
      <div style="font-size:13px;font-weight:700;opacity:.8;margin-bottom:8px;text-transform:uppercase;letter-spacing:1px">{{ app()->getLocale()==='ar'?'اشتراك شهري':'Monthly Subscription' }}</div>
      <h3 style="font-size:24px;font-weight:900;margin-bottom:8px">{{ app()->getLocale()==='ar'?'أدويتك كل شهر على باب بيتك':'Your medicines delivered monthly' }}</h3>
      <p style="opacity:.85;font-size:15px">{{ app()->getLocale()==='ar'?'وفّر 10% على أدوية الأمراض المزمنة مع الاشتراك الشهري':'Save 10% on chronic disease medications with monthly subscription' }}</p>
    </div>
    <a href="{{ route('subscriptions.index') }}" class="btn btn-white btn-lg">
      <i class="fas fa-sync-alt"></i> {{ app()->getLocale()==='ar'?'اشترك الآن':'Subscribe Now' }}
    </a>
  </section>

  {{-- NEW ARRIVALS --}}
  @if($newArrivals->count())
  <section style="margin-top:56px">
    <div class="section-header">
      <h2 class="section-title">{{ app()->getLocale()==='ar'?'وصل حديثاً':'New Arrivals' }}</h2>
      <a href="{{ route('shop') }}" class="view-all">{{ __('main.view_all') }} ←</a>
    </div>
    <div class="products-grid">
      @foreach($newArrivals as $product)
        @include('shop._product_card')
      @endforeach
    </div>
  </section>
  @endif

  {{-- ON SALE --}}
  @if($onSale->count())
  <section style="margin-top:56px">
    <div class="section-header">
      <h2 class="section-title">🔥 {{ app()->getLocale()==='ar'?'عروض وتخفيضات':'Sales & Offers' }}</h2>
      <a href="{{ route('shop', ['filter' => 'sale']) }}" class="view-all">{{ __('main.view_all') }} ←</a>
    </div>
    <div class="products-grid">
      @foreach($onSale as $product)
        @include('shop._product_card')
      @endforeach
    </div>
  </section>
  @endif

  {{-- RX BANNER --}}
  <section style="margin-top:56px;background:linear-gradient(135deg,#01579B,#0277BD);border-radius:24px;padding:36px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:24px;color:#fff">
    <div style="display:flex;align-items:center;gap:20px">
      <div style="font-size:52px">📋</div>
      <div>
        <h3 style="font-size:22px;font-weight:900;margin-bottom:6px">{{ app()->getLocale()==='ar'?'لديك روشيتة طبية؟':'Have a Prescription?' }}</h3>
        <p style="opacity:.85;font-size:14px">{{ app()->getLocale()==='ar'?'ارفع روشيتتك وسنجهّز طلبك فوراً وتصلك في أسرع وقت':'Upload your prescription and we\'ll prepare your order immediately' }}</p>
      </div>
    </div>
    @auth
      <a href="{{ route('prescriptions.create') }}" class="btn btn-white btn-lg">
        <i class="fas fa-upload"></i> {{ __('main.upload_prescription') }}
      </a>
    @else
      <a href="{{ route('login') }}" class="btn btn-white btn-lg">
        <i class="fas fa-sign-in-alt"></i> {{ __('main.login') }}
      </a>
    @endauth
  </section>

</div>
@endsection
