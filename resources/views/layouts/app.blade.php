<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale()==='ar'?'rtl':'ltr' }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', config('app.name')) — {{ app()->getLocale()==='ar'?'فارماكير':'PharmaCare' }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/pharmacy.css') }}">
  @stack('styles')
</head>
<body class="{{ app()->getLocale()==='ar'?'rtl':'ltr' }}">

  @include('layouts.navigation')

  @if(session('success'))
    <div style="background:#E8F5E9;border-bottom:2px solid var(--success);padding:12px 20px;text-align:center;color:var(--success);font-weight:600;font-size:14px">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div style="background:#FFEBEE;border-bottom:2px solid var(--danger);padding:12px 20px;text-align:center;color:var(--danger);font-weight:600;font-size:14px">
      <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
  @endif

  <main style="min-height:60vh">
    @yield('content')
    {{ $slot ?? '' }}
  </main>

  @include('layouts.footer')

  {{-- ADMIN SIDEBAR TOGGLE --}}
  <script>
  function toggleSidebar() {
    const sb  = document.getElementById('adminSidebar');
    const ov  = document.getElementById('sidebar-overlay');
    if (!sb) return;
    sb.classList.toggle('sidebar-open');
    if (ov) ov.classList.toggle('show');
  }
  function closeSidebar() {
    const sb = document.getElementById('adminSidebar');
    const ov = document.getElementById('sidebar-overlay');
    if (sb) sb.classList.remove('sidebar-open');
    if (ov) ov.classList.remove('show');
  }
  // Close on ESC
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });
  </script>

  @stack('scripts')
</body>
</html>
