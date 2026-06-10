<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e(app()->getLocale()==='ar'?'rtl':'ltr'); ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <meta name="theme-color" content="#00897B">
  <link rel="manifest" href="/manifest.json">
  <title><?php echo $__env->yieldContent('title', 'PharmaCare'); ?> — <?php echo e(app()->getLocale()==='ar'?'فارماكير':'PharmaCare'); ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="<?php echo e(asset('css/pharmacy.css')); ?>">
  <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="<?php echo e(app()->getLocale()==='ar'?'rtl':'ltr'); ?>">

  
  <div class="topbar">
    <div class="container">
      <span>
        <i class="fas fa-phone-alt"></i>
        <a href="tel:+201229662819" style="color:rgba(255,255,255,.9);text-decoration:none">01229662819</a>
        &nbsp;|&nbsp;
        <a href="https://wa.me/201229662819" target="_blank" style="color:rgba(255,255,255,.9);text-decoration:none">
          <i class="fab fa-whatsapp" style="color:#25D366"></i> WhatsApp
        </a>
      </span>
      <span>
        <i class="fas fa-clock"></i>
        <?php echo e(app()->getLocale()==='ar'?'السبت – الخميس: ٩ص – ١١م':'Sat – Thu: 9AM – 11PM'); ?>

      </span>
    </div>
  </div>

  <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <?php if(session('success')): ?>
    <div style="background:#E8F5E9;border-bottom:2px solid var(--success);padding:10px 20px;text-align:center;color:var(--success);font-weight:600;font-size:14px">
      <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>
  <?php if(session('error')): ?>
    <div style="background:#FFEBEE;border-bottom:2px solid var(--danger);padding:10px 20px;text-align:center;color:var(--danger);font-weight:600;font-size:14px">
      <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

    </div>
  <?php endif; ?>

  <main style="min-height:60vh">
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo e($slot ?? ''); ?>

  </main>

  <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  
  <div id="interaction-alert" class="interaction-alert">
    <i class="fas fa-exclamation-triangle" style="font-size:20px;flex-shrink:0;margin-top:2px"></i>
    <div style="flex:1">
      <div style="font-weight:800;font-size:14px;margin-bottom:4px"><?php echo e(app()->getLocale()==='ar'?'تحذير: تفاعل دوائي!':'Warning: Drug Interaction!'); ?></div>
      <div id="interaction-msg" style="font-size:13px;opacity:.9"></div>
    </div>
    <button onclick="this.closest('.interaction-alert').classList.remove('show')" style="background:none;border:none;color:#fff;cursor:pointer;font-size:18px;flex-shrink:0;padding:0">✕</button>
  </div>

  
  <div id="pwa-install-banner">
    <div style="display:flex;align-items:center;gap:12px">
      <span style="font-size:24px">💊</span>
      <div>
        <div style="font-weight:800;font-size:14px"><?php echo e(app()->getLocale()==='ar'?'ثبّت فارماكير على هاتفك':'Install PharmaCare App'); ?></div>
        <div style="font-size:12px;opacity:.8"><?php echo e(app()->getLocale()==='ar'?'وصول سريع بدون متصفح':'Quick access without browser'); ?></div>
      </div>
    </div>
    <div style="display:flex;gap:8px">
      <button id="pwa-install-btn" style="background:#fff;color:var(--primary);border:none;padding:8px 16px;border-radius:8px;font-weight:700;cursor:pointer;font-size:13px"><?php echo e(app()->getLocale()==='ar'?'تثبيت':'Install'); ?></button>
      <button onclick="this.closest('#pwa-install-banner').classList.remove('show');localStorage.setItem('pwa-dismissed','1')" style="background:rgba(255,255,255,.2);color:#fff;border:none;padding:8px 12px;border-radius:8px;cursor:pointer">✕</button>
    </div>
  </div>

  <script>
  // ── SIDEBAR TOGGLE ────────────────────────────────────
  function toggleSidebar() {
    var sb = document.getElementById('adminSidebar');
    var ov = document.getElementById('sidebar-overlay');
    if (!sb) return;
    sb.classList.toggle('sidebar-open');
    if (ov) ov.classList.toggle('show');
  }
  function closeSidebar() {
    var sb = document.getElementById('adminSidebar');
    var ov = document.getElementById('sidebar-overlay');
    if (sb) sb.classList.remove('sidebar-open');
    if (ov) ov.classList.remove('show');
  }
  document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeSidebar(); });

  // ── CART AJAX ─────────────────────────────────────────
  async function addToCart(productId, btn) {
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    try {
      var res  = await fetch('/cart/add', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>','Accept':'application/json'},
        body: JSON.stringify({product_id: productId, qty: 1})
      });
      var data = await res.json();
      btn.disabled = false;
      if (data.success) {
        btn.innerHTML = '<i class="fas fa-check"></i>';
        updateCartBadge(data.count);
        if (typeof updateCartSidebar === 'function') updateCartSidebar(data);
        checkCartInteractions();
        setTimeout(function(){ btn.innerHTML = '<i class="fas fa-cart-plus"></i>'; }, 1500);
      } else {
        btn.innerHTML = '<i class="fas fa-cart-plus"></i>';
      }
    } catch(e) {
      btn.disabled = false;
      btn.innerHTML = '<i class="fas fa-cart-plus"></i>';
    }
  }
  function updateCartBadge(count) {
    document.querySelectorAll('.cart-badge').forEach(function(b) {
      b.textContent = count;
      b.style.display = count > 0 ? 'flex' : 'none';
    });
  }

  // ── WISHLIST AJAX ─────────────────────────────────────
  async function toggleWishlist(productId, btn) {
    <?php if(auth()->guard()->check()): ?>
    var res  = await fetch('/wishlist/'+productId+'/toggle', {
      method: 'POST',
      headers: {'X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>','Accept':'application/json'}
    });
    var data = await res.json();
    if (data.success) {
      var icon = btn.querySelector('i');
      btn.classList.toggle('active', data.in_wishlist);
      icon.className = data.in_wishlist ? 'fas fa-heart' : 'far fa-heart';
    }
    <?php else: ?>
    window.location = '/login';
    <?php endif; ?>
  }

  // ── DRUG INTERACTIONS ─────────────────────────────────
  async function checkCartInteractions() {
    try {
      var res  = await fetch('/interactions/cart', {headers:{'Accept':'application/json'}});
      var data = await res.json();
      if (data.has_interactions && data.interactions.length) {
        var alert = document.getElementById('interaction-alert');
        var first = data.interactions[0];
        document.getElementById('interaction-msg').textContent = first.description;
        alert.className = 'interaction-alert show interaction-severity-' + first.severity;
        setTimeout(function(){ alert.classList.remove('show'); }, 8000);
      }
    } catch(e) {}
  }

  // ── DARK MODE ─────────────────────────────────────────
  function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    var icon = document.getElementById('theme-icon');
    if (icon) icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
  }
  async function toggleTheme() {
    var current = document.documentElement.getAttribute('data-theme') || 'light';
    var next = current === 'dark' ? 'light' : 'dark';
    applyTheme(next);
    try { await fetch('/theme', {method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>'},body:JSON.stringify({theme:next})}); } catch(e){}
  }
  applyTheme(localStorage.getItem('theme') || '<?php echo e(session("theme","light")); ?>');

  // ── PWA ───────────────────────────────────────────────
  var deferredPrompt;
  window.addEventListener('beforeinstallprompt', function(e) {
    e.preventDefault(); deferredPrompt = e;
    if (!localStorage.getItem('pwa-dismissed'))
      setTimeout(function(){ document.getElementById('pwa-install-banner').classList.add('show'); }, 3000);
  });
  document.getElementById('pwa-install-btn')?.addEventListener('click', async function() {
    if (deferredPrompt) { deferredPrompt.prompt(); deferredPrompt = null; document.getElementById('pwa-install-banner').classList.remove('show'); }
  });
  if ('serviceWorker' in navigator) navigator.serviceWorker.register('/sw.js').catch(function(){});
  </script>

  <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/layouts/app.blade.php ENDPATH**/ ?>