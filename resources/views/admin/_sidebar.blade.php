{{-- OVERLAY (mobile) --}}
<div id="sidebar-overlay" onclick="closeSidebar()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:99"></div>

<aside class="admin-sidebar" id="adminSidebar">
  <div class="sidebar-logo">
    <i class="fas fa-capsules"></i>
    <span>{{ app()->getLocale()==='ar'?'فارماكير':'PharmaCare' }}</span>
    <button onclick="closeSidebar()" style="margin-start:auto;background:none;border:none;color:rgba(255,255,255,.6);cursor:pointer;font-size:18px;display:none" id="sidebar-close-btn">
      <i class="fas fa-times"></i>
    </button>
  </div>
  <nav class="sidebar-nav">
    <div class="sidebar-section">{{ app()->getLocale()==='ar'?'الرئيسية':'Main' }}</div>
    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard')?'active':'' }}">
      <i class="fas fa-tachometer-alt"></i> {{ app()->getLocale()==='ar'?'لوحة التحكم':'Dashboard' }}
    </a>

    <div class="sidebar-section">{{ app()->getLocale()==='ar'?'الطلبات':'Orders' }}</div>
    <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders*')?'active':'' }}">
      <i class="fas fa-shopping-bag"></i> {{ app()->getLocale()==='ar'?'الطلبات':'Orders' }}
      @php $pending = \App\Models\Order::where('status','pending')->count(); @endphp
      @if($pending)<span class="badge-count">{{ $pending }}</span>@endif
    </a>

    <div class="sidebar-section">{{ app()->getLocale()==='ar'?'الصيدلية':'Pharmacy' }}</div>
    <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products*')?'active':'' }}">
      <i class="fas fa-pills"></i> {{ app()->getLocale()==='ar'?'المنتجات':'Products' }}
    </a>
    <a href="{{ route('admin.expiry.index') }}" class="sidebar-link {{ request()->routeIs('admin.expiry*')?'active':'' }}">
      <i class="fas fa-calendar-times"></i> {{ app()->getLocale()==='ar'?'الصلاحية':'Expiry' }}
    </a>
    <a href="{{ route('admin.prescriptions.index') }}" class="sidebar-link {{ request()->routeIs('admin.prescriptions*')?'active':'' }}">
      <i class="fas fa-file-prescription"></i> {{ app()->getLocale()==='ar'?'الروشيتات':'Prescriptions' }}
      @php $pendingRx = \App\Models\Prescription::where('status','pending')->count(); @endphp
      @if($pendingRx)<span class="badge-count">{{ $pendingRx }}</span>@endif
    </a>

    <div class="sidebar-section">{{ app()->getLocale()==='ar'?'المستخدمون':'Users' }}</div>
    <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users*')?'active':'' }}">
      <i class="fas fa-users"></i> {{ app()->getLocale()==='ar'?'إدارة المستخدمين':'Users' }}
    </a>

    <div class="sidebar-section">{{ app()->getLocale()==='ar'?'أخرى':'Other' }}</div>
    <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
      <i class="fas fa-store"></i> {{ app()->getLocale()==='ar'?'المتجر':'Store' }}
    </a>
    <form id="admin-logout" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
    <a href="#" class="sidebar-link" onclick="event.preventDefault();document.getElementById('admin-logout').submit()">
      <i class="fas fa-sign-out-alt"></i> {{ app()->getLocale()==='ar'?'خروج':'Logout' }}
    </a>
  </nav>
</aside>
