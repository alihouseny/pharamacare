<header class="site-header">
  <div class="header-inner container">

    {{-- LOGO --}}
    <a href="{{ route('home') }}" class="logo">
      <div class="logo-icon"><i class="fas fa-capsules"></i></div>
      <div class="logo-text">
        <span class="logo-main">{{ app()->getLocale()==='ar'?'فارماكير':'PharmaCare' }}</span>
        <span class="logo-sub">{{ app()->getLocale()==='ar'?'صحتك تبدأ هنا':'Your Health Starts Here' }}</span>
      </div>
    </a>

    {{-- SEARCH --}}
    <form action="{{ route('shop') }}" method="GET" class="search-bar" style="flex:1;max-width:480px;">
      <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('main.search_by') }}">
      <button type="submit"><i class="fas fa-search"></i></button>
    </form>

    {{-- ACTIONS --}}
    <div class="header-actions">

      {{-- LANG --}}
      <a href="{{ route('lang', app()->getLocale()==='ar'?'en':'ar') }}" class="action-btn" style="padding:8px 12px;font-weight:700">
        {{ app()->getLocale()==='ar'?'EN':'ع' }}
      </a>

      {{-- CART --}}
      <a href="{{ route('cart') }}" class="action-btn cart-btn" style="position:relative">
        <i class="fas fa-shopping-cart"></i>
        @php $cartCount = array_sum(array_column(session()->get('cart',[]),'qty')); @endphp
        @if($cartCount > 0)
          <span class="cart-badge">{{ $cartCount }}</span>
        @endif
      </a>

      @auth
        {{-- USER DROPDOWN - Pure CSS + checkbox trick (no Alpine needed) --}}
        <div class="nav-dropdown-wrap">
          <button class="action-btn nav-dropdown-toggle" style="gap:6px" onclick="toggleNavDropdown(event)">
            <i class="fas fa-user-circle" style="font-size:18px"></i>
            <span style="font-size:14px;max-width:90px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ explode(' ', auth()->user()->name)[0] }}</span>
            <i class="fas fa-chevron-down" style="font-size:10px"></i>
          </button>
          <div class="nav-dropdown-menu" id="navDropdownMenu">
            <div class="nav-dropdown-header">
              <div style="font-weight:800;font-size:15px">{{ auth()->user()->name }}</div>
              <div style="font-size:12px;color:var(--text-muted)">{{ auth()->user()->email }}</div>
              @if(auth()->user()->isPharmacist())
                <span style="display:inline-block;margin-top:4px;background:var(--accent);color:#fff;font-size:11px;padding:2px 8px;border-radius:20px;font-weight:700">
                  {{ app()->getLocale()==='ar'?'صيدلاني / أدمن':'Pharmacist' }}
                </span>
              @endif
            </div>

            <a href="{{ route('account.dashboard') }}" class="nav-dropdown-item">
              <i class="fas fa-tachometer-alt" style="color:var(--primary)"></i>
              {{ __('main.my_account') }}
            </a>
            <a href="{{ route('account.orders') }}" class="nav-dropdown-item">
              <i class="fas fa-list-alt" style="color:var(--primary)"></i>
              {{ __('main.orders') }}
            </a>
            <a href="{{ route('prescriptions.index') }}" class="nav-dropdown-item">
              <i class="fas fa-file-prescription" style="color:var(--info)"></i>
              {{ __('main.prescriptions') }}
            </a>
            <a href="{{ route('subscriptions.index') }}" class="nav-dropdown-item">
              <i class="fas fa-sync-alt" style="color:var(--success)"></i>
              {{ __('main.subscriptions') }}
            </a>
            <a href="{{ route('account.addresses') }}" class="nav-dropdown-item">
              <i class="fas fa-map-marker-alt" style="color:var(--accent)"></i>
              {{ app()->getLocale()==='ar'?'عناويني':'My Addresses' }}
            </a>
            <a href="{{ route('profile.edit') }}" class="nav-dropdown-item">
              <i class="fas fa-user-edit" style="color:var(--text-muted)"></i>
              {{ app()->getLocale()==='ar'?'تعديل الملف الشخصي':'Edit Profile' }}
            </a>

            @if(auth()->user()->isPharmacist())
              <div class="nav-dropdown-divider"></div>
              <a href="{{ route('admin.dashboard') }}" class="nav-dropdown-item" style="color:var(--accent);font-weight:700">
                <i class="fas fa-cog" style="color:var(--accent)"></i>
                {{ app()->getLocale()==='ar'?'لوحة التحكم':'Admin Panel' }}
              </a>
            @endif

            <div class="nav-dropdown-divider"></div>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="nav-dropdown-item nav-dropdown-logout">
                <i class="fas fa-sign-out-alt"></i>
                {{ __('main.logout') }}
              </button>
            </form>
          </div>
        </div>

      @else
        <a href="{{ route('login') }}" class="action-btn" style="font-size:14px">
          <i class="fas fa-sign-in-alt"></i> {{ __('main.login') }}
        </a>
        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">{{ __('main.register') }}</a>
      @endauth
    </div>
  </div>
</header>

<script>
function toggleNavDropdown(e) {
  e.stopPropagation();
  var menu = document.getElementById('navDropdownMenu');
  menu.classList.toggle('open');
}
document.addEventListener('click', function() {
  var menu = document.getElementById('navDropdownMenu');
  if (menu) menu.classList.remove('open');
});
</script>
