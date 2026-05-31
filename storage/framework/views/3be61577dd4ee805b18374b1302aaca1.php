<?php $__env->startSection('title', app()->getLocale()==='ar'?'تواريخ الصلاحية':'Expiry Dates'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-layout">
  <?php echo $__env->make('admin._sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <main class="admin-main">
    <div class="admin-topbar"><button class="sidebar-toggle-btn" onclick="toggleSidebar()" style="margin-inline-end:8px"><i class="fas fa-bars"></i></button>
      <h1 style="font-size:20px;font-weight:800"><i class="fas fa-calendar-times"></i> <?php echo e(app()->getLocale()==='ar'?'تواريخ الصلاحية':'Expiry Dates'); ?></h1>
    </div>
    <div class="admin-content">

      
      <div class="stats-grid" style="margin-bottom:24px">
        <div class="stat-card">
          <div class="stat-icon red"><i class="fas fa-skull-crossbones"></i></div>
          <div><div class="stat-value expiry-danger"><?php echo e($summary['expired']); ?></div><div class="stat-label"><?php echo e(app()->getLocale()==='ar'?'منتهية الصلاحية':'Expired'); ?></div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon orange"><i class="fas fa-exclamation-triangle"></i></div>
          <div><div class="stat-value expiry-near"><?php echo e($summary['near_expiry']); ?></div><div class="stat-label"><?php echo e(app()->getLocale()==='ar'?'تنتهي خلال 90 يوم':'Expiring in 90 days'); ?></div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
          <div><div class="stat-value expiry-ok"><?php echo e($summary['ok']); ?></div><div class="stat-label"><?php echo e(app()->getLocale()==='ar'?'صالحة':'Valid'); ?></div></div>
        </div>
      </div>

      
      <div style="display:flex;gap:8px;margin-bottom:20px;">
        <?php $__currentLoopData = ['all'=>(app()->getLocale()==='ar'?'الكل':'All'),'expired'=>(app()->getLocale()==='ar'?'منتهية':'Expired'),'near'=>(app()->getLocale()==='ar'?'قريبة الانتهاء':'Near Expiry'),'ok'=>(app()->getLocale()==='ar'?'صالحة':'Valid')]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <a href="<?php echo e(route('admin.expiry.index', ['filter'=>$key])); ?>" class="btn <?php echo e($filter===$key?'btn-primary':'btn-outline'); ?> btn-sm"><?php echo e($label); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      <div class="card" style="padding:0;overflow:hidden">
        <table class="table">
          <thead><tr>
            <th><?php echo e(app()->getLocale()==='ar'?'المنتج':'Product'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'رقم الدفعة':'Batch #'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'تاريخ الإنتاج':'Manufacture'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'تاريخ الانتهاء':'Expiry Date'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'الأيام المتبقية':'Days Left'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'الكمية المتبقية':'Remaining'); ?></th>
          </tr></thead>
          <tbody>
            <?php $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td>
                <div style="font-weight:700;font-size:14px"><?php echo e($batch->product->name_ar); ?></div>
                <div style="font-size:12px;color:var(--text-muted)"><?php echo e($batch->product->active_ingredient); ?></div>
              </td>
              <td style="font-size:13px;font-family:monospace"><?php echo e($batch->batch_number); ?></td>
              <td style="font-size:13px"><?php echo e($batch->manufacture_date?->format('d/m/Y') ?? '—'); ?></td>
              <td>
                <span class="<?php echo e($batch->is_expired() ? 'expiry-danger' : ($batch->is_near_expiry() ? 'expiry-near' : 'expiry-ok')); ?>" style="font-weight:700">
                  <?php echo e($batch->expiry_date->format('d/m/Y')); ?>

                </span>
              </td>
              <td>
                <span data-expiry="<?php echo e($batch->days_until_expiry); ?>" style="font-weight:700"
                  class="<?php echo e($batch->days_until_expiry < 0 ? 'expiry-danger' : ($batch->days_until_expiry <= 30 ? 'expiry-danger' : ($batch->days_until_expiry <= 90 ? 'expiry-near' : 'expiry-ok'))); ?>">
                  <?php echo e($batch->days_until_expiry < 0 ? (app()->getLocale()==='ar'?'منتهية':'Expired') : $batch->days_until_expiry.' '.(app()->getLocale()==='ar'?'يوم':'days')); ?>

                </span>
              </td>
              <td style="font-weight:700"><?php echo e($batch->remaining_quantity); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
        <div style="padding:16px"><?php echo e($batches->links()); ?></div>
      </div>
    </div>
  </main>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/admin/expiry/index.blade.php ENDPATH**/ ?>