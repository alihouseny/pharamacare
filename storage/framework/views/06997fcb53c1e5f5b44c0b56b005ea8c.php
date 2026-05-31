<?php $__env->startSection('title', __('main.orders')); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="padding:40px 20px;">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;">
    <h1 style="font-size:26px;font-weight:900;">
      <i class="fas fa-list-alt" style="color:var(--primary)"></i> <?php echo e(__('main.orders')); ?>

    </h1>
    <a href="<?php echo e(route('account.dashboard')); ?>" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> <?php echo e(__('main.back')); ?></a>
  </div>

  <?php if($orders->isEmpty()): ?>
    <div class="empty-state">
      <div class="empty-state-icon">📦</div>
      <h3><?php echo e(app()->getLocale()==='ar'?'لا توجد طلبات بعد':'No orders yet'); ?></h3>
      <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary" style="margin-top:20px"><?php echo e(__('main.shop')); ?></a>
    </div>
  <?php else: ?>
    <div class="card" style="padding:0;overflow:hidden">
      <table class="table">
        <thead><tr>
          <th><?php echo e(__('main.order_number')); ?></th>
          <th><?php echo e(app()->getLocale()==='ar'?'المنتجات':'Items'); ?></th>
          <th><?php echo e(__('main.total')); ?></th>
          <th><?php echo e(__('main.order_status')); ?></th>
          <th><?php echo e(__('main.order_date')); ?></th>
          <th></th>
        </tr></thead>
        <tbody>
          <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td style="font-weight:700;font-family:monospace">
              <a href="<?php echo e(route('account.order', $order)); ?>" style="color:var(--primary)"><?php echo e($order->order_number); ?></a>
            </td>
            <td style="font-size:13px"><?php echo e($order->items->count()); ?> <?php echo e(app()->getLocale()==='ar'?'منتج':'item(s)'); ?></td>
            <td style="font-weight:700"><?php echo e(number_format($order->total,2)); ?> <?php echo e(__('main.sar')); ?></td>
            <td>
              <?php $cls=['pending'=>'badge-orange','confirmed'=>'badge-blue','preparing'=>'badge-blue','shipped'=>'badge-blue','delivered'=>'badge-green','cancelled'=>'badge-red']; ?>
              <span class="badge <?php echo e($cls[$order->status]??'badge-gray'); ?>"><?php echo e($order->status_label[app()->getLocale()]); ?></span>
            </td>
            <td style="font-size:13px;color:var(--text-muted)"><?php echo e($order->created_at->format('d/m/Y')); ?></td>
            <td><a href="<?php echo e(route('account.order', $order)); ?>" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></a></td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
      <div style="padding:16px"><?php echo e($orders->links()); ?></div>
    </div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/account/orders.blade.php ENDPATH**/ ?>