@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'الرئيسية':'Home')

@section('content')

{{-- HERO --}}
<section class="hero">
  <div class="hero-content">
    <div class="hero-badge"><i class="fas fa-shield-alt"></i> {{ app()->getLocale()==='ar'?'موثوق ومعتمد':'Trusted & Certified' }}</div>
    <h1>{{ app()->getLocale()==='ar'?'صحتك تبدأ من هنا':'Your Health Starts Here' }}</h1>
    <p>{{ app()->getLocale()==='ar'
      ? 'أدوية أصلية، عناية متكاملة، توصيل سريع لباب بيتك'
      : 'Authentic medicines, complete care, fast delivery to your door' }}</p>
    <div class="hero-actions">
      <a href="{{ route('shop') }}" class="btn btn-primary btn-lg">
        <i class="fas fa-pills"></i> {{ app()->getLocale()==='ar'?'تسوق الآن':'Shop Now' }}
      </a>
      @auth
        <a href="{{ route('prescriptions.create') }}" class="btn btn-outline-light btn-lg">
          <i class="fas fa-file-prescription"></i> {{ __('main.upload_prescription') }}
        </a>
      @else
        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
          <i class="fas fa-user"></i> {{ __('main.login') }}
        </a>
      @endauth
    </div>
    <div class="hero-stats">
      <div><strong>+5000</strong><span>{{ app()->getLocale()==='ar'?'منتج':'Products' }}</span></div>
      <div><strong>24/7</strong><span>{{ app()->getLocale()==='ar'?'دعم':'Support' }}</span></div>
      <div><strong>100%</strong><span>{{ app()->getLocale()==='ar'?'أصلي':'Authentic' }}</span></div>
    </div>
  </div>
  <div class="hero-image">
    <div class="hero-circles">
      <div class="circle c1"><i class="fas fa-capsules"></i></div>
      <div class="circle c2"><i class="fas fa-heartbeat"></i></div>
      <div class="circle c3"><i class="fas fa-stethoscope"></i></div>
      <div class="circle c4"><i class="fas fa-syringe"></i></div>
    </div>
  </div>
</section>

{{-- CATEGORIES --}}
<section class="section">
  <div class="container">
    <div class="section-header">
      <h2>{{ app()->getLocale()==='ar'?'تصفح الأقسام':'Browse Categories' }}</h2>
    </div>
    <div class="cat-grid">
      @foreach($categories as $cat)
        <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="cat-card">
          <div class="cat-icon">{{ $cat->icon ?? '💊' }}</div>
          <h4>{{ $cat->name }}</h4>
          <span>{{ $cat->products_count ?? '' }}</span>
        </a>
      @endforeach
    </div>
  </div>
</section>

{{-- FEATURED PRODUCTS --}}
@if($featured->count())
<section class="section bg-light-blue">
  <div class="container">
    <div class="section-header">
      <h2>{{ app()->getLocale()==='ar'?'منتجات مميزة':'Featured Products' }}</h2>
      <a href="{{ route('shop',['filter'=>'featured']) }}" class="view-all">{{ __('main.view_all') }}</a>
    </div>
    <div class="product-grid">
      @foreach($featured as $p)
        @include('shop._product_card', ['product' => $p])
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- RX BANNER --}}
<section class="rx-banner">
  <div class="container">
    <div class="rx-content">
      <div class="rx-icon"><i class="fas fa-file-prescription"></i></div>
      <div>
        <h3>{{ app()->getLocale()==='ar'?'عندك روشيتة؟':'Got a Prescription?' }}</h3>
        <p>{{ app()->getLocale()==='ar'
          ? 'ارفع الروشيتة الطبية وسيقوم فريق الصيادلة بمراجعتها وتجهيز طلبك فوراً'
          : 'Upload your prescription and our pharmacists will review it and prepare your order right away' }}</p>
      </div>
      <a href="{{ route('prescriptions.create') }}" class="btn btn-white">
        {{ __('main.upload_prescription') }}
      </a>
    </div>
  </div>
</section>

{{-- NEW ARRIVALS --}}
@if($newArrivals->count())
<section class="section">
  <div class="container">
    <div class="section-header">
      <h2>{{ app()->getLocale()==='ar'?'وصل حديثاً':'New Arrivals' }}</h2>
      <a href="{{ route('shop') }}" class="view-all">{{ __('main.view_all') }}</a>
    </div>
    <div class="product-grid">
      @foreach($newArrivals as $p)
        @include('shop._product_card', ['product' => $p])
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ON SALE --}}
@if($onSale->count())
<section class="section sale-section">
  <div class="container">
    <div class="section-header">
      <h2>🔥 {{ app()->getLocale()==='ar'?'عروض خاصة':'Special Deals' }}</h2>
      <a href="{{ route('shop',['filter'=>'sale']) }}" class="view-all">{{ __('main.view_all') }}</a>
    </div>
    <div class="product-grid">
      @foreach($onSale as $p)
        @include('shop._product_card', ['product' => $p])
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- SUBSCRIPTION CTA --}}
<section class="subscription-cta">
  <div class="container">
    <div class="sub-cta-inner">
      <div>
        <span class="badge-pill">{{ app()->getLocale()==='ar'?'جديد':'New' }}</span>
        <h2>{{ app()->getLocale()==='ar'?'اشتراك الأدوية الشهري':'Monthly Medicine Subscription' }}</h2>
        <p>{{ app()->getLocale()==='ar'
          ? 'اشترك واستلم أدويتك المزمنة تلقائياً كل شهر بسعر خاص وتوصيل مجاني'
          : 'Subscribe and receive your chronic medicines automatically every month at a special price with free delivery' }}</p>
        <ul class="sub-features">
          <li><i class="fas fa-check"></i> {{ app()->getLocale()==='ar'?'توصيل أوتوماتيكي':'Automatic delivery' }}</li>
          <li><i class="fas fa-check"></i> {{ app()->getLocale()==='ar'?'خصم 10% على كل طلب':'10% off every order' }}</li>
          <li><i class="fas fa-check"></i> {{ app()->getLocale()==='ar'?'إلغاء في أي وقت':'Cancel anytime' }}</li>
        </ul>
        <a href="{{ route('subscriptions.index') }}" class="btn btn-primary">
          {{ __('main.subscribe_now') }}
        </a>
      </div>
      <div class="sub-cta-img">
        <i class="fas fa-sync-alt"></i>
      </div>
    </div>
  </div>
</section>

@endsection
