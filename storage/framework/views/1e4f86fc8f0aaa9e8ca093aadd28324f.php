<?php $__env->startSection('title', app()->getLocale()==='ar'?'الروشيتات':'Prescriptions'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-layout">
  <?php echo $__env->make('admin._sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <main class="admin-main">
    <div class="admin-topbar">
      <h1 style="font-size:20px;font-weight:800"><i class="fas fa-file-prescription"></i> <?php echo e(app()->getLocale()==='ar'?'الروشيتات':'Prescriptions'); ?></h1>
    </div>
    <div class="admin-content">
      <div class="card" style="padding:0;overflow:hidden">
        <table class="table">
          <thead><tr>
            <th>#</th>
            <th><?php echo e(app()->getLocale()==='ar'?'العميل':'Customer'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'الصورة':'Image'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'التاريخ':'Date'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'الحالة':'Status'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'إجراء':'Action'); ?></th>
          </tr></thead>
          <tbody>
            <?php $__currentLoopData = $prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td style="font-family:monospace">#<?php echo e($rx->id); ?></td>
              <td>
                <div style="font-weight:700"><?php echo e($rx->user->name); ?></div>
                <div style="font-size:12px;color:var(--text-muted)"><?php echo e($rx->user->phone); ?></div>
              </td>
              <td>
                <a href="<?php echo e(asset('storage/'.$rx->image)); ?>" target="_blank">
                  <img src="<?php echo e(asset('storage/'.$rx->image)); ?>" style="width:48px;height:48px;object-fit:cover;border-radius:6px">
                </a>
              </td>
              <td style="font-size:13px"><?php echo e($rx->created_at->format('d/m/Y H:i')); ?></td>
              <td>
                <?php $cls=['pending'=>'badge-orange','approved'=>'badge-green','rejected'=>'badge-red','used'=>'badge-gray']; ?>
                <span class="badge <?php echo e($cls[$rx->status]??'badge-gray'); ?>"><?php echo e($rx->status); ?></span>
              </td>
              <td>
                <?php if($rx->status === 'pending'): ?>
                <div style="display:flex;gap:6px">
                  <form action="<?php echo e(route('admin.prescriptions.review',$rx)); ?>" method="POST">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <input type="hidden" name="status" value="approved">
                    <button class="btn btn-primary btn-sm"><i class="fas fa-check"></i></button>
                  </form>
                  <form action="<?php echo e(route('admin.prescriptions.review',$rx)); ?>" method="POST">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <input type="hidden" name="status" value="rejected">
                    <button class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                  </form>
                </div>
                <?php else: ?>
                  <span style="font-size:13px;color:var(--text-muted)"><?php echo e($rx->pharmacist_notes ?: '—'); ?></span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
        <div style="padding:16px"><?php echo e($prescriptions->links()); ?></div>
      </div>
    </div>
  </main>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/admin/prescriptions/index.blade.php ENDPATH**/ ?>