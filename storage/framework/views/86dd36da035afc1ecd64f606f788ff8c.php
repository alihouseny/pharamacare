<?php $__env->startSection('title', __('main.upload_prescription')); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="max-width:600px;padding:40px 20px;">
  <div class="card">
    <div class="card-header"><i class="fas fa-file-prescription" style="color:var(--info)"></i> <?php echo e(__('main.upload_prescription')); ?></div>

    <div style="background:var(--accent-light);border:1.5px solid #FFB74D;border-radius:10px;padding:16px;margin-bottom:24px;font-size:14px">
      <strong><i class="fas fa-exclamation-triangle" style="color:var(--accent)"></i>
      <?php echo e(app()->getLocale()==='ar'?'تنبيه:':'Note:'); ?></strong>
      <?php echo e(app()->getLocale()==='ar'
        ? 'يجب أن تكون الروشيتة واضحة وتحتوي على ختم الطبيب وتاريخ الكتابة'
        : 'Prescription must be clear, include doctor stamp and date'); ?>

    </div>

    <form action="<?php echo e(route('prescriptions.store')); ?>" method="POST" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <div class="form-group">
        <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'صورة الروشيتة':'Prescription Image'); ?> *</label>
        <input type="file" name="image" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*">
        <div class="form-text"><?php echo e(app()->getLocale()==='ar'?'JPG, PNG — حد أقصى 5MB':'JPG, PNG — Max 5MB'); ?></div>
        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="form-group">
        <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'ملاحظات (اختياري)':'Notes (optional)'); ?></label>
        <textarea name="notes" class="form-control" rows="3" placeholder="<?php echo e(app()->getLocale()==='ar'?'أي ملاحظات للصيدلاني...':'Any notes for the pharmacist...'); ?>"></textarea>
      </div>
      <button type="submit" class="btn btn-primary btn-block">
        <i class="fas fa-upload"></i> <?php echo e(__('main.upload_prescription')); ?>

      </button>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/prescriptions/create.blade.php ENDPATH**/ ?>