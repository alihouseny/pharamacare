<?php $__env->startSection('title', __('main.checkout')); ?>

<?php $__env->startSection('content'); ?>
<div class="container checkout-grid">

  
  <div>
    
    <div class="checkout-section">
      <div class="card-header" style="font-size:18px;font-weight:800;margin-bottom:20px"><i class="fas fa-map-marker-alt" style="color:var(--primary)"></i> <?php echo e(__('main.delivery_address')); ?></div>
      <?php if($addresses->isEmpty()): ?>
        <div style="background:var(--accent-light);border-radius:10px;padding:16px;margin-bottom:16px;font-size:14px">
          <?php echo e(app()->getLocale()==='ar'?'لا توجد عناوين محفوظة.':'No saved addresses.'); ?>

          <a href="<?php echo e(route('account.addresses')); ?>" style="color:var(--primary);font-weight:600"><?php echo e(app()->getLocale()==='ar'?'أضف عنواناً':'Add one'); ?></a>
        </div>
      <?php else: ?>
        <div id="addresses" style="display:grid;gap:12px;margin-bottom:16px;">
          <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="address-card card" style="cursor:pointer;padding:16px;border-radius:var(--radius);border:2px solid var(--border);transition:border-color .15s">
              <input type="radio" name="address_id" form="checkout-form" value="<?php echo e($addr->id); ?>" <?php echo e($loop->first ? 'checked' : ''); ?> style="display:none">
              <div style="font-weight:700"><?php echo e($addr->label); ?></div>
              <div style="font-size:14px;color:var(--text-muted)"><?php echo e($addr->recipient_name); ?> · <?php echo e($addr->phone); ?></div>
              <div style="font-size:14px"><?php echo e($addr->street); ?>, <?php echo e($addr->city); ?></div>
            </label>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      <?php endif; ?>
    </div>

    
    <?php if($needsPrescription): ?>
    <div class="checkout-section">
      <div class="card-header" style="font-size:18px;font-weight:800;margin-bottom:20px"><i class="fas fa-file-prescription" style="color:var(--info)"></i> <?php echo e(__('main.prescriptions')); ?></div>
      <?php if($prescriptions->isEmpty()): ?>
        <div style="background:#E3F2FD;border-radius:10px;padding:16px;font-size:14px">
          <strong><?php echo e(app()->getLocale()==='ar'?'بعض المنتجات تستلزم روشيتة طبية':'Some items require a prescription'); ?></strong><br>
          <a href="<?php echo e(route('prescriptions.create')); ?>" class="btn btn-rx btn-sm" style="margin-top:10px"><?php echo e(__('main.upload_prescription')); ?></a>
        </div>
      <?php else: ?>
        <select name="prescription_id" form="checkout-form" class="form-select">
          <option value=""><?php echo e(app()->getLocale()==='ar'?'اختر الروشيتة...':'Select prescription...'); ?></option>
          <?php $__currentLoopData = $prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($rx->id); ?>"><?php echo e(app()->getLocale()==='ar'?'روشيتة':'Prescription'); ?> #<?php echo e($rx->id); ?> — <?php echo e($rx->created_at->format('d/m/Y')); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    
    <div class="checkout-section">
      <div class="card-header" style="font-size:18px;font-weight:800;margin-bottom:20px"><i class="fas fa-credit-card" style="color:var(--primary)"></i> <?php echo e(__('main.payment_method')); ?></div>
      <div style="display:grid;gap:10px;">
        <?php $__currentLoopData = ['cod'=>['icon'=>'fas fa-money-bill-wave','color'=>'var(--success)'],'card'=>['icon'=>'fas fa-credit-card','color'=>'var(--info)']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method => $cfg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <label style="display:flex;align-items:center;gap:14px;padding:16px;border:2px solid var(--border);border-radius:12px;cursor:pointer;transition:border-color .15s">
          <input type="radio" name="payment_method" form="checkout-form" value="<?php echo e($method); ?>" <?php echo e($method==='cod'?'checked':''); ?>>
          <i class="<?php echo e($cfg['icon']); ?>" style="font-size:22px;color:<?php echo e($cfg['color']); ?>"></i>
          <div>
            <div style="font-weight:700"><?php echo e(__('main.'.$method)); ?></div>
          </div>
        </label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>

    
    <div class="checkout-section">
      <textarea name="notes" form="checkout-form" class="form-control" rows="3" placeholder="<?php echo e(app()->getLocale()==='ar'?'ملاحظات للطلب (اختياري)...':'Order notes (optional)...'); ?>"></textarea>
    </div>
  </div>

  
  <div>
    <div class="card order-summary-card">
      <div class="card-header"><i class="fas fa-receipt"></i> <?php echo e(app()->getLocale()==='ar'?'ملخص الطلب':'Order Summary'); ?></div>

      <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border)">
        <?php if($item['product']->image): ?>
          <img src="<?php echo e(asset('storage/'.$item['product']->image)); ?>" style="width:52px;height:52px;object-fit:cover;border-radius:8px">
        <?php else: ?>
          <div style="width:52px;height:52px;background:var(--primary-light);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--primary)"><i class="fas fa-pills"></i></div>
        <?php endif; ?>
        <div style="flex:1">
          <div style="font-size:14px;font-weight:600"><?php echo e($item['product']->name); ?></div>
          <div style="font-size:13px;color:var(--text-muted)"><?php echo e($item['qty']); ?> × <?php echo e(number_format($item['product']->current_price,2)); ?></div>
        </div>
        <div style="font-weight:700"><?php echo e(number_format($item['subtotal'],2)); ?></div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      <div class="order-row" style="margin-top:12px"><span><?php echo e(__('main.subtotal')); ?></span><span><?php echo e(number_format($subtotal,2)); ?> <?php echo e(__('main.sar')); ?></span></div>
      <div class="order-row"><span><?php echo e(__('main.delivery_fee')); ?></span>
        <span style="color:<?php echo e($deliveryFee == 0 ? 'var(--success)' : 'inherit'); ?>">
          <?php echo e($deliveryFee == 0 ? __('main.free') : number_format($deliveryFee,2).' '.__('main.sar')); ?>

        </span>
      </div>
      <div class="order-row"><strong><?php echo e(__('main.total')); ?></strong><strong style="color:var(--primary)"><?php echo e(number_format($total,2)); ?> <?php echo e(__('main.sar')); ?></strong></div>

      <form id="checkout-form" action="<?php echo e(route('checkout.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
      </form>
      <button type="submit" form="checkout-form" class="btn btn-primary btn-block btn-lg" style="margin-top:20px">
        <i class="fas fa-lock"></i> <?php echo e(__('main.place_order')); ?>

      </button>
    </div>
  </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.address-card:has(input:checked) { border-color:var(--primary)!important; background:var(--primary-light); }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/checkout/index.blade.php ENDPATH**/ ?>