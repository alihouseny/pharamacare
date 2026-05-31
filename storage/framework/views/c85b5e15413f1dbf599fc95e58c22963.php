<header class="site-header">
  <div class="header-inner container">

    
    <a href="<?php echo e(route('home')); ?>" class="logo">
      <div class="logo-icon"><i class="fas fa-capsules"></i></div>
      <div class="logo-text">
        <span class="logo-main"><?php echo e(app()->getLocale()==='ar'?'فارماكير':'PharmaCare'); ?></span>
        <span class="logo-sub"><?php echo e(app()->getLocale()==='ar'?'صحتك تبدأ هنا':'Your Health Starts Here'); ?></span>
      </div>
    </a>

    
    <form action="<?php echo e(route('shop')); ?>" method="GET" class="search-bar" style="flex:1;max-width:480px;">
      <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="<?php echo e(__('main.search_by')); ?>">
      <button type="submit"><i class="fas fa-search"></i></button>
    </form>

    
    <div class="header-actions">

      
      <a href="<?php echo e(route('lang', app()->getLocale()==='ar'?'en':'ar')); ?>" class="action-btn" style="padding:8px 12px;font-weight:700">
        <?php echo e(app()->getLocale()==='ar'?'EN':'ع'); ?>

      </a>

      
      <a href="<?php echo e(route('cart')); ?>" class="action-btn cart-btn" style="position:relative">
        <i class="fas fa-shopping-cart"></i>
        <?php $cartCount = array_sum(array_column(session()->get('cart',[]),'qty')); ?>
        <?php if($cartCount > 0): ?>
          <span class="cart-badge"><?php echo e($cartCount); ?></span>
        <?php endif; ?>
      </a>

      <?php if(auth()->guard()->check()): ?>
        
        <div class="nav-dropdown-wrap">
          <button class="action-btn nav-dropdown-toggle" style="gap:6px" onclick="toggleNavDropdown(event)">
            <i class="fas fa-user-circle" style="font-size:18px"></i>
            <span style="font-size:14px;max-width:90px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?php echo e(explode(' ', auth()->user()->name)[0]); ?></span>
            <i class="fas fa-chevron-down" style="font-size:10px"></i>
          </button>
          <div class="nav-dropdown-menu" id="navDropdownMenu">
            <div class="nav-dropdown-header">
              <div style="font-weight:800;font-size:15px"><?php echo e(auth()->user()->name); ?></div>
              <div style="font-size:12px;color:var(--text-muted)"><?php echo e(auth()->user()->email); ?></div>
              <?php if(auth()->user()->isPharmacist()): ?>
                <span style="display:inline-block;margin-top:4px;background:var(--accent);color:#fff;font-size:11px;padding:2px 8px;border-radius:20px;font-weight:700">
                  <?php echo e(app()->getLocale()==='ar'?'صيدلاني / أدمن':'Pharmacist'); ?>

                </span>
              <?php endif; ?>
            </div>

            <a href="<?php echo e(route('account.dashboard')); ?>" class="nav-dropdown-item">
              <i class="fas fa-tachometer-alt" style="color:var(--primary)"></i>
              <?php echo e(__('main.my_account')); ?>

            </a>
            <a href="<?php echo e(route('account.orders')); ?>" class="nav-dropdown-item">
              <i class="fas fa-list-alt" style="color:var(--primary)"></i>
              <?php echo e(__('main.orders')); ?>

            </a>
            <a href="<?php echo e(route('prescriptions.index')); ?>" class="nav-dropdown-item">
              <i class="fas fa-file-prescription" style="color:var(--info)"></i>
              <?php echo e(__('main.prescriptions')); ?>

            </a>
            <a href="<?php echo e(route('subscriptions.index')); ?>" class="nav-dropdown-item">
              <i class="fas fa-sync-alt" style="color:var(--success)"></i>
              <?php echo e(__('main.subscriptions')); ?>

            </a>
            <a href="<?php echo e(route('account.addresses')); ?>" class="nav-dropdown-item">
              <i class="fas fa-map-marker-alt" style="color:var(--accent)"></i>
              <?php echo e(app()->getLocale()==='ar'?'عناويني':'My Addresses'); ?>

            </a>
            <a href="<?php echo e(route('profile.edit')); ?>" class="nav-dropdown-item">
              <i class="fas fa-user-edit" style="color:var(--text-muted)"></i>
              <?php echo e(app()->getLocale()==='ar'?'تعديل الملف الشخصي':'Edit Profile'); ?>

            </a>

            <?php if(auth()->user()->isPharmacist()): ?>
              <div class="nav-dropdown-divider"></div>
              <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-dropdown-item" style="color:var(--accent);font-weight:700">
                <i class="fas fa-cog" style="color:var(--accent)"></i>
                <?php echo e(app()->getLocale()==='ar'?'لوحة التحكم':'Admin Panel'); ?>

              </a>
            <?php endif; ?>

            <div class="nav-dropdown-divider"></div>
            <form action="<?php echo e(route('logout')); ?>" method="POST">
              <?php echo csrf_field(); ?>
              <button type="submit" class="nav-dropdown-item nav-dropdown-logout">
                <i class="fas fa-sign-out-alt"></i>
                <?php echo e(__('main.logout')); ?>

              </button>
            </form>
          </div>
        </div>

      <?php else: ?>
        <a href="<?php echo e(route('login')); ?>" class="action-btn" style="font-size:14px">
          <i class="fas fa-sign-in-alt"></i> <?php echo e(__('main.login')); ?>

        </a>
        <a href="<?php echo e(route('register')); ?>" class="btn btn-primary btn-sm"><?php echo e(__('main.register')); ?></a>
      <?php endif; ?>
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
<?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>