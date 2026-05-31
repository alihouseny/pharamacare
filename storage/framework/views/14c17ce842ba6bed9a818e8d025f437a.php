<?php $__env->startSection('title', app()->getLocale()==='ar'?'عناوين التوصيل':'Delivery Addresses'); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="max-width:700px;padding:40px 20px;">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;">
    <h1 style="font-size:24px;font-weight:900;"><i class="fas fa-map-marker-alt" style="color:var(--primary)"></i> <?php echo e(app()->getLocale()==='ar'?'عناوين التوصيل':'Delivery Addresses'); ?></h1>
    <a href="<?php echo e(route('account.dashboard')); ?>" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> <?php echo e(__('main.back')); ?></a>
  </div>

  <?php if(session('success')): ?>
    <div class="alert alert-success" style="background:#E8F5E9;border:1.5px solid var(--success);border-radius:10px;padding:12px 16px;margin-bottom:20px;color:var(--success)">
      <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>

  
  <?php if($addresses->count()): ?>
  <div style="display:grid;gap:14px;margin-bottom:32px;">
    <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card" style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;flex-wrap:wrap;">
      <div>
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
          <span style="font-weight:800;font-size:16px;"><?php echo e($addr->label); ?></span>
          <?php if($addr->is_default): ?>
            <span class="badge badge-green"><?php echo e(app()->getLocale()==='ar'?'افتراضي':'Default'); ?></span>
          <?php endif; ?>
        </div>
        <div style="font-size:14px;color:var(--text-muted)"><?php echo e($addr->recipient_name); ?> · <?php echo e($addr->phone); ?></div>
        <div style="font-size:14px"><?php echo e($addr->street); ?>, <?php echo e($addr->city); ?><?php if($addr->area): ?>, <?php echo e($addr->area); ?><?php endif; ?></div>
      </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
  <?php endif; ?>

  
  <div class="card">
    <div class="card-header"><i class="fas fa-plus"></i> <?php echo e(app()->getLocale()==='ar'?'إضافة عنوان جديد':'Add New Address'); ?></div>
    <form action="<?php echo e(route('account.addresses.store')); ?>" method="POST">
      <?php echo csrf_field(); ?>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        <div class="form-group">
          <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'التسمية':'Label'); ?> *</label>
          <input type="text" name="label" class="form-control <?php $__errorArgs = ['label'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(app()->getLocale()==='ar'?'البيت / العمل':'Home / Work'); ?>" value="<?php echo e(old('label')); ?>">
          <?php $__errorArgs = ['label'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
          <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'اسم المستلم':'Recipient Name'); ?> *</label>
          <input type="text" name="recipient_name" class="form-control <?php $__errorArgs = ['recipient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('recipient_name')); ?>">
          <?php $__errorArgs = ['recipient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
          <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'رقم الهاتف':'Phone'); ?> *</label>
          <input type="text" name="phone" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('phone')); ?>">
          <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
          <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'المدينة':'City'); ?> *</label>
          <input type="text" name="city" class="form-control <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('city')); ?>">
          <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group" style="grid-column:1/-1">
          <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'العنوان التفصيلي':'Street Address'); ?> *</label>
          <input type="text" name="street" class="form-control <?php $__errorArgs = ['street'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('street')); ?>">
          <?php $__errorArgs = ['street'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
          <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'الحي (اختياري)':'Area (optional)'); ?></label>
          <input type="text" name="area" class="form-control" value="<?php echo e(old('area')); ?>">
        </div>
        <div class="form-group" style="display:flex;align-items:center;gap:8px;margin-top:32px">
          <input type="checkbox" name="is_default" value="1" id="is_default" <?php echo e(old('is_default')?'checked':''); ?>>
          <label for="is_default" style="margin:0;cursor:pointer"><?php echo e(app()->getLocale()==='ar'?'تعيين كعنوان افتراضي':'Set as default'); ?></label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary" style="margin-top:8px">
        <i class="fas fa-save"></i> <?php echo e(__('main.save')); ?>

      </button>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/account/addresses.blade.php ENDPATH**/ ?>