
<div id="sidebar-overlay" onclick="closeSidebar()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:99"></div>

<aside class="admin-sidebar" id="adminSidebar">
  <div class="sidebar-logo">
    <i class="fas fa-capsules"></i>
    <span><?php echo e(app()->getLocale()==='ar'?'فارماكير':'PharmaCare'); ?></span>
    <button onclick="closeSidebar()" style="margin-start:auto;background:none;border:none;color:rgba(255,255,255,.6);cursor:pointer;font-size:18px;display:none" id="sidebar-close-btn">
      <i class="fas fa-times"></i>
    </button>
  </div>
  <nav class="sidebar-nav">
    <div class="sidebar-section"><?php echo e(app()->getLocale()==='ar'?'الرئيسية':'Main'); ?></div>
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.dashboard')?'active':''); ?>">
      <i class="fas fa-tachometer-alt"></i> <?php echo e(app()->getLocale()==='ar'?'لوحة التحكم':'Dashboard'); ?>

    </a>

    <div class="sidebar-section"><?php echo e(app()->getLocale()==='ar'?'الطلبات':'Orders'); ?></div>
    <a href="<?php echo e(route('admin.orders.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.orders*')?'active':''); ?>">
      <i class="fas fa-shopping-bag"></i> <?php echo e(app()->getLocale()==='ar'?'الطلبات':'Orders'); ?>

      <?php $pending = \App\Models\Order::where('status','pending')->count(); ?>
      <?php if($pending): ?><span class="badge-count"><?php echo e($pending); ?></span><?php endif; ?>
    </a>

    <div class="sidebar-section"><?php echo e(app()->getLocale()==='ar'?'الصيدلية':'Pharmacy'); ?></div>
    <a href="<?php echo e(route('admin.products.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.products*')?'active':''); ?>">
      <i class="fas fa-pills"></i> <?php echo e(app()->getLocale()==='ar'?'المنتجات':'Products'); ?>

    </a>
    <a href="<?php echo e(route('admin.expiry.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.expiry*')?'active':''); ?>">
      <i class="fas fa-calendar-times"></i> <?php echo e(app()->getLocale()==='ar'?'الصلاحية':'Expiry'); ?>

    </a>
    <a href="<?php echo e(route('admin.prescriptions.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.prescriptions*')?'active':''); ?>">
      <i class="fas fa-file-prescription"></i> <?php echo e(app()->getLocale()==='ar'?'الروشيتات':'Prescriptions'); ?>

      <?php $pendingRx = \App\Models\Prescription::where('status','pending')->count(); ?>
      <?php if($pendingRx): ?><span class="badge-count"><?php echo e($pendingRx); ?></span><?php endif; ?>
    </a>

    <div class="sidebar-section"><?php echo e(app()->getLocale()==='ar'?'المستخدمون':'Users'); ?></div>
    <a href="<?php echo e(route('admin.users.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.users*')?'active':''); ?>">
      <i class="fas fa-users"></i> <?php echo e(app()->getLocale()==='ar'?'إدارة المستخدمين':'Users'); ?>

    </a>

    <div class="sidebar-section"><?php echo e(app()->getLocale()==='ar'?'أخرى':'Other'); ?></div>
    <a href="<?php echo e(route('home')); ?>" class="sidebar-link" target="_blank">
      <i class="fas fa-store"></i> <?php echo e(app()->getLocale()==='ar'?'المتجر':'Store'); ?>

    </a>
    <form id="admin-logout" action="<?php echo e(route('logout')); ?>" method="POST" style="display:none"><?php echo csrf_field(); ?></form>
    <a href="#" class="sidebar-link" onclick="event.preventDefault();document.getElementById('admin-logout').submit()">
      <i class="fas fa-sign-out-alt"></i> <?php echo e(app()->getLocale()==='ar'?'خروج':'Logout'); ?>

    </a>
  </nav>
</aside>
<?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/admin/_sidebar.blade.php ENDPATH**/ ?>