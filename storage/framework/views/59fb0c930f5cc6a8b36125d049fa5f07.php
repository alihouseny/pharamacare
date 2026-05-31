<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e(app()->getLocale()==='ar'?'rtl':'ltr'); ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title><?php echo $__env->yieldContent('title', config('app.name')); ?> — <?php echo e(app()->getLocale()==='ar'?'فارماكير':'PharmaCare'); ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="<?php echo e(asset('css/pharmacy.css')); ?>">
  <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="<?php echo e(app()->getLocale()==='ar'?'rtl':'ltr'); ?>">

  <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <?php if(session('success')): ?>
    <div style="background:#E8F5E9;border-bottom:2px solid var(--success);padding:12px 20px;text-align:center;color:var(--success);font-weight:600;font-size:14px">
      <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>
  <?php if(session('error')): ?>
    <div style="background:#FFEBEE;border-bottom:2px solid var(--danger);padding:12px 20px;text-align:center;color:var(--danger);font-weight:600;font-size:14px">
      <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

    </div>
  <?php endif; ?>

  <main style="min-height:60vh">
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo e($slot ?? ''); ?>

  </main>

  <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  
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

  <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/layouts/app.blade.php ENDPATH**/ ?>