<?php $__env->startSection('title', __('main.your_cart')); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="padding:40px 20px;">
  <h1 style="font-size:26px;font-weight:800;margin-bottom:28px;">
    <i class="fas fa-shopping-cart" style="color:var(--primary)"></i>
    <?php echo e(__('main.your_cart')); ?>

  </h1>

  <?php if(empty($items)): ?>
    <div class="empty-state">
      <div class="empty-state-icon">🛒</div>
      <h3><?php echo e(__('main.cart_empty')); ?></h3>
      <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary" style="margin-top:20px"><?php echo e(__('main.continue_shopping')); ?></a>
    </div>
  <?php else: ?>
    <div style="display:grid;grid-template-columns:1fr 340px;gap:28px;">
      <div>
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card" style="display:flex;align-items:center;gap:20px;margin-bottom:16px;padding:16px;">
          <a href="<?php echo e(route('shop.product', $item['product']->slug)); ?>">
            <?php if($item['product']->image): ?>
              <img src="<?php echo e(asset('storage/'.$item['product']->image)); ?>" style="width:90px;height:90px;object-fit:cover;border-radius:10px;">
            <?php else: ?>
              <div style="width:90px;height:90px;background:var(--primary-light);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:32px;color:var(--primary)"><i class="fas fa-pills"></i></div>
            <?php endif; ?>
          </a>
          <div style="flex:1">
            <div style="font-size:12px;color:var(--primary);font-weight:600;"><?php echo e($item['product']->category->name); ?></div>
            <h3 style="font-size:16px;font-weight:700;margin:4px 0"><?php echo e($item['product']->name); ?></h3>
            <?php if($item['product']->active_ingredient): ?>
              <div style="font-size:12px;color:var(--text-muted)"><i class="fas fa-atom"></i> <?php echo e($item['product']->active_ingredient); ?></div>
            <?php endif; ?>
          </div>
          <div style="display:flex;align-items:center;gap:12px;">
            <form action="<?php echo e(route('cart.update', $item['product']->id)); ?>" method="POST" style="display:flex;align-items:center;gap:6px">
              <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
              <button type="submit" name="qty" value="<?php echo e($item['qty'] - 1); ?>" class="btn btn-outline btn-sm" style="padding:4px 10px">−</button>
              <span style="font-size:16px;font-weight:700;min-width:24px;text-align:center"><?php echo e($item['qty']); ?></span>
              <button type="submit" name="qty" value="<?php echo e($item['qty'] + 1); ?>" class="btn btn-outline btn-sm" style="padding:4px 10px">+</button>
            </form>
            <span style="font-size:17px;font-weight:800;color:var(--primary);min-width:90px;text-align:end">
              <?php echo e(number_format($item['subtotal'], 2)); ?> <?php echo e(__('main.sar')); ?>

            </span>
            <a href="<?php echo e(route('cart.remove', $item['product']->id)); ?>" onclick="return confirm('Remove?')" style="color:var(--danger);font-size:16px"><i class="fas fa-trash-alt"></i></a>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      <div>
        <div class="card order-summary-card">
          <div class="card-header"><i class="fas fa-receipt"></i> <?php echo e(app()->getLocale()==='ar'?'ملخص الطلب':'Order Summary'); ?></div>
          <div class="order-row"><span><?php echo e(__('main.subtotal')); ?></span><span><?php echo e(number_format($total,2)); ?> <?php echo e(__('main.sar')); ?></span></div>
          <div class="order-row"><span><?php echo e(__('main.delivery_fee')); ?></span>
            <span><?php echo e($total >= 200 ? __('main.free') : '25.00 '.__('main.sar')); ?></span>
          </div>
          <div class="order-row" style="margin-top:8px">
            <strong><?php echo e(__('main.total')); ?></strong>
            <strong style="color:var(--primary)"><?php echo e(number_format($total + ($total >= 200 ? 0 : 25), 2)); ?> <?php echo e(__('main.sar')); ?></strong>
          </div>
          <a href="<?php echo e(route('checkout')); ?>" class="btn btn-primary btn-block" style="margin-top:20px">
            <i class="fas fa-lock"></i> <?php echo e(__('main.checkout')); ?>

          </a>
          <a href="<?php echo e(route('shop')); ?>" class="btn btn-outline btn-block" style="margin-top:10px">
            <?php echo e(__('main.continue_shopping')); ?>

          </a>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/cart/index.blade.php ENDPATH**/ ?>