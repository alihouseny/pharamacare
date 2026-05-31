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
</head>
<body class="{{ app()->getLocale()==='ar'?'rtl':'ltr' }}" style="min-height:100vh;display:flex;align-items:center;justify-content:center;background:var(--bg)">

  <div style="width:100%;max-width:460px;padding:20px;">
    {{-- LOGO --}}
    <div style="text-align:center;margin-bottom:32px">
      <a href="{{ route('home') }}" style="text-decoration:none;display:inline-flex;align-items:center;gap:12px">
        <div style="width:52px;height:52px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));border-radius:14px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:24px">
          <i class="fas fa-capsules"></i>
        </div>
        <div style="text-align:start">
          <div style="font-size:22px;font-weight:900;color:var(--primary)">{{ app()->getLocale()==='ar'?'فارماكير':'PharmaCare' }}</div>
          <div style="font-size:12px;color:var(--text-muted)">{{ app()->getLocale()==='ar'?'صحتك تبدأ هنا':'Your Health Starts Here' }}</div>
        </div>
      </a>
    </div>

    <div class="card" style="padding:32px">
      {{ $slot }}
    </div>

    {{-- LANG SWITCH --}}
    <div style="text-align:center;margin-top:20px;font-size:14px;color:var(--text-muted)">
      <a href="{{ route('lang', app()->getLocale()==='ar'?'en':'ar') }}" style="color:var(--primary);text-decoration:none">
        {{ app()->getLocale()==='ar'?'Switch to English':'التبديل للعربية' }}
      </a>
    </div>
  </div>

  <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/core@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
