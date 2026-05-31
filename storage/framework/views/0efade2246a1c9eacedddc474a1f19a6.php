<?php $__env->startSection('title', __('main.prescriptions')); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="padding:40px 20px;">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;">
    <h1 style="font-size:24px;font-weight:900;"><i class="fas fa-file-prescription" style="color:var(--info)"></i> <?php echo e(__('main.prescriptions')); ?></h1>
    <a href="<?php echo e(route('prescriptions.create')); ?>" class="btn btn-primary btn-sm">
      <i class="fas fa-upload"></i> <?php echo e(__('main.upload_prescription')); ?>

    </a>
  </div>

  <?php if($prescriptions->isEmpty()): ?>
    <div class="empty-state">
      <div class="empty-state-icon">📋</div>
      <h3><?php echo e(app()->getLocale()==='ar'?'لا توجد روشيتات بعد':'No prescriptions yet'); ?></h3>
      <a href="<?php echo e(route('prescriptions.create')); ?>" class="btn btn-primary" style="margin-top:20px"><?php echo e(__('main.upload_prescription')); ?></a>
    </div>
  <?php else: ?>
    <div style="display:grid;gap:16px">
      <?php $__currentLoopData = $prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="card" style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
        <a href="<?php echo e(asset('storage/'.$rx->image)); ?>" target="_blank">
          <img src="<?php echo e(asset('storage/'.$rx->image)); ?>" style="width:80px;height:80px;object-fit:cover;border-radius:10px;flex-shrink:0">
        </a>
        <div style="flex:1">
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px">
            <span style="font-weight:700"><?php echo e(app()->getLocale()==='ar'?'روشيتة':'Prescription'); ?> #<?php echo e($rx->id); ?></span>
            <?php $cls=['pending'=>'badge-orange','approved'=>'badge-green','rejected'=>'badge-red','used'=>'badge-gray']; ?>
            <span class="badge <?php echo e($cls[$rx->status]??'badge-gray'); ?>">
              <?php echo e(['pending'=>__('main.pending_review'),'approved'=>__('main.approved'),'rejected'=>__('main.rejected')][$rx->status] ?? $rx->status); ?>

            </span>
          </div>
          <div style="font-size:13px;color:var(--text-muted)"><?php echo e($rx->created_at->format('d/m/Y H:i')); ?></div>
          <?php if($rx->notes): ?>
            <div style="font-size:13px;margin-top:4px"><i class="fas fa-comment"></i> <?php echo e($rx->notes); ?></div>
          <?php endif; ?>
          <?php if($rx->pharmacist_notes): ?>
            <div style="font-size:13px;margin-top:4px;color:var(--info)"><i class="fas fa-user-md"></i> <?php echo e($rx->pharmacist_notes); ?></div>
          <?php endif; ?>
        </div>
        <?php if($rx->status === 'approved'): ?>
        <a href="<?php echo e(route('shop', ['filter'=>'rx'])); ?>" class="btn btn-primary btn-sm">
          <i class="fas fa-shopping-cart"></i> <?php echo e(__('main.shop')); ?>

        </a>
        <?php endif; ?>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div style="margin-top:20px"><?php echo e($prescriptions->links()); ?></div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/prescriptions/index.blade.php ENDPATH**/ ?>