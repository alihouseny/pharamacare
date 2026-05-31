<?php $__env->startSection('title', __('main.subscriptions')); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="padding:40px 20px;">
  <h1 style="font-size:26px;font-weight:800;margin-bottom:8px;"><i class="fas fa-sync-alt" style="color:var(--primary)"></i> <?php echo e(__('main.monthly_subscription')); ?></h1>
  <p style="color:var(--text-muted);margin-bottom:32px;"><?php echo e(app()->getLocale()==='ar'?'استلم أدويتك المزمنة تلقائياً كل شهر':'Receive your chronic medicines automatically every month'); ?></p>

  <?php if($subscriptions->isEmpty()): ?>
    <div class="empty-state">
      <div class="empty-state-icon">🔄</div>
      <h3><?php echo e(app()->getLocale()==='ar'?'لا توجد اشتراكات بعد':'No subscriptions yet'); ?></h3>
      <p><?php echo e(app()->getLocale()==='ar'?'تصفح الأدوية واشترك في الأدوية التي تأخذها باستمرار':'Browse medicines and subscribe to ones you take regularly'); ?></p>
      <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary" style="margin-top:20px"><?php echo e(__('main.shop')); ?></a>
    </div>
  <?php else: ?>
    <div style="display:grid;gap:16px;">
      <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="card" style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
        <div style="flex:1">
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
            <h3 style="font-size:17px;font-weight:700;"><?php echo e($sub->product->name); ?></h3>
            <span class="badge <?php echo e($sub->status==='active'?'badge-green':($sub->status==='paused'?'badge-orange':'badge-red')); ?>">
              <?php echo e(['active'=>(app()->getLocale()==='ar'?'نشط':'Active'),'paused'=>(app()->getLocale()==='ar'?'متوقف':'Paused'),'cancelled'=>(app()->getLocale()==='ar'?'ملغي':'Cancelled')][$sub->status]); ?>

            </span>
          </div>
          <div style="font-size:14px;color:var(--text-muted)">
            <?php echo e(__('main.every_x_days', ['days' => $sub->frequency_days])); ?> ·
            <?php echo e(app()->getLocale()==='ar'?'الكمية:':'Qty:'); ?> <?php echo e($sub->quantity); ?>

          </div>
          <div style="font-size:14px;margin-top:4px;">
            <i class="fas fa-calendar-alt" style="color:var(--primary)"></i>
            <?php echo e(__('main.next_delivery')); ?>: <strong><?php echo e($sub->next_order_date->format('d M Y')); ?></strong>
          </div>
        </div>
        <div style="display:flex;gap:8px;">
          <?php if($sub->status !== 'cancelled'): ?>
            <form action="<?php echo e(route('subscriptions.toggle', $sub)); ?>" method="POST">
              <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
              <button class="btn <?php echo e($sub->status==='active'?'btn-outline':'btn-primary'); ?> btn-sm">
                <?php echo e($sub->status==='active'?__('main.pause'):(app()->getLocale()==='ar'?'استئناف':'Resume')); ?>

              </button>
            </form>
            <form action="<?php echo e(route('subscriptions.destroy', $sub)); ?>" method="POST" onsubmit="return confirm('<?php echo e(app()->getLocale()==='ar'?'تأكيد الإلغاء؟':'Confirm cancel?'); ?>')">
              <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
              <button class="btn btn-danger btn-sm"><?php echo e(__('main.cancel_subscription')); ?></button>
            </form>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/subscriptions/index.blade.php ENDPATH**/ ?>